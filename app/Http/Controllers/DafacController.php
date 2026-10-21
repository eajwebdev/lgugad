<?php

namespace App\Http\Controllers;

use App\Http\Requests\DafacRequest;
use App\Http\Requests\StoreAssistanceRequest;
use App\Models\Assistance;
use App\Models\Barangay;
use App\Models\City;
use App\Models\Dafac;
use App\Models\Province;
use App\Models\Region;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class DafacController extends Controller
{
    /** PSGC city code of Mabinay, Negros Oriental (barangays offered in the DAFAC form). */
    private const HOME_CITY_ID = '074614';

    public function dafacRead()
    {
        $dafacs = Dafac::withAddressNames()->get();

        return view('dafac.list', compact('dafacs'));
    }

    public function dafacForm()
    {
        $regions = Region::all();
        $homeBarangays = Barangay::where('city_id', self::HOME_CITY_ID)->orderBy('name')->get();
        $count = Dafac::nextCount();

        // Restore dependent address choices when validation returns to the form.
        $selectedRegion = old('add_region', '07');
        $selectedProvince = old('add_prov', '0746');
        $selectedCity = old('add_city', self::HOME_CITY_ID);
        $selectedProvinces = $selectedRegion
            ? Province::where('region_id', $selectedRegion)->get()
            : collect();
        $selectedCities = $selectedProvince
            ? City::where('province_id', $selectedProvince)->get()
            : collect();
        $selectedBarangays = $selectedCity
            ? Barangay::where('city_id', $selectedCity)->orderBy('name')->get()
            : $homeBarangays;

        return view('dafac.form', compact(
            'count', 'regions',
            'selectedProvinces', 'selectedCities', 'selectedBarangays'
        ));
    }

    public function dafacCreate(DafacRequest $request)
    {
        Dafac::create($request->toModelData());

        return redirect()->back()->with('success', 'Added Record Successfully');
    }

    public function dafacEdit($id)
    {
        $dafacedit = Dafac::findOrFail($this->decryptId($id));
        $dafac = Dafac::all();

        $regions = Region::all();
        $provinces = Province::where('province_id', $dafacedit->add_prov)->get();
        $cities = City::where('city_id', $dafacedit->add_city)->get();
        $barangays = $dafacedit->add_brgy ? Barangay::find($dafacedit->add_brgy) : null;
        $citys = Barangay::where('city_id', self::HOME_CITY_ID)->get();
        $count = Dafac::nextCount();

        return view('dafac.form_edit', compact(
            'dafac', 'dafacedit', 'count', 'id', 'regions', 'cities', 'provinces', 'barangays', 'citys'
        ));
    }

    public function dafacUpdate(DafacRequest $request)
    {
        $request->validate(['id' => 'required|string']);

        Dafac::findOrFail($this->decryptId($request->input('id')))->update($request->toModelData());

        return redirect()->back()->with('success', 'Record Updated Successfully');
    }

    public function dafacPdf($id, $form)
    {
        $decId = $this->decryptId($id);

        $dafac = Dafac::withAddressNames()->where('dafacs.id', $decId)->firstOrFail();
        $assistances = Assistance::where('dafac_id', $decId)->get();
        $headbrgy = $dafac->city_mun_head ? Barangay::find($dafac->city_mun_head) : null;

        $formView = ((int) $form === 1) ? 'dafac.form_pdf' : 'dafac.form_pdf_back';

        $pdf = PDF::loadView($formView, compact('dafac', 'headbrgy', 'assistances'))
            ->setPaper([0, 0, 712, 930], 'landscape')
            ->setOption('margin-top', 0)
            ->setOption('margin-right', 0)
            ->setOption('margin-bottom', 0)
            ->setOption('margin-left', 0);

        return $pdf->stream();
    }

    public function dafacDelete($id)
    {
        // Assistance rows are removed by the foreign key cascade.
        Dafac::findOrFail($id)->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Deleted Successfully',
        ]);
    }

    public function assRead(Request $request)
    {
        $dafacs = Dafac::all();

        if (! $request->filled('did')) {
            return view('dafac.assistance', compact('dafacs'));
        }

        $dafacsrch = Dafac::findOrFail($this->decryptId($request->input('did')));
        $assistances = $dafacsrch->assistances()->get();

        return view('dafac.assistance', compact('dafacs', 'dafacsrch', 'assistances'));
    }

    public function assCreate(StoreAssistanceRequest $request)
    {
        $data = $request->validated();
        $dafac = Dafac::findOrFail($this->decryptId($data['did']));

        $assistance = new Assistance([
            'fam_mem' => $data['fam_mem'],
            'em_dis' => $data['em_dis'],
            'assistance' => $data['assistance'],
            'unit' => $data['unit'],
            'quantity' => $data['quantity'],
            'cost' => $data['cost'],
            'provider' => $data['provider'],
        ]);
        // The date of assistance is chosen by the user; keep the current time of day.
        $assistance->created_at = Carbon::parse($data['created_at'])->setTimeFrom(Carbon::now());

        $dafac->assistances()->save($assistance);

        return redirect()->back()->with('success', 'Record Added Successfully');
    }

    public function assDelete($id)
    {
        Assistance::findOrFail($id)->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Deleted Successfully',
        ]);
    }
}
