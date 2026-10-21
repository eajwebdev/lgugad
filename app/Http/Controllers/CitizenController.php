<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCitizenRequest;
use App\Http\Requests\UpdateCitizenFieldRequest;
use App\Models\Barangay;
use App\Models\Citizen;
use App\Models\City;
use App\Models\Province;
use App\Models\Region;
use App\Services\CitizenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use PDF;

class CitizenController extends Controller
{
    public function __construct(private CitizenService $citizens)
    {
    }

    public function citizenRead()
    {
        $citizen = Citizen::withPersonalInfo()->get();

        return view('citizen.list', compact('citizen'));
    }

    public function citizenCreate(StoreCitizenRequest $request)
    {
        $data = $request->validated();

        if ($this->citizens->exists($data['lname'], $data['fname'], $data['mname'])) {
            return redirect()->back()->withInput()->with('error', 'Citizen already exists.');
        }

        try {
            $this->citizens->register($data);
        } catch (\Throwable $e) {
            Log::error('Senior citizen registration failed', ['exception' => $e]);

            return redirect()->back()->withInput()->with('error', 'Unable to save the record. Please try again.');
        }

        return redirect()->back()->with('success', 'Added Successfully');
    }

    public function citizenMoreInfo($encryptedId)
    {
        $citizen = Citizen::with(['personal', 'family', 'education', 'background'])
            ->findOrFail($this->decryptId($encryptedId, true));

        $citizenid = $citizen->id;
        $citizenI = $citizen->personal;
        $citizenII = $citizen->family;
        $CitizenIII = $citizen->education;
        $citizenBck = $citizen->background;

        $regions = Region::all();
        $provinces = Province::where('province_id', $citizenI?->add_prov)->get();
        $cities = City::where('city_id', $citizenI?->add_city)->get();
        $barangays = $citizenI?->add_brgy ? Barangay::find($citizenI->add_brgy) : null;

        return view('citizen.moreinfo', compact(
            'citizen', 'citizenid', 'citizenI', 'citizenII', 'CitizenIII', 'citizenBck',
            'regions', 'provinces', 'cities', 'barangays'
        ));
    }

    public function MoreInfoUpdate(UpdateCitizenFieldRequest $request)
    {
        $this->citizens->updateField(
            $request->record(),
            $request->validated('data'),
            $request->validated('value'),
            $request->filled('array') ? (int) $request->validated('array') : null,
            $request->filled('age') ? (int) $request->validated('age') : null,
        );

        return response()->json(['success' => 'Updated Successfully']);
    }

    public function citizenReadPdf($id)
    {
        $citizen = $this->citizenWithAllDetails()
            ->where('citizens.id', $this->decryptId($id, true))
            ->firstOrFail();
        $this->fillAddressLabels($citizen);

        $pdf = PDF::loadView('citizen.list_pdf', compact('citizen'))->setPaper('legal', 'portrait');
        $pdf->setOption('margin', 1);

        return $pdf->stream();
    }

    public function citizenDelete($id)
    {
        $this->citizens->delete(Citizen::findOrFail($id));

        return response()->json([
            'status' => 200,
            'message' => 'Deleted Successfully',
        ]);
    }

    public function citizenPrntSticker($id)
    {
        $citizen = $this->citizenWithAllDetails()->where('citizens.id', $id)->firstOrFail();
        $citizenI = $citizen;
        $this->fillAddressLabels($citizen);

        return view('citizen.modal-idcard-content', compact('citizen', 'citizenI'));
    }

    public function updateProfileImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $this->citizens->updateProfileImage(Citizen::findOrFail($id), $request->file('image'));

        return response()->json(['success' => true]);
    }

    public function updateCitizenFiles(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:10240',
        ]);

        $citizen = Citizen::findOrFail($id);

        try {
            $fileName = $this->citizens->addDocument($citizen, $request->file('file'));
        } catch (\Throwable $e) {
            Log::error('Senior citizen file upload failed', ['exception' => $e, 'citizen_id' => $citizen->id]);

            return response()->json(['success' => false, 'message' => 'Error occurred while uploading file.'], 500);
        }

        return response()->json([
            'success' => true,
            'file' => [
                'name' => $fileName,
                'url' => $this->citizens->documentUrl($fileName),
            ],
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(Citizen::STATUSES)],
        ]);

        Citizen::findOrFail($id)->update($validated);

        return response()->json(['success' => true]);
    }

    public function deleteFile($id, $fileName)
    {
        if (! $this->citizens->removeDocument(Citizen::findOrFail($id), $fileName)) {
            return response()->json(['success' => false, 'message' => 'File not found.'], 404);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Citizen merged with all four detail tables, as the PDF form and ID card views expect.
     */
    private function citizenWithAllDetails()
    {
        return Citizen::leftJoin('citizen_i_s', 'citizens.id', '=', 'citizen_i_s.cid')
            ->leftJoin('citizen_i_i_s', 'citizens.id', '=', 'citizen_i_i_s.cid')
            ->leftJoin('citizen_i_i_i_s', 'citizens.id', '=', 'citizen_i_i_i_s.cid')
            ->leftJoin('citizen_bcks', 'citizens.id', '=', 'citizen_bcks.cid')
            ->select(
                'citizen_bcks.*',
                'citizen_i_i_i_s.*',
                'citizen_i_i_s.*',
                'citizen_i_s.*',
                'citizens.*'
            );
    }

    /** Keep address codes visible when an imported dump uses an older address directory. */
    private function fillAddressLabels(Citizen $citizen): void
    {
        $labels = [
            'region' => $citizen->add_region ? Region::where('region_id', $citizen->add_region)->value('name') : null,
            'province' => $citizen->add_prov ? Province::where('province_id', $citizen->add_prov)->value('name') : null,
            'city_mun' => $citizen->add_city ? City::where('city_id', $citizen->add_city)->value('name') : null,
            'brgy' => $citizen->add_brgy ? Barangay::find($citizen->add_brgy)?->name : null,
        ];
        foreach (['region' => 'add_region', 'province' => 'add_prov', 'city_mun' => 'add_city', 'brgy' => 'add_brgy'] as $label => $code) {
            $citizen->setAttribute($label, $labels[$label] ?? ($citizen->{$label} ?: ($citizen->{$code} ? 'Legacy code ' . $citizen->{$code} : '')));
        }
    }
}
