<?php

namespace App\Http\Controllers;

use App\Services\DashboardReport;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function dashboard(Request $request, DashboardReport $report)
    {
        $input = $request->validate([
            'tab' => 'nullable|in:overview,faced,pwd,soloparents,seniors,vawc,users',
            'barangay' => 'nullable|integer|min:1',
            'range' => ['nullable', 'regex:/^\d{4}-\d{2}-\d{2} - \d{4}-\d{2}-\d{2}$/'],
        ]);
        $tab = $input['tab'] ?? 'overview';
        $tabs = $report->tabsFor($request->user());
        abort_unless(isset($tabs[$tab]), 403);
        if (! empty($input['range'])) {
            [$start, $end] = explode(' - ', $input['range']);
            abort_if($start > $end, 422, 'The date range must start before it ends.');
            foreach ([$start, $end] as $date) {
                [$year, $month, $day] = array_map('intval', explode('-', $date));
                abort_unless(checkdate($month, $day, $year), 422, 'Choose a valid date range.');
            }
        }
        return view('home.dashboard-all', [
            'tabs' => $tabs,
            'tab' => $tab,
            'filters' => ['barangay' => $input['barangay'] ?? null, 'range' => $input['range'] ?? null],
            'barangays' => $report->barangays(),
            'report' => $report->build($tab, $request->user(), $input['barangay'] ?? null, $input['range'] ?? null),
        ]);
    }

    public function dashboardFaced(Request $request)
    {
        return redirect()->route('dashboard', array_merge($request->only('barangay', 'range'), ['tab' => 'faced']));
    }

    public function logout()
    {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('getLogin')->with('success', 'You have been Successfully Logged Out');
    }

}
