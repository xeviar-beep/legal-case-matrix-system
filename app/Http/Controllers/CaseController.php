<?php

namespace App\Http\Controllers;

use App\Models\CaseModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CaseController extends Controller
{
    /**
     * Display a listing of the cases.
     */
    public function index(Request $request)
    {
        $query = CaseModel::with('user');

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by section
        if ($request->has('section') && $request->section != '') {
            $query->where('section', $request->section);
        }

        // Filter by court
        if ($request->has('court') && $request->court != '') {
            $query->where('court_agency', $request->court);
        }

        // Filter by region
        if ($request->has('region') && $request->region != '') {
            $query->where('region', $request->region);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('case_number', 'like', "%{$search}%")
                  ->orWhere('case_title', 'like', "%{$search}%")
                  ->orWhere('client_name', 'like', "%{$search}%");
            });
        }

        // Sort by case_number: Numeric cases first (1, 2, 3... 25), then letter-prefixed cases (D1, D2, D3)
        // Both groups sorted in ascending order by their numeric portion
        $cases = $query->orderByRaw("
            CASE 
                WHEN case_number REGEXP '^[A-Za-z]' THEN 1 
                ELSE 0 
            END,
            CAST(REGEXP_REPLACE(case_number, '[^0-9]', '') AS UNSIGNED),
            case_number
        ")->get();

        return view('cases.index', compact('cases'));
    }

    /**
     * Show the form for creating a new case.
     */
    public function create()
    {
        return view('cases.create');
    }

    /**
     * Store a newly created case in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'case_number' => 'nullable|string|unique:cases,case_number',
                'docket_no' => 'nullable|string',
                'old_folder_no' => 'nullable|string',
                'case_title' => 'nullable|string',
                'client_name' => 'nullable|string',
                'case_type' => 'nullable|string',
                'section' => 'nullable|in:Criminal,Civil,Labor,Administrative,Special/IP,OJ',
                'court_agency' => 'nullable|in:SC,CA,RTC,MTC,OMB,ADMIN,NCIP,REGIONS,OJ,Others',
                'region' => 'nullable|in:NCR,Region I,Region II,Region III,Region IV-A,Region IV-B,Region V,Region VI,Region VII,Region VIII,Region IX,Region X,Region XI,Region XII,Region XIII,BARMM',
                'assigned_lawyer' => 'nullable|string',
                'handling_counsel_ncip' => 'nullable|string',
                'date_filed' => 'nullable|date',
                'deadline_days' => 'nullable|integer|min:1',
                'hearing_date' => 'nullable|date',
                'actions_taken' => 'nullable|string',
                'notes' => 'nullable|string',
                // Agency-specific fields
                'action' => 'nullable|string',
                'issues_grounds' => 'nullable|string',
                'prayers_relief' => 'nullable|string',
                'new_sc_no' => 'nullable|string',
                'remarks' => 'nullable|string',
                'optional_blank_section' => 'nullable|string',
            ], [
                'case_number.unique' => 'This Case Number already exists',
            ]);

            $validated['user_id'] = auth()->id();

            $case = CaseModel::create($validated);
            
            Log::info('Case created successfully', ['case_id' => $case->id, 'case_number' => $case->case_number]);

            return redirect()->route('cases.index')
                ->with('success', 'Case created successfully!');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Case creation failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->route('cases.index')
                ->with('error', 'Failed to create case: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified case.
     */
    public function show(CaseModel $case)
    {
        // Load documents with uploader information
        $case->load(['documents.uploader']);
        
        return view('cases.show', compact('case'));
    }

    /**
     * Show the form for editing the specified case.
     */
    public function edit(CaseModel $case)
    {
        return view('cases.edit', compact('case'));
    }

    /**
     * Update the specified case in storage.
     */
    public function update(Request $request, CaseModel $case)
    {
        $validated = $request->validate([
            'case_number' => 'nullable|string',
            'docket_no' => 'nullable|string',
            'old_folder_no' => 'nullable|string',
            'case_title' => 'nullable|string',
            'client_name' => 'nullable|string',
            'case_type' => 'nullable|string',
            'section' => 'nullable|in:Criminal,Civil,Labor,Administrative,Special/IP,OJ',
            'court_agency' => 'nullable|in:SC,CA,RTC,MTC,OMB,ADMIN,NCIP,REGIONS,OJ,Others',
            'region' => 'nullable|in:NCR,Region I,Region II,Region III,Region IV-A,Region IV-B,Region V,Region VI,Region VII,Region VIII,Region IX,Region X,Region XI,Region XII,Region XIII,BARMM',
            'assigned_lawyer' => 'nullable|string',
            'handling_counsel_ncip' => 'nullable|string',
            'date_filed' => 'nullable|date',
            'deadline_days' => 'nullable|integer|min:1',
            'hearing_date' => 'nullable|date',
            'status' => 'nullable|in:active,due_soon,overdue,completed,archived',
            'actions_taken' => 'nullable|string',
            'notes' => 'nullable|string',
            // Agency-specific fields
            'action' => 'nullable|string',
            'issues_grounds' => 'nullable|string',
            'prayers_relief' => 'nullable|string',
            'new_sc_no' => 'nullable|string',
            'remarks' => 'nullable|string',
            'optional_blank_section' => 'nullable|string',
        ]);

        $case->update($validated);

        return redirect()->route('cases.index')
            ->with('success', 'Case updated successfully!');
    }

    /**
     * Remove the specified case from storage.
     */
    public function destroy(CaseModel $case)
    {
        $case->delete();

        return redirect()->route('cases.index')
            ->with('success', 'Case deleted successfully!');
    }

    /**
     * Delete all cases with confirmation
     */
    public function destroyAll(Request $request)
    {
        // Validate the confirmation input
        $request->validate([
            'confirmation' => 'required|in:DELETE ALL CASES'
        ], [
            'confirmation.required' => 'Please type the confirmation text.',
            'confirmation.in' => 'Confirmation text does not match. Please type exactly: DELETE ALL CASES'
        ]);

        try {
            // Get count before deletion
            $count = CaseModel::count();
            
            // Disable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            
            // Truncate related tables first
            DB::table('documents')->truncate();
            DB::table('reminders')->truncate();
            
            // Truncate cases table
            DB::table('cases')->truncate();
            
            // Re-enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            
            return redirect()->route('cases.index')
                ->with('success', "Successfully deleted all {$count} case(s) and their related data from the system.");
        } catch (\Exception $e) {
            return redirect()->route('cases.index')
                ->with('error', 'Failed to delete all cases. Error: ' . $e->getMessage());
        }
    }

    /**
     * Get real case data for test notification
     */
    public function getTestNotificationData(Request $request)
    {
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        
        // Helper function to shorten case title for notifications
        $shortenTitle = function($title) {
            // Try to extract first party vs second party
            if (strpos($title, ' vs. ') !== false || strpos($title, ' vs ') !== false) {
                $parts = preg_split('/ vs\.? /i', $title);
                if (count($parts) >= 2) {
                    // Get first name from each side
                    $firstParty = trim(explode(',', $parts[0])[0]);
                    $secondParty = trim(explode(',', $parts[1])[0]);
                    return $firstParty . ' vs. ' . $secondParty;
                }
            }
            // If no "vs" pattern, just truncate to 60 characters
            return strlen($title) > 60 ? substr($title, 0, 60) . '...' : $title;
        };
        
        // Check if there are any cases at all
        $totalCases = CaseModel::count();
        
        if ($totalCases === 0) {
            return response()->json([
                'success' => true,
                'hasData' => false,
                'notification' => [
                    'title' => '📭 No Active Cases',
                    'body' => 'There are currently no cases in the system.',
                    'requireInteraction' => false
                ]
            ]);
        }
        
        // Try to find an overdue case
        $overdueCase = CaseModel::where('deadline_date', '<', $today)
            ->where('status', '!=', 'completed')
            ->where('status', '!=', 'archived')
            ->orderBy('deadline_date', 'asc')
            ->first();
        
        if ($overdueCase) {
            $daysOverdue = Carbon::parse($overdueCase->deadline_date)->diffInDays($today);
            $shortTitle = $shortenTitle($overdueCase->case_title);
            return response()->json([
                'success' => true,
                'hasData' => true,
                'case_id' => $overdueCase->id,
                'notification' => [
                    'title' => '🚨 Case Overdue!',
                    'body' => "Case #{$overdueCase->case_number}: {$shortTitle} - Overdue by {$daysOverdue} day(s).",
                    'requireInteraction' => true
                ]
            ]);
        }
        
        // Try to find a case with deadline tomorrow
        $tomorrowCase = CaseModel::whereDate('deadline_date', $tomorrow)
            ->where('status', '!=', 'completed')
            ->where('status', '!=', 'archived')
            ->first();
        
        if ($tomorrowCase) {
            $shortTitle = $shortenTitle($tomorrowCase->case_title);
            return response()->json([
                'success' => true,
                'hasData' => true,
                'case_id' => $tomorrowCase->id,
                'notification' => [
                    'title' => '⏰ Deadline Tomorrow',
                    'body' => "Case #{$tomorrowCase->case_number}: {$shortTitle} - Deadline is tomorrow.",
                    'requireInteraction' => false
                ]
            ]);
        }
        
        // Try to find a case with deadline today
        $todayCase = CaseModel::whereDate('deadline_date', $today)
            ->where('status', '!=', 'completed')
            ->where('status', '!=', 'archived')
            ->first();
        
        if ($todayCase) {
            $shortTitle = $shortenTitle($todayCase->case_title);
            return response()->json([
                'success' => true,
                'hasData' => true,
                'case_id' => $todayCase->id,
                'notification' => [
                    'title' => '📅 Deadline Today',
                    'body' => "Case #{$todayCase->case_number}: {$shortTitle} - Deadline is today!",
                    'requireInteraction' => true
                ]
            ]);
        }
        
        // Get any active case
        $anyCase = CaseModel::where('status', '!=', 'completed')
            ->where('status', '!=', 'archived')
            ->orderBy('created_at', 'desc')
            ->first();
        
        if ($anyCase) {
            $shortTitle = $shortenTitle($anyCase->case_title);
            $statusLabel = ucfirst(str_replace('_', ' ', $anyCase->status));
            $deadlineInfo = $anyCase->deadline_date 
                ? ' - Deadline: ' . Carbon::parse($anyCase->deadline_date)->format('M d, Y')
                : '';
            
            return response()->json([
                'success' => true,
                'hasData' => true,
                'case_id' => $anyCase->id,
                'notification' => [
                    'title' => '📋 Active Case',
                    'body' => "Case #{$anyCase->case_number}: {$shortTitle} - Status: {$statusLabel}{$deadlineInfo}",
                    'requireInteraction' => false
                ]
            ]);
        }
        
        // All cases are closed/dismissed
        return response()->json([
            'success' => true,
            'hasData' => false,
            'notification' => [
                'title' => '✅ All Cases Completed',
                'body' => "All {$totalCases} case(s) in the system are completed or archived.",
                'requireInteraction' => false
            ]
        ]);
    }

    /**
     * Display case information overview with all details
     */
    public function information()
    {
        $cases = CaseModel::with(['documents', 'user'])
            ->orderByRaw("
                CASE 
                    WHEN case_number REGEXP '^[A-Za-z]' THEN 1 
                    ELSE 0 
                END,
                CAST(REGEXP_REPLACE(case_number, '[^0-9]', '') AS UNSIGNED),
                case_number
            ")
            ->get();

        return view('cases.information', compact('cases'));
    }

    /**
     * Display sections overview
     */
    public function sections()
    {
        $sections = ['Criminal', 'Civil', 'Labor', 'Administrative', 'Special/IP', 'OJ'];
        $stats = [];

        foreach ($sections as $section) {
            $stats[$section] = [
                'total' => CaseModel::where('section', $section)->count(),
                'overdue' => CaseModel::where('section', $section)->overdue()->count(),
                'due_soon' => CaseModel::where('section', $section)->dueSoon(7)->count(),
                'active' => CaseModel::where('section', $section)->active()->count(),
            ];
        }

        return view('sections.index', compact('sections', 'stats'));
    }

    /**
     * Filter cases by section
     */
    public function bySection($section)
    {
        $section = urldecode($section);
        
        $cases = CaseModel::where('section', $section)
            ->orderBy('deadline_date', 'asc')
            ->paginate(20);

        $stats = [
            'total' => CaseModel::where('section', $section)->count(),
            'overdue' => CaseModel::where('section', $section)->overdue()->count(),
            'due_soon' => CaseModel::where('section', $section)->dueSoon(7)->count(),
        ];

        return view('sections.show', compact('section', 'cases', 'stats'));
    }

    /**
     * Display courts & agencies overview
     */
    public function courts()
    {
        $courts = ['SC', 'CA', 'RTC', 'OMB', 'NCIP', 'Special/IP', 'Other'];
        $stats = [];

        foreach ($courts as $court) {
            $stats[$court] = [
                'total' => CaseModel::where('court_agency', $court)->count(),
                'overdue' => CaseModel::where('court_agency', $court)->overdue()->count(),
                'due_soon' => CaseModel::where('court_agency', $court)->dueSoon(7)->count(),
                'active' => CaseModel::where('court_agency', $court)->active()->count(),
            ];
        }

        return view('courts.index', compact('courts', 'stats'));
    }

    /**
     * Filter cases by court/agency
     */
    public function byCourt($court)
    {
        $court = urldecode($court);
        
        $courtNames = [
            'SC' => 'Supreme Court',
            'CA' => 'Court of Appeals',
            'RTC' => 'Regional Trial Court',
            'OMB' => 'Office of the Ombudsman',
            'NCIP' => 'National Commission on Indigenous Peoples',
            'Special/IP' => 'Special Cases & Intellectual Property',
            'Other' => 'Other Agencies'
        ];

        $cases = CaseModel::where('court_agency', $court)
            ->orderBy('deadline_date', 'asc')
            ->paginate(20);

        $stats = [
            'total' => CaseModel::where('court_agency', $court)->count(),
            'overdue' => CaseModel::where('court_agency', $court)->overdue()->count(),
            'due_soon' => CaseModel::where('court_agency', $court)->dueSoon(7)->count(),
        ];

        $courtName = $courtNames[$court] ?? $court;

        return view('courts.show', compact('court', 'courtName', 'cases', 'stats'));
    }

    /**
     * Display regions overview
     */
    public function regions()
    {
        $regions = ['NCR', 'Region I', 'Region II', 'Region III', 'Region IV-A', 'Region IV-B', 
                    'Region V', 'Region VI', 'Region VII', 'Region VIII', 'Region IX', 'Region X', 
                    'Region XI', 'Region XII', 'Region XIII', 'BARMM'];
        $stats = [];

        foreach ($regions as $region) {
            $stats[$region] = [
                'total' => CaseModel::where('region', $region)->count(),
                'overdue' => CaseModel::where('region', $region)->overdue()->count(),
                'due_soon' => CaseModel::where('region', $region)->dueSoon(7)->count(),
                'active' => CaseModel::where('region', $region)->active()->count(),
            ];
        }

        return view('regions.index', compact('regions', 'stats'));
    }

    /**
     * Filter cases by region
     */
    public function byRegion($region)
    {
        $cases = CaseModel::where('region', $region)
            ->orderBy('deadline_date', 'asc')
            ->paginate(20);

        $stats = [
            'total' => CaseModel::where('region', $region)->count(),
            'overdue' => CaseModel::where('region', $region)->overdue()->count(),
            'due_soon' => CaseModel::where('region', $region)->dueSoon(7)->count(),
        ];

        return view('regions.show', compact('region', 'cases', 'stats'));
    }

    /**
     * Display deadlines overview
     */
    public function deadlines()
    {
        $overdueCases = CaseModel::overdue()
            ->orderBy('deadline_date', 'asc')
            ->get();
        
        $dueTodayCases = CaseModel::where('deadline_date', now()->toDateString())
            ->active()
            ->orderBy('deadline_date', 'asc')
            ->get();
        
        $dueTomorrowCases = CaseModel::where('deadline_date', now()->addDay()->toDateString())
            ->active()
            ->orderBy('deadline_date', 'asc')
            ->get();
        
        $dueThisWeekCases = CaseModel::whereBetween('deadline_date', [
                now()->toDateString(),
                now()->endOfWeek()->toDateString()
            ])
            ->active()
            ->orderBy('deadline_date', 'asc')
            ->get();
        
        $dueNextWeekCases = CaseModel::whereBetween('deadline_date', [
                now()->addWeek()->startOfWeek()->toDateString(),
                now()->addWeek()->endOfWeek()->toDateString()
            ])
            ->active()
            ->orderBy('deadline_date', 'asc')
            ->get();
        
        $dueThisMonthCases = CaseModel::whereBetween('deadline_date', [
                now()->startOfMonth()->toDateString(),
                now()->endOfMonth()->toDateString()
            ])
            ->active()
            ->orderBy('deadline_date', 'asc')
            ->paginate(20);

        $stats = [
            'overdue' => $overdueCases->count(),
            'today' => $dueTodayCases->count(),
            'tomorrow' => $dueTomorrowCases->count(),
            'this_week' => $dueThisWeekCases->count(),
            'next_week' => $dueNextWeekCases->count(),
            'this_month' => $dueThisMonthCases->total(),
        ];

        return view('deadlines.index', compact(
            'overdueCases',
            'dueTodayCases',
            'dueTomorrowCases',
            'dueThisWeekCases',
            'dueNextWeekCases',
            'dueThisMonthCases',
            'stats'
        ));
    }

    /**
     * Display notifications page
     */
    public function notifications()
    {
        // Get critical notifications (overdue cases)
        $criticalNotifications = CaseModel::overdue()
            ->orderBy('deadline_date', 'asc')
            ->get()
            ->map(function($case) {
                return [
                    'id' => $case->id,
                    'type' => 'critical',
                    'title' => 'OVERDUE: ' . $case->case_number,
                    'message' => 'Case "' . $case->case_title . '" deadline passed ' . abs($case->remaining_days) . ' days ago.',
                    'case' => $case,
                    'created_at' => $case->deadline_date,
                    'read' => false,
                ];
            });

        // Get warning notifications (due within 7 days)
        $warningNotifications = CaseModel::dueSoon(7)
            ->orderBy('deadline_date', 'asc')
            ->get()
            ->map(function($case) {
                return [
                    'id' => $case->id,
                    'type' => 'warning',
                    'title' => 'Due Soon: ' . $case->case_number,
                    'message' => 'Case "' . $case->case_title . '" deadline in ' . $case->remaining_days . ' days.',
                    'case' => $case,
                    'created_at' => $case->deadline_date,
                    'read' => false,
                ];
            });

        // Get hearing notifications (hearings today)
        $hearingNotifications = CaseModel::hearingToday()
            ->orderBy('hearing_date', 'asc')
            ->get()
            ->map(function($case) {
                return [
                    'id' => $case->id,
                    'type' => 'info',
                    'title' => 'Hearing Today: ' . $case->case_number,
                    'message' => 'Case "' . $case->case_title . '" has a hearing scheduled today.',
                    'case' => $case,
                    'created_at' => $case->hearing_date,
                    'read' => false,
                ];
            });

        // Merge all notifications
        $allNotifications = $criticalNotifications
            ->concat($warningNotifications)
            ->concat($hearingNotifications)
            ->sortByDesc('created_at');

        $stats = [
            'total' => $allNotifications->count(),
            'critical' => $criticalNotifications->count(),
            'warning' => $warningNotifications->count(),
            'info' => $hearingNotifications->count(),
            'unread' => $allNotifications->where('read', false)->count(),
        ];

        return view('notifications.index', compact('allNotifications', 'stats'));
    }

    /**
     * Mark notification as read (placeholder for future implementation)
     */
    public function markNotificationRead($id)
    {
        // This is a placeholder - in a real implementation, 
        // you would update a notifications table
        return response()->json(['success' => true]);
    }

    /**
     * Get notifications data as JSON for real-time updates
     */
    public function getNotificationsData()
    {
        // Get critical notifications (overdue cases)
        $criticalNotifications = CaseModel::overdue()
            ->orderBy('deadline_date', 'asc')
            ->limit(10)
            ->get()
            ->map(function($case) {
                return [
                    'id' => $case->id,
                    'type' => 'critical',
                    'icon' => 'exclamation-triangle',
                    'icon_bg' => 'bg-danger',
                    'case_number' => $case->case_number,
                    'title' => 'Case #' . $case->case_number . ' is overdue',
                    'message' => 'Deadline passed ' . abs($case->remaining_days) . ' days ago',
                    'time' => \Carbon\Carbon::parse($case->deadline_date)->diffForHumans(),
                    'url' => route('cases.show', $case->id),
                    'created_at' => $case->deadline_date,
                ];
            });

        // Get warning notifications (due within 7 days)
        $warningNotifications = CaseModel::dueSoon(7)
            ->orderBy('deadline_date', 'asc')
            ->limit(10)
            ->get()
            ->map(function($case) {
                return [
                    'id' => $case->id,
                    'type' => 'warning',
                    'icon' => 'clock',
                    'icon_bg' => 'bg-warning',
                    'case_number' => $case->case_number,
                    'title' => 'Case #' . $case->case_number . ' deadline is tomorrow',
                    'message' => 'Deadline in ' . $case->remaining_days . ' days',
                    'time' => \Carbon\Carbon::parse($case->deadline_date)->diffForHumans(),
                    'url' => route('cases.show', $case->id),
                    'created_at' => $case->deadline_date,
                ];
            });

        // Get hearing notifications (hearings today)
        $hearingNotifications = CaseModel::hearingToday()
            ->orderBy('hearing_date', 'asc')
            ->limit(5)
            ->get()
            ->map(function($case) {
                return [
                    'id' => $case->id,
                    'type' => 'info',
                    'icon' => 'check-circle',
                    'icon_bg' => 'bg-success',
                    'case_number' => $case->case_number,
                    'title' => 'Case #' . $case->case_number . ' hearing today',
                    'message' => 'Hearing scheduled for today',
                    'time' => \Carbon\Carbon::parse($case->hearing_date)->diffForHumans(),
                    'url' => route('cases.show', $case->id),
                    'created_at' => $case->hearing_date,
                ];
            });

        // Merge and sort all notifications
        $allNotifications = $criticalNotifications
            ->concat($warningNotifications)
            ->concat($hearingNotifications)
            ->sortByDesc('created_at')
            ->take(10)
            ->values();

        return response()->json([
            'notifications' => $allNotifications,
            'count' => $allNotifications->count(),
            'unread' => $allNotifications->count(), // All notifications are considered unread for now
        ]);
    }

    /**
     * Export cases to Excel (CSV format)
     */
    public function exportExcel(Request $request)
    {
        $query = CaseModel::with('user');

        // Apply filters
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('case_number', 'like', "%{$search}%")
                  ->orWhere('case_title', 'like', "%{$search}%")
                  ->orWhere('client_name', 'like', "%{$search}%");
            });
        }

        $cases = $query->orderBy('deadline_date', 'asc')->get();

        $filename = 'cases_export_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($cases) {
            $file = fopen('php://output', 'w');
            
            // UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header row (matching database schema order)
            fputcsv($file, [
                'Case Number',
                'Docket No',
                'Old Folder No',
                'Case Title',
                'Client Name',
                'Case Type',
                'Section',
                'Court/Agency',
                'Region',
                'Assigned Lawyer',
                'Handling Counsel (NCIP)',
                'Date Filed',
                'Deadline Days',
                'Hearing Date',
                'Status',
                'Notes',
                'Actions Taken',
                'Action',
                'Issues/Grounds',
                'Prayers (Relief)',
                'New SC No',
                'Remarks',
            ]);

            // Data rows
            foreach ($cases as $case) {
                $deadlineDate = $case->deadline_date ? Carbon::parse($case->deadline_date) : null;
                $deadlineDays = $case->deadline_days ?? '';

                fputcsv($file, [
                    $case->case_number,
                    $case->docket_no ?? '',
                    $case->old_folder_no ?? '',
                    $case->case_title,
                    $case->client_name ?? '',
                    $case->case_type ?? '',
                    $case->section ?? '',
                    $case->court_agency ?? '',
                    $case->region ?? '',
                    $case->assigned_lawyer ?? '',
                    $case->handling_counsel_ncip ?? '',
                    $case->date_filed ? Carbon::parse($case->date_filed)->format('Y-m-d') : '',
                    $deadlineDays,
                    $case->hearing_date ? Carbon::parse($case->hearing_date)->format('Y-m-d') : '',
                    $case->status ?? 'active',
                    $case->notes ?? '',
                    $case->actions_taken ?? '',
                    $case->action ?? '',
                    $case->issues_grounds ?? '',
                    $case->prayers_relief ?? '',
                    $case->new_sc_no ?? '',
                    $case->remarks ?? '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export cases to PDF
     */
    public function exportPdf(Request $request)
    {
        $query = CaseModel::with('user');

        // Apply filters
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('case_number', 'like', "%{$search}%")
                  ->orWhere('case_title', 'like', "%{$search}%")
                  ->orWhere('client_name', 'like', "%{$search}%");
            });
        }

        $cases = $query->orderBy('deadline_date', 'asc')->get();

        // Add computed fields
        $cases->each(function($case) {
            $deadlineDate = Carbon::parse($case->deadline_date);
            $case->days_remaining = now()->diffInDays($deadlineDate, false);
            
            if ($case->days_remaining < 0) {
                $case->priority = 'Overdue';
            } elseif ($case->days_remaining <= 7) {
                $case->priority = 'Urgent';
            } elseif ($case->days_remaining <= 14) {
                $case->priority = 'High';
            } else {
                $case->priority = 'Normal';
            }
        });

        $pdf = Pdf::loadView('cases.export-pdf', compact('cases'));
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf->download('cases_export_' . date('Y-m-d_His') . '.pdf');
    }

    /**
     * Import cases from Excel/CSV file using intelligent categorization
     * 
     * @param \App\Http\Requests\ImportFileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importExcel(\App\Http\Requests\ImportFileRequest $request)
    {
        try {
            $file = $request->file('import_file');
            
            // Use the ImportService for intelligent import
            $importService = new \App\Services\ImportService();
            $importLog = $importService->importFile($file, auth()->id());
            
            // Prepare response message
            $message = $importLog->getSummary();
            
            // Determine flash message type
            if ($importLog->status === 'failed') {
                return back()->with('error', 'Import failed. ' . $message);
            }
            
            if ($importLog->hasFlaggedRecords()) {
                return redirect()->route('cases.import.flagged', $importLog->id)
                    ->with('warning', $message . ' Please review flagged records.');
            }
            
            if ($importLog->hasErrors()) {
                return back()->with([
                    'warning' => $message,
                    'import_errors' => $importLog->errors,
                    'import_log_id' => $importLog->id,
                ]);
            }
            
            return back()->with('success', $message);
            
        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    /**
     * Import multiple Excel/CSV files at once
     * 
     * @param \App\Http\Requests\ImportMultipleFilesRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importMultipleFiles(\App\Http\Requests\ImportMultipleFilesRequest $request)
    {
        try {
            $files = $request->file('import_files');
            $importService = new \App\Services\ImportService();
            $importLogs = [];
            
            foreach ($files as $file) {
                $importLog = $importService->importFile($file, auth()->id());
                $importLogs[] = $importLog;
            }
            
            // Aggregate results
            $totalSuccess = collect($importLogs)->sum('successful_imports');
            $totalFailed = collect($importLogs)->sum('failed_imports');
            $totalFlagged = collect($importLogs)->sum('flagged_records');
            
            $message = "Batch import completed! {$totalSuccess} records imported from " . count($files) . " files.";
            
            if ($totalFailed > 0) {
                $message .= " {$totalFailed} records failed.";
            }
            
            if ($totalFlagged > 0) {
                $message .= " {$totalFlagged} records flagged for review.";
                return redirect()->route('cases.import.history')
                    ->with('warning', $message);
            }
            
            return back()->with('success', $message);
            
        } catch (\Exception $e) {
            return back()->with('error', 'Batch import failed: ' . $e->getMessage());
        }
    }

    /**
     * View import history
     * 
     * @return \Illuminate\View\View
     */
    public function importHistory()
    {
        $importLogs = \App\Models\ImportLog::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('cases.import-history', compact('importLogs'));
    }

    /**
     * View details of a specific import
     * 
     * @param int $id Import log ID
     * @return \Illuminate\View\View
     */
    public function importDetails($id)
    {
        $importLog = \App\Models\ImportLog::with('user')->findOrFail($id);
        
        return view('cases.import-details', compact('importLog'));
    }

    /**
     * View flagged records from an import
     * 
     * @param int $id Import log ID
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function importFlagged($id)
    {
        $importLog = \App\Models\ImportLog::with('user')->findOrFail($id);
        
        if (!$importLog->hasFlaggedRecords()) {
            return redirect()->route('cases.import.details', $id)
                ->with('info', 'This import has no flagged records.');
        }
        
        return view('cases.import-flagged', compact('importLog'));
    }

    /**
     * Manually approve and import a flagged record
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approveFlaggedRecord(Request $request)
    {
        try {
            $request->validate([
                'import_log_id' => 'required|exists:import_logs,id',
                'record_index' => 'required|integer',
                'case_data' => 'required|json',
            ]);
            
            $caseData = json_decode($request->case_data, true);
            $caseData['user_id'] = auth()->id();
            
            // Create the case
            CaseModel::create($caseData);
            
            // Update import log to remove this flagged record
            $importLog = \App\Models\ImportLog::findOrFail($request->import_log_id);
            $flaggedData = $importLog->flagged_data;
            unset($flaggedData[$request->record_index]);
            
            $importLog->update([
                'flagged_data' => array_values($flaggedData),
                'flagged_records' => count($flaggedData),
                'successful_imports' => $importLog->successful_imports + 1,
            ]);
            
            return back()->with('success', 'Record approved and imported successfully.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to approve record: ' . $e->getMessage());
        }
    }
    
    /**
     * Map CSV column headers to database field names
     * Handles different column orders and missing columns
     */
    private function mapCsvColumns($headers)
    {
        // Define mapping from various possible header names to database fields
        $headerMappings = [
            'case_number' => ['case number', 'case no', 'casenumber', 'case_number', 'number'],
            'docket_no' => ['docket no', 'docket number', 'docketno', 'docket_no', 'docket'],
            'old_folder_no' => ['old folder no', 'old folder number', 'old_folder_no', 'folder no', 'folder number'],
            'case_title' => ['case title', 'title', 'case_title', 'casetitle'],
            'client_name' => ['client name', 'client', 'client_name', 'clientname'],
            'case_type' => ['case type', 'type', 'case_type', 'casetype'],
            'section' => ['section'],
            'court_agency' => ['court/agency', 'court agency', 'court', 'agency', 'court_agency'],
            'region' => ['region'],
            'assigned_lawyer' => ['assigned lawyer', 'lawyer', 'assigned_lawyer', 'assignedlawyer'],
            'handling_counsel_ncip' => ['handling counsel (ncip)', 'handling counsel', 'ncip counsel', 'handling_counsel_ncip'],
            'date_filed' => ['date filed', 'filed date', 'date_filed', 'datefiled'],
            'deadline_days' => ['deadline days', 'days', 'deadline_days', 'deadlinedays'],
            'hearing_date' => ['hearing date', 'hearing', 'hearing_date', 'hearingdate'],
            'status' => ['status'],
            'notes' => ['notes', 'note'],
            'actions_taken' => ['actions taken', 'actions', 'actions_taken', 'actionstaken'],
            'action' => ['action'],
            'issues_grounds' => ['issues/grounds', 'issues', 'grounds', 'issues_grounds'],
            'prayers_relief' => ['prayers (relief)', 'prayers', 'relief', 'prayers_relief'],
            'new_sc_no' => ['new sc no', 'new sc number', 'new_sc_no', 'sc no'],
            'remarks' => ['remarks', 'remark', 'comment', 'comments'],
        ];
        
        $columnMap = [];
        
        // Normalize headers and create mapping
        foreach ($headers as $index => $header) {
            $normalizedHeader = strtolower(trim($header));
            
            // Find matching database field
            foreach ($headerMappings as $field => $possibleNames) {
                foreach ($possibleNames as $possibleName) {
                    if ($normalizedHeader === $possibleName) {
                        $columnMap[$field] = $index;
                        break 2;
                    }
                }
            }
        }
        
        return $columnMap;
    }

    /**
     * Update the notes for a specific case
     */
    public function updateNotes(Request $request, CaseModel $case)
    {
        try {
            $request->validate([
                'notes' => 'nullable|string|max:10000',
            ]);

            $case->notes = $request->input('notes');
            $case->save();

            // Check if redirect_to parameter exists
            if ($request->has('redirect_to')) {
                return redirect($request->redirect_to)
                    ->with('success', 'Notes saved successfully!')
                    ->with('notes_case_id', $case->id);
            }

            return redirect()->back()
                ->with('success', 'Notes saved successfully!')
                ->with('notes_case_id', $case->id);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to save notes: ' . $e->getMessage())
                ->with('notes_case_id', $case->id);
        }
    }

    /**
     * Mark a case as completed
     */
    public function markAsCompleted(CaseModel $case)
    {
        try {
            $case->status = 'completed';
            $case->save();

            return redirect()->back()
                ->with('success', 'Case marked as completed successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to mark case as completed: ' . $e->getMessage());
        }
    }

    /**
     * Reopen a completed case (set back to active status)
     */
    public function reopenCase(CaseModel $case)
    {
        try {
            // Recalculate status based on deadline
            if ($case->deadline_date) {
                $case->status = CaseModel::calculateStatus($case->deadline_date);
            } else {
                $case->status = 'active';
            }
            $case->save();

            return redirect()->back()
                ->with('success', 'Case reopened successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to reopen case: ' . $e->getMessage());
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        
        if (empty($query)) {
            return redirect()->route('cases.information')->with('info', 'Please enter a search term.');
        }

        // Search across multiple fields
        $cases = CaseModel::where(function($q) use ($query) {
            $q->where('case_title', 'LIKE', "%{$query}%")
              ->orWhere('court_agency', 'LIKE', "%{$query}%")
              ->orWhere('docket_no', 'LIKE', "%{$query}%")
              ->orWhere('case_number', 'LIKE', "%{$query}%")
              ->orWhere('client_name', 'LIKE', "%{$query}%")
              ->orWhere('case_type', 'LIKE', "%{$query}%")
              ->orWhere('status', 'LIKE', "%{$query}%")
              ->orWhere('assigned_lawyer', 'LIKE', "%{$query}%")
              ->orWhere('section', 'LIKE', "%{$query}%")
              ->orWhere('region', 'LIKE', "%{$query}%")
              ->orWhere('notes', 'LIKE', "%{$query}%");
        })
        ->with('documents')
        ->orderBy('created_at', 'desc')
        ->get();

        return view('cases.search', [
            'cases' => $cases,
            'query' => $query,
            'resultCount' => $cases->count()
        ]);
    }

    public function searchSuggestions(Request $request)
    {
        $query = $request->input('q');
        
        if (empty($query) || strlen($query) < 2) {
            return response()->json([]);
        }

        // Get top 8 matching cases
        $cases = CaseModel::where(function($q) use ($query) {
            $q->where('case_title', 'LIKE', "%{$query}%")
              ->orWhere('case_number', 'LIKE', "%{$query}%")
              ->orWhere('client_name', 'LIKE', "%{$query}%")
              ->orWhere('docket_no', 'LIKE', "%{$query}%")
              ->orWhere('court_agency', 'LIKE', "%{$query}%");
        })
        ->select('id', 'case_number', 'case_title', 'client_name', 'court_agency', 'status')
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();

        // Format suggestions
        $suggestions = $cases->map(function($case) {
            return [
                'id' => $case->id,
                'case_number' => $case->case_number,
                'case_title' => $case->case_title,
                'client_name' => $case->client_name,
                'court_agency' => $case->court_agency,
                'status' => $case->status,
                'url' => route('cases.show', $case->id)
            ];
        });

        return response()->json($suggestions);
    }
}
