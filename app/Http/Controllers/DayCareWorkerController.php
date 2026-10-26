<?php

namespace App\Http\Controllers;

use App\Http\Requests\DayCareWorkerRequest;
use App\Models\Barangay;
use App\Models\City;
use App\Models\DayCareWorker;
use App\Models\Region;
use Illuminate\Support\Str;
use PDF;

class DayCareWorkerController extends Controller
{
    /** PSGC city code of Mabinay, Negros Oriental (default address and barangay suggestions). */
    private const HOME_CITY_ID = '074614';

    /** A4 in points, the paper size of ECCD Form 6. */
    private const FORM6_PAPER = [0, 0, 595.44, 841.68];

    public function daycareRead()
    {
        $workers = DayCareWorker::orderBy('last_name')->orderBy('first_name')->get();

        return view('daycare.list', compact('workers'));
    }

    public function daycareForm()
    {
        return view('daycare.form', $this->formData(new DayCareWorker($this->homeAddress())));
    }

    public function daycareCreate(DayCareWorkerRequest $request)
    {
        DayCareWorker::create($request->toModelData());

        return redirect()->route('daycareRead')->with('success', 'Added Record Successfully');
    }

    public function daycareEdit($id)
    {
        $worker = DayCareWorker::findOrFail($this->decryptId($id));

        return view('daycare.form', $this->formData($worker) + ['id' => $id]);
    }

    public function daycareUpdate(DayCareWorkerRequest $request, $id)
    {
        DayCareWorker::findOrFail($this->decryptId($id))->update($request->toModelData());

        return redirect()->route('daycareRead')->with('success', 'Record Updated Successfully');
    }

    /**
     * ECCD Form 6 filled in with the worker's profile.
     */
    public function daycarePdf($id)
    {
        $worker = DayCareWorker::findOrFail($this->decryptId($id));

        return $this->form6($worker)->stream('Form-6-' . str_replace(' ', '-', $worker->full_name) . '.pdf');
    }

    /**
     * Blank ECCD Form 6 for filling in by hand.
     */
    public function daycareBlankPdf()
    {
        return $this->form6(new DayCareWorker())->stream('Form-6-Child-Development-Worker-Profile.pdf');
    }

    public function daycareDelete($id)
    {
        DayCareWorker::findOrFail($id)->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Deleted Successfully',
        ]);
    }

    private function form6(DayCareWorker $worker)
    {
        return PDF::loadView('daycare.form6_pdf', compact('worker'))
            ->setPaper(self::FORM6_PAPER);
    }

    private function formData(DayCareWorker $worker): array
    {
        $barangays = Barangay::where('city_id', self::HOME_CITY_ID)->orderBy('name')->pluck('name');

        return compact('worker', 'barangays');
    }

    /**
     * City, province and region names of the home municipality, used to prefill a new profile.
     */
    private function homeAddress(): array
    {
        $city = City::with('province')->where('city_id', self::HOME_CITY_ID)->first();
        $region = $city ? Region::where('region_id', $city->region_id)->first() : null;

        return [
            'address_city' => $city ? ucwords(strtolower($city->name)) : null,
            'address_province' => $city?->province ? ucwords(strtolower($city->province->name)) : null,
            // "REGION VII (CENTRAL VISAYAS)" -> "Region VII"
            'address_region' => $region ? preg_replace('/^REGION\b/i', 'Region', Str::before($region->name, ' (')) : null,
        ];
    }
}
