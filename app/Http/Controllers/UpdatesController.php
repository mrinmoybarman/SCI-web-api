<?php

namespace App\Http\Controllers;

use App\Updates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Hospital;
use DataTables;

class UpdatesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if(Auth::user()->role ===9){
                $data = Updates::all();
                $data = Updates::join('users', 'updates.addedBy', '=', 'users.id')
                    ->join('hospitals', 'updates.hospitalId', '=', 'hospitals.id')
                    ->select('updates.*', 'users.name as added_by_name', 'hospitals.name as hospital_name')
                    ->get();
            }
            else{
                $data = Updates::Where('updates.hospitalId',Auth::user()->hospitalId)
                    ->join('users', 'updates.addedBy', '=', 'users.id')
                    ->join('hospitals', 'updates.hospitalId', '=', 'hospitals.id')
                    ->select('updates.*', 'users.name as added_by_name', 'hospitals.name as hospital_name')
                    ->get();
            }
            return DataTables::of($data)->make(true);
        }

        $hospitals = Hospital::all();

        if(Auth::user()->role !==9){
            $userHospitalId = Auth::user()->hospitalId;
        }
        else{
            $userHospitalId = null;
        }

        // dd($userHospitalId);

        return view('updates.index', compact('hospitals', 'userHospitalId'));  // yajra Datatable will call it from frontend through ajax, ['hospitals' => Hospital::all()] 
    }

    public function store(Request $request)
    {
        $request->validate([
            'hospitalId' => 'required|exists:hospitals,id',
            'name' => 'required|string|max:255',
            'indexx' => 'required|integer',
            'link' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['addedBy'] = Auth::id();

        Updates::create($data);

        return redirect()->route('updates.index')->with('success', 'Update added successfully.');
    }


    public function edit($id)
    {

        if(Auth::user()->role !==9){
            $userHospitalId = Auth::user()->hospitalId;
        }
        else{
            $userHospitalId = null;
        }

        $hospitals = Hospital::all();

        $update = Updates::findOrFail($id);
        return view('updates.edit', compact('update', 'userHospitalId', 'hospitals'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'hospitalId' => 'required|exists:hospitals,id',
            'name' => 'required|string|max:255',
            'indexx' => 'required|integer',
            'link' => 'nullable|string',
        ]);

        $update = Updates::findOrFail($id);

        if($update->hospitalId === Auth::user()->hospitalId){

            $update->hospitalId = $request->hospitalId;
            $update->name = $request->name;
            $update->indexx = $request->indexx;
            $update->link = $request->link;
            $update->save();
    
            return redirect()->route('updates.index')->with('success', 'Updates updated successfully!');
        }

        else{
            return redirect()->route('updates.index')->with('error', 'Unauthorized Access !');
        }
        
    }


    public function destroy($id)
    {
        $update = Updates::findOrFail($id);
        if($update->hospitalId === Auth::user()->hospitalId){
          $update->delete();
          return response()->json(['success' => 'Update deleted successfully']);
        }
        else{
            return redirect()->route('updates.index')->with('error', 'Unauthorized Access !');
        }
    }
}
