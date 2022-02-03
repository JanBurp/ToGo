<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Locations;

class TogoController extends Controller
{

    /**
     * Display main togo page, with current locations
     *
     */
    public function index() {
        return view('home');
    }


    /**
     * Display location page
     *
     */
    public function location( $id ) {

        $location = Locations::where('id',$id)->first();

        return view('location',[
            'openrout_apikey' => env('OPENROUTE_APIKEY'),
            'location'        => $location,
        ]);
    }



}
