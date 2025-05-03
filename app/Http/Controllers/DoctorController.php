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
            'hospitalId' => 'required|exists:hospitals,id',
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'depertment' => 'nullable|string|max:255',
            'indexx' => 'nullable|integer',
            'qualification' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'achievement' => 'nullable|string|max:255',
            'awards' => 'nullable|string|max:255',
            'profile_details' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
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

    
    public function edit($id)
    {
        if(Auth::user()->role !==9){
            $userHospitalId = Auth::user()->hospitalId;
        }
        else{
            $userHospitalId = null;
        }

        $hospitals = Hospital::all();

        $doctor = Doctor::findOrFail($id);
        return view('doctor.edit', compact('doctor', 'userHospitalId', 'hospitals'));
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'hospitalId' => 'required|exists:hospitals,id',
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'depertment' => 'nullable|string|max:255',
            'indexx' => 'nullable|integer',
            'qualification' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'achievement' => 'nullable|string|max:255',
            'awards' => 'nullable|string|max:255',
            'profile_details' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);
    
        $doctor = Doctor::findOrFail($id);

        if($doctor->addedBy === Auth::user()->id){
            
            $doctor->hospitalId = $request->hospitalId;
            $doctor->name = $request->name;
            $doctor->designation = $request->designation;
            $doctor->depertment = $request->depertment;
            $doctor->indexx = $request->indexx;
            $doctor->qualification = $request->qualification;
            $doctor->specialization = $request->specialization;
            $doctor->achievement = $request->achievement;
            $doctor->awards = $request->awards;
            $doctor->profile_details = $request->profile_details;
        
            if ($request->hasFile('photo')) {
                $imagePath = $request->file('photo')->store('doctors', 'public');
                $doctor->photo = $imagePath;
            }
        
            $doctor->save();
        
            return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully.');
        }
        
        else{
            return redirect()->route('doctors.index')->with('error', 'Unauthorized Access !');
        }
    }

    
    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();

        return response()->json(['success' => 'Doctor deleted successfully']);
    }
}
