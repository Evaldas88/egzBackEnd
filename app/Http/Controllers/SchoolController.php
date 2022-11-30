<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{

    public function index()
    {
        $School = School::all();

        if ($School)
            return response()->json([
                'success' => true,
                'message' => $School
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Failed to get list of countries'
            ], 500);
    }

    public function show($id, Request $request)
    {
        $School = School::where('id', $id);

        if ($School->get())
            return response()->json([
                'success' => true,
                'message' => $School->get()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'No school  found with this id'
            ], 500);
    }


    public function store(Request $request)
    {
        //Authentification
        // if (auth()->user()->role != 0)
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Unauthorized'
        //     ], 401);

        $this->validate($request, [
            'name' => 'required|max:255|unique:schools,name',
            'address' => 'required|max:255',
            'code' => 'required|max:255',
        ]);


        $School = School::create($request->all());


        if ($School->save())
            return response()->json([
                'success' => true,
                'message' => $School->toArray()
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
        // if (auth()->user()->role != 0)
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Unauthorized'
        //     ], 401);

        $this->validate($request, [
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'code' => 'required|max:255',
        ]);


        $School = School::where('id', $id);

        if ($School->update($request->all()))
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


    // public function destroy($id, Request $request)
    // {
    //     //Authentification
    //     if (auth()->user()->role != 0)
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Unauthorized'
    //         ], 401);

    //     try {
    //         $School = School::where('id', $id);

    //         $School->delete();

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Country deleted'
    //         ]);
    //     } catch(\Illuminate\Database\QueryException $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'The country cannot be deleted because it is assigned to a hotel'
    //         ], 500);
    //     }
    // }

    public function destroy($id)
    {
        return School::destroy($id) === 0
            ? response(["status" => "failure"], 404)
            : response(["status" => "success"], 200);
    }
}
