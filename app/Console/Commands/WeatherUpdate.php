<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;
use App\Models\Weather;

class WeatherUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() 
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
}
