<?php

namespace App\Http\Controllers;

use App\Models\CaseModel;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get key statistics
        $stats = [
            'overdue' => CaseModel::overdue()->count(),
            'due_within_7days' => CaseModel::dueSoon(7)->count(),
            'hearing_today' => CaseModel::hearingToday()->count(),
            'hearing_tomorrow' => CaseModel::hearingTomorrow()->count(),
            'total_active' => CaseModel::active()->count(),
        ];

        // Get overdue cases
        $overdueCases = CaseModel::overdue()
            ->orderBy('deadline_date', 'asc')
            ->get();

        // Get cases due within 7 days
        $dueSoonCases = CaseModel::dueSoon(7)
            ->orderBy('deadline_date', 'asc')
            ->get();

        // Get today's hearings
        $hearingTodayCases = CaseModel::hearingToday()
            ->orderBy('hearing_date', 'asc')
            ->get();

        // Get tomorrow's hearings
        $tomorrowHearings = CaseModel::hearingTomorrow()
            ->orderBy('hearing_date', 'asc')
            ->get();

        // Get cases by section
        $casesBySection = CaseModel::active()
            ->selectRaw('section, COUNT(*) as count')
            ->groupBy('section')
            ->pluck('count', 'section');

        // Get cases by court/agency
        $casesByCourt = CaseModel::active()
            ->whereNotNull('court_agency')
            ->selectRaw('court_agency, COUNT(*) as count')
            ->groupBy('court_agency')
            ->pluck('count', 'court_agency');

        // Get cases by region
        $casesByRegion = CaseModel::active()
            ->whereNotNull('region')
            ->selectRaw('region, COUNT(*) as count')
            ->groupBy('region')
            ->pluck('count', 'region');

        return view('dashboard', compact(
            'stats',
            'overdueCases',
            'dueSoonCases',
            'hearingTodayCases',
            'tomorrowHearings',
            'casesBySection',
            'casesByCourt',
            'casesByRegion'
        ));
    }
}
