<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\CitizenI;
use App\Models\City;
use App\Models\Province;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AddressController extends Controller
{
    public function getRegions()
    {
        return response()->json(Region::orderBy('name')->get());
    }

    public function getProvinces($regionId)
    {
        return response()->json(Province::where('region_id', $regionId)->orderBy('name')->get());
    }

    public function getCities($provinceId)
    {
        return response()->json(City::where('province_id', $provinceId)->orderBy('name')->get());
    }

    public function getBarangays($cityId)
    {
        return response()->json(Barangay::where('city_id', $cityId)->orderBy('name')->get());
    }

    /**
     * Saves one address dropdown on the senior citizen "more info" page.
     */
    public function addressUpdate(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:citizens,id',
            'column' => ['required', Rule::in(CitizenI::ADDRESS_COLUMNS)],
            'value' => 'nullable|string|max:20',
        ]);

        CitizenI::firstOrCreate(['cid' => $validated['id']])
            ->update([$validated['column'] => $validated['value']]);

        return response()->json(['success' => true]);
    }
}
