<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Parents;
use Illuminate\Http\Request;

class ParentsController extends Controller
{

    public function index()
    {
        $kids = Parents::all();

        foreach ($kids as $kid) {
            if ($kid->schools_id) {
                $school = School::find($kid->schools_id);
                $kid->school = $school->name;
            } else {
                $kid->school = 'Not selected';
            }
        }

        if ($kids)
            return response()->json([
                'success' => true,
                'message' => $kids
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Failed to get Kids list'
            ], 500);
    }

    public function show($id, Request $request)
    {
        $parents = Parents::where('id', $id);

        if ($parents->get())
            return response()->json([
                'success' => true,
                'message' => $parents->get()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'No Kids found with this id'
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
             'personalCode' =>'required|unique:parents,personalCode',
        ]);


        // $tevai = new Parents();
        // $tevai->name = $request->name;
        // $tevai->lname = $request->lname;
        // $tevai->class = $request->class;
        // $tevai->birthday = $request->birthday;
        // $tevai->personalCode = $request->personalCode;
        $tevai = Parents::create($request->all());

        if ($tevai->save())
            return response()->json([
                'success' => true,
                'message' => $tevai->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Cant save Kids info'
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
             'personalCode' =>'required|unique:parents,personalCode',
        ]);


        $parents = Parents::where('id', $id);

        if ($parents->update($request->all()))
            return response()->json([
                'success' => true,
                'message' => 'Kid updated'
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'cant save Kid'
            ], 500);
    }


    // public function destroy($id, Request $request)
    // {
        //Authentification
        // if (auth()->user()->role != 0)
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Unauthorized'
        //     ], 401);

    //     try {
    //         $tevai = Tevai::where('id', $id);

    //         $tevai->delete();

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Kid deleted'
    //         ]);
    //     } catch (\Illuminate\Database\QueryException $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'The Kid cannot be deleted because it is assigned to a school'
    //         ], 500);
    //     }
    // }

    public function destroy($id)
    {
        return Parents::destroy($id) === 0
            ? response(["message" => "failure"], 404)
            : response(["message" => "success"], 200);
    }
    public function bySchool($id)
    {
        $school = School::where('schools_id', $id);

        if ($school->get())
            return response()->json([
                'success' => true,
                'message' => $school->get()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Failed to get school list'
            ], 500);
    }
}
