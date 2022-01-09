<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;
use App\Models\Weather;

class WeatherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cityName = 'Jaipur';
        $countryCode = 'In';
        $ip = request()->ip(); // Dynamic IP address 

        $currentUserInfo = Location::get($ip);
        if ($currentUserInfo) {
            $cityName = $currentUserInfo->cityName;
            $countryCode = $currentUserInfo->countryCode;
        }

        // Initiate curl session in a variable (resource)
        $curl_handle = curl_init();

        $url = "api.openweathermap.org/data/2.5/weather?q=".$cityName.",".$countryCode."&APPID=0960b528437dac881369982fa00caeb5&units=metric";

        // Set the curl URL option
        curl_setopt($curl_handle, CURLOPT_URL, $url);

        // This option will return data as a string instead of direct output
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

        // Execute curl & store data in a variable
        $curl_data = curl_exec($curl_handle);

        curl_close($curl_handle);

        // Decode JSON into PHP array
        $response_data = json_decode($curl_data);

        // Insert data into db
        $weather = new Weather;
        $weather->city = $response_data->name;
        $weather->country = $response_data->sys->country;
        $weather->lat = $response_data->coord->lat;
        $weather->long = $response_data->coord->lon;
        $weather->temp = $response_data->main->temp;
        $weather->save();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
