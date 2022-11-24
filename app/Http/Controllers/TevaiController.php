<?php

namespace App\Http\Controllers;

use App\Models\Darzelis;
use App\Models\Tevai;
use Illuminate\Http\Request;

class TevaiController extends Controller
{

    public function index()
    {
        $kids= Tevai::all();

        foreach ($kids as $kid) {
            if($kid->darzelis_id) {
                $darzelis = Darzelis::find($kid->darzelis_id);
                $kid->darzelis = $darzelis->name;
            } else {
                $kid->darzelis = 'Not selected';
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
        $country = Tevai::where('id', $id);

        if ($country->get())
            return response()->json([
                'success' => true,
                'message' => $country->get()
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
        if (auth()->user()->role != 0)
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);

        $this->validate($request, [
            'name' => 'required',
            'personalCode' => 'required'
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
                'message' => 'Cant save Kids info'
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
            'personalCode' => 'required'
        ]);


        $tevai = Tevai::where('id', $id);

        if ($tevai->update($request->all()))
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
                'message' => 'Kid deleted'
            ]);
        } catch(\Illuminate\Database\QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'The Kid cannot be deleted because it is assigned to a school'
            ], 500);
        }
    }
    public function byDarzelis($id)
    {
        $school = Darzelis::where('darzelis_id', $id);

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
