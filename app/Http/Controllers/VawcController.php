<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVawcRequest;
use App\Models\MabinayBrgy;
use App\Models\Vawc;

class VawcController extends Controller
{
    public function vawcRead()
    {
        $vawc = Vawc::all();

        return view('vawc.list', compact('vawc'));
    }

    public function vawcForm()
    {
        $barangays = MabinayBrgy::all();

        return view('vawc.form', compact('barangays'));
    }

    public function vawcCreate(StoreVawcRequest $request)
    {
        Vawc::create($request->toModelData());

        return redirect()->back()->with('success', 'Added Record Successfully');
    }
}
