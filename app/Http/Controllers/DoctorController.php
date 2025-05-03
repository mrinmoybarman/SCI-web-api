<?php

namespace App\Http\Controllers;

use App\Doctor;
use App\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;


class DoctorController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if(Auth::user()->role ===9){
                $data = Doctor::all();
                $data = Doctor::join('users', 'doctors.addedBy', '=', 'users.id')
                    ->join('hospitals', 'doctors.hospitalId', '=', 'hospitals.id')
                    ->select('doctors.*', 'users.name as added_by_name', 'hospitals.name as hospital_name')
                    ->get();
            }
            else{
                $data = Doctor::Where('doctors.hospitalId',Auth::user()->hospitalId)
                    ->join('users', 'doctors.addedBy', '=', 'users.id')
                    ->join('hospitals', 'doctors.hospitalId', '=', 'hospitals.id')
                    ->select('doctors.*', 'users.name as added_by_name', 'hospitals.name as hospital_name')
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


        return view('doctor.index', compact('hospitals', 'userHospitalId'));  // yajra Datatable will call it from frontend through ajax, ['hospitals' => Hospital::all()] 
    }

    
    
    public function store(Request $request)
    {
        $request->validate([
            'hospitalId' => 'required',
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'depertment' => 'required|string|max:255',
            'qualification' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // dd($request);

        $data = $request->all();

        if(!$request->indexx){
            $data['indexx'] = 0;
        }

        $data['addedBy'] = Auth::id();
        $data['status'] = 1;

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('doctor_photo', 'public');
        }

        Doctor::create($data);

        return redirect()->route('doctors.index')->with('success', 'Doctors added successfully.');

    }

    
    public function show(Doctor $doctor)
    {
        //
    }

    
    public function edit(Doctor $doctor)
    {
        $hospital = Hospital::findOrFail($id);
        return view('doctors.edit', compact('hospital'));
    }

    
    public function update(Request $request, Doctor $doctor)
    {
        //
    }

    
    public function destroy(Doctor $doctor)
    {
        //
    }
}
