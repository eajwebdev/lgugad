<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSoloParentRequest;
use App\Models\MabinayBrgy;
use App\Models\SoloParent;

class SoloParentController extends Controller
{
    public function soloparentRead()
    {
        $soloparent = SoloParent::all();

        return view('soloparent.list', compact('soloparent'));
    }

    public function soloparentForm()
    {
        $barangays = MabinayBrgy::all();

        return view('soloparent.form', compact('barangays'));
    }

    public function soloparentCreate(StoreSoloParentRequest $request)
    {
        SoloParent::create($request->toModelData());

        return redirect()->back()->with('success', 'Added Record Successfully');
    }
}
