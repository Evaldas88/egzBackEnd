<?php

namespace App\Http\Controllers;

use App\Models\Darzelis;
use Illuminate\Http\Request;

class DarzelisController extends Controller
{

    public function index()
    {
        $Darzelis = Darzelis::all();

        if ($Darzelis)
            return response()->json([
                'success' => true,
                'message' => $Darzelis
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Failed to get list of countries'
            ], 500);
    }

    public function show($id, Request $request)
    {
        $Darzelis = Darzelis::where('id', $id);

        if ($Darzelis->get())
            return response()->json([
                'success' => true,
                'message' => $Darzelis->get()
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


        $Darzelis = new Darzelis();
        $Darzelis->name = $request->name;
        $Darzelis->code = $request->code;

        if ($Darzelis->save())
            return response()->json([
                'success' => true,
                'message' => $Darzelis->toArray()
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


        $Darzelis = Darzelis::where('id', $id);

        if ($Darzelis->update($request->all()))
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
            $Darzelis = Darzelis::where('id', $id);

            $Darzelis->delete();

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
