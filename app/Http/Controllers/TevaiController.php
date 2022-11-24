<?php

namespace App\Http\Controllers;

use App\Models\Tevai;
use Illuminate\Http\Request;

class TevaiController extends Controller
{

    public function index()
    {
        $countries = Tevai::all();

        if ($countries)
            return response()->json([
                'success' => true,
                'message' => $countries
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Failed to get list of countries'
            ], 500);
    }

    public function show($id, Request $request)
    {
        $country = Tevai::where('id', $id);

        if ($country->get())
            return response()->json([
                'success' => true,
                'message' => $country->get()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'No country found with this id'
            ], 500);
    }


    public function store(Request $request)
    {
        //Authentification
        if (auth()->user()->role != 0)
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);

        $this->validate($request, [
            'name' => 'required',
            'season' => 'required'
        ]);


        $tevai = new Tevai();
        $tevai->name = $request->name;
        $tevai->class = $request->class;
        $tevai->personalCode = $request->personalCode;


        if ($tevai->save())
            return response()->json([
                'success' => true,
                'message' => $tevai->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Cant save country'
            ], 500);
    }


    public function update($id, Request $request)
    {
        //Authentification
        if (auth()->user()->role != 0)
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);

        $this->validate($request, [
            'name' => 'required',
            'season' => 'required'
        ]);


        $tevai = Tevai::where('id', $id);

        if ($tevai->update($request->all()))
            return response()->json([
                'success' => true,
                'message' => 'Country updated'
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'cant save country'
            ], 500);
    }


    public function destroy($id, Request $request)
    {
        //Authentification
        if (auth()->user()->role != 0)
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);

        try {
            $tevai = Tevai::where('id', $id);

            $tevai->delete();

            return response()->json([
                'success' => true,
                'message' => 'Country deleted'
            ]);
        } catch(\Illuminate\Database\QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'The country cannot be deleted because it is assigned to a hotel'
            ], 500);
        }
    }
}
