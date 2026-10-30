<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LaravelBasicController extends Controller
{
    public function counterReset()
    {
        return view('basic.counter_reset');
    }

    public function namePreview(Request $request)
    {
        return view('basic.name_review');
    }

    public function namePreviewstore(Request $request)
    {
        $validatedData = $request->validate([
            'first-name' => 'required|string|alpha|min:2|max:50',
            'last-name'  => 'required|string|alpha|min:2|max:50',
        ]);
        // 2. Redirect back to the form page with the data stored in the session
        return redirect()->back()
            ->with('success', 'Form validation passed!')
            ->with('first_name', $validatedData['first-name'])
            ->with('last_name', $validatedData['last-name'])
            ->withInput(); // Keeps form inputs filled out if needed
    }

    public function bioCharacterCounter()
    {
        return view('basic.bio_character_counter');
    }

    public function bioCharacterCounterPost(Request $request)
    {
        $validator = Validator::validate($request->only('profile-bio'), [
            'profile-bio' => 'required|string|max:160'
        ]);
    }

    public function countryCity(Request $request)
    {
        $searchTerm = $request->query('country');
        $city_searchTerm = $request->query('city');
        $countries = Country::select('id', 'name')->get();

        if (!empty($searchTerm)) {
            $cities = City::select('id', 'name')
                ->where('country_id', $searchTerm)
                ->get();
        }
        return view('basic.country_city', compact('countries', 'searchTerm', 'cities', 'city_searchTerm'));
    }

    public function countryCityAjax(Request $request)
    {
        return view('basic.country_city-ajax');
    }

    public function getCountries(): JsonResponse
    {
        // Assuming your Country model has 'code' (us, uk) and 'name' columns
        $countries = Country::select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();

        return response()->json($countries);
    }

    // Fetched when country selection changes
    public function getCities(Request $request): JsonResponse
    {
        $country = $request->input('country');

        if (!$country) {
            return response()->json([], 400);
        }

        $cities = City::where('country_id', $country)
            ->select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();

        return response()->json($cities);
    }
}
