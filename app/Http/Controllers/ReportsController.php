<?php

namespace App\Http\Controllers;

use App\Models\CaseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportsController extends Controller
{
    /**
     * Display reports overview
     */
    public function index()
    {
        $stats = [
            'total_cases' => CaseModel::count(),
            'active_cases' => CaseModel::where('status', 'active')->count(),
            'overdue_cases' => CaseModel::where('status', 'overdue')->count(),
            'completed_cases' => CaseModel::where('status', 'completed')->count(),
        ];

        return view('reports.index', compact('stats'));
    }

    /**
     * Case Summary Report
     */
    public function caseSummary(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $cases = CaseModel::whereBetween('date_filed', [$startDate, $endDate])
            ->orderBy('date_filed', 'desc')
            ->get();

        $summary = [
            'total' => $cases->count(),
            'by_section' => $cases->groupBy('section')->map->count(),
            'by_court' => $cases->groupBy('court_agency')->map->count(),
            'by_region' => $cases->groupBy('region')->map->count(),
            'by_status' => $cases->groupBy('status')->map->count(),
        ];

        return view('reports.case-summary', compact('cases', 'summary', 'startDate', 'endDate'));
    }

    /**
     * Performance Report - Cases by Lawyer
     */
    public function performance(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $lawyerStats = CaseModel::whereBetween('date_filed', [$startDate, $endDate])
            ->select('assigned_lawyer', 
                DB::raw('count(*) as total'),
                DB::raw('sum(case when status = "active" then 1 else 0 end) as active'),
                DB::raw('sum(case when status = "completed" then 1 else 0 end) as completed'),
                DB::raw('sum(case when status = "overdue" then 1 else 0 end) as overdue'),
                DB::raw('sum(case when status = "due_soon" then 1 else 0 end) as due_soon'))
            ->whereNotNull('assigned_lawyer')
            ->where('assigned_lawyer', '!=', '')
            ->groupBy('assigned_lawyer')
            ->orderBy('total', 'desc')
            ->get();

        return view('reports.performance', compact('lawyerStats', 'startDate', 'endDate'));
    }

    /**
     * Deadline Compliance Report
     */
    public function deadlineCompliance(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $cases = CaseModel::whereBetween('deadline_date', [$startDate, $endDate])
            ->orderBy('deadline_date', 'asc')
            ->get();
        
        $overdueCases = CaseModel::where('status', 'overdue')
            ->whereBetween('deadline_date', [$startDate, $endDate])
            ->orderBy('deadline_date', 'asc')
            ->get();

        $compliance = [
            'total' => $cases->count(),
            'on_time' => $cases->whereNotIn('status', ['overdue'])->count(),
            'overdue' => $cases->where('status', 'overdue')->count(),
            'by_court' => CaseModel::whereBetween('deadline_date', [$startDate, $endDate])
                ->select('court_agency',
                    DB::raw('count(*) as total'),
                    DB::raw('sum(case when status != "overdue" then 1 else 0 end) as on_time'),
                    DB::raw('sum(case when status = "overdue" then 1 else 0 end) as overdue'))
                ->whereNotNull('court_agency')
                ->where('court_agency', '!=', '')
                ->groupBy('court_agency')
                ->orderBy('total', 'desc')
                ->get(),
        ];

        return view('reports.deadline-compliance', compact('overdueCases', 'compliance', 'startDate', 'endDate'));
    }

    /**
     * Statistical Report
     */
    public function statistical(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);

        $monthlyData = collect();
        for ($month = 1; $month <= 12; $month++) {
            $monthStart = Carbon::createFromDate($year, $month, 1)->startOfMonth();
            $monthEnd = Carbon::createFromDate($year, $month, 1)->endOfMonth();

            $monthlyData->push((object)[
                'month_name' => $monthStart->format('F'),
                'filed' => CaseModel::whereBetween('date_filed', [$monthStart, $monthEnd])->count(),
                'completed' => CaseModel::where('status', 'completed')
                    ->whereBetween('date_filed', [$monthStart, $monthEnd])->count(),
            ]);
        }

        $stats = [
            'total_filed' => CaseModel::whereYear('date_filed', $year)->count(),
            'total_completed' => CaseModel::whereYear('date_filed', $year)->where('status', 'completed')->count(),
            'total_active' => CaseModel::whereYear('date_filed', $year)->where('status', 'active')->count(),
            'by_section' => CaseModel::whereYear('date_filed', $year)
                ->select('section', DB::raw('count(*) as total'))
                ->groupBy('section')
                ->orderBy('total', 'desc')
                ->get(),
            'by_court' => CaseModel::whereYear('date_filed', $year)
                ->select('court_agency', DB::raw('count(*) as total'))
                ->groupBy('court_agency')
                ->orderBy('total', 'desc')
                ->get(),
            'by_region' => CaseModel::whereYear('date_filed', $year)
                ->select('region', DB::raw('count(*) as total'))
                ->groupBy('region')
                ->orderBy('total', 'desc')
                ->get(),
            'status' => [
                'active' => CaseModel::whereYear('date_filed', $year)->where('status', 'active')->count(),
                'completed' => CaseModel::whereYear('date_filed', $year)->where('status', 'completed')->count(),
                'overdue' => CaseModel::whereYear('date_filed', $year)->where('status', 'overdue')->count(),
                'due_soon' => CaseModel::whereYear('date_filed', $year)->where('status', 'due_soon')->count(),
            ],
        ];

        return view('reports.statistical', compact('monthlyData', 'stats', 'year'));
    }
}
