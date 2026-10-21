<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePwdRequest;
use App\Models\MabinayBrgy;
use App\Models\Pwd;

class PwdController extends Controller
{
    public function pwdRead()
    {
        $pwd = Pwd::leftJoin('mabinay_brgys', 'mabinay_brgys.id', '=', 'pwds.brangay')
            ->select('pwds.*', 'mabinay_brgys.brgy_name')
            ->get();

        return view('pwd.list', compact('pwd'));
    }

    public function pwdForm()
    {
        $barangays = MabinayBrgy::all();

        return view('pwd.form', compact('barangays'));
    }

    public function pwdCreate(StorePwdRequest $request)
    {
        Pwd::create($request->toModelData());

        return redirect()->back()->with('success', 'Added Record Successfully');
    }
}
