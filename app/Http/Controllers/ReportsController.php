<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use PDF;

class ReportsController extends Controller
{
    private const AGE_BRACKETS = ['60-69', '70-79', '80-89', '90-99', '100-above'];

    public function reportsRead()
    {
        $citizen = Citizen::withPersonalInfo()->get();

        return view('reports.datalist', compact('citizen'));
    }

    public function generateReports(Request $request)
    {
        $filters = $request->validate([
            'gender' => 'nullable|in:All,Male,Female',
            'agebracket' => ['nullable', Rule::in(array_merge(['All'], self::AGE_BRACKETS))],
        ]);

        $query = Citizen::withPersonalInfo();

        $gender = $filters['gender'] ?? 'All';
        if ($gender !== 'All') {
            $query->where('citizen_i_s.gender', $gender);
        }

        $genSenior = $query->get();
        $bracket = $filters['agebracket'] ?? 'All';
        if ($bracket === '100-above') {
            $genSenior = $genSenior->filter(fn (Citizen $citizen) => $citizen->current_age !== null && $citizen->current_age >= 100);
        } elseif (preg_match('/^(\d{1,3})-(\d{1,3})$/', $bracket, $range)) {
            $genSenior = $genSenior->filter(fn (Citizen $citizen) => $citizen->current_age !== null
                && $citizen->current_age >= (int) $range[1] && $citizen->current_age <= (int) $range[2]);
        }

        $pdf = PDF::loadView('reports.datalist_reportsGen', compact('genSenior'))->setPaper('Legal', 'portrait');

        return $pdf->stream();
    }
}
