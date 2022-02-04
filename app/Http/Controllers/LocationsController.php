<?php

namespace App\Http\Controllers;

use App\Models\Locations;
use Illuminate\Http\Request;

class LocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Locations::all();
        return response()->json([
            'locations'       => $locations,
            'openrout_apikey' => env('OPENROUTE_APIKEY'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $location = new Locations;

        $location->user_id      = 1; // TODO - replace with auth user_id in future
        $location->visited      = $request->input('visited',false);
        $location->location     = $request->input('location');

        if ( $location->save() ) {
            return response()->json($location);
        }
        return response()->json(['error'=>true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Locations  $locations
     * @return \Illuminate\Http\Response
     */
    public function show(Locations $locations)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Locations  $locations
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $location = Locations::find($id);
        $data = $request->all();

        if ( $data ) {
            if ( isset($data['visited']) )      $location->visited  = $data['visited'];
            if ( isset($data['location']) )     $location->location = $data['location'];

            if ( $location->save() ) {
                return response()->json($location);
            }
        }

        return response()->json(['error'=>true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Locations  $locations
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id )
    {
        $location = Locations::find($id);
        $deleted  = $location->delete();

        return response()->json([
            'deleted' => $deleted,
        ]);
    }
}
