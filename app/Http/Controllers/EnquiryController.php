<?php

namespace App\Http\Controllers;

use App\Enquiry;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if(Auth::user()->role ===9){
                $data = Facility::all();
                $data = Facility::join('users', 'facilities.addedBy', '=', 'users.id')
                    ->join('hospitals', 'facilities.hospitalId', '=', 'hospitals.id')
                    ->select('facilities.*', 'users.name as added_by_name', 'hospitals.name as hospital_name')
                    ->get();
            }
            else{
                $data = Facility::Where('facilities.hospitalId',Auth::user()->hospitalId)
                    ->join('users', 'facilities.addedBy', '=', 'users.id')
                    ->join('hospitals', 'facilities.hospitalId', '=', 'hospitals.id')
                    ->select('facilities.*', 'users.name as added_by_name', 'hospitals.name as hospital_name')
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

        return view('facility.index', compact('hospitals', 'userHospitalId'));  // yajra Datatable will call it from frontend through ajax, ['hospitals' => Hospital::all()] 
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'hospitalId' => 'required|exists:hospitals,id',
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|integer',
        //     'mobile' => 'required|string',
        //     'message' => 'required|string',
        // ]);

        $data = $request->all();

        Enquiry::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Message Sent Successfully.'
        ], 200);
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

        $facility = Facility::findOrFail($id);
        return view('facility.edit', compact('facility', 'userHospitalId', 'hospitals'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'hospitalId' => 'required|exists:hospitals,id',
            'name' => 'required|string|max:255',
            'indexx' => 'required|integer',
            'details' => 'required|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $facility = Facility::findOrFail($id);

        if(Auth::user()->role == 9 || $facility->hospitalId === Auth::user()->hospitalId){

            $facility->hospitalId = $request->hospitalId;
            $facility->name = $request->name;
            $facility->indexx = $request->indexx;
            $facility->details = $request->details;
        
            if ($request->hasFile('photo')) {
                $imagePath = $request->file('photo')->store('facility_photo', 'public');
                $facility->photo = $imagePath;
            }
        
            $facility->save();
    
            return redirect()->route('facilities.index')->with('success', 'Facility updated successfully!');
        }

        else{
            return redirect()->route('facilities.index')->with('error', 'Unauthorized Access !');
        }
        
    }


    public function destroy($id)
    {
        $facility = Facility::findOrFail($id);
        if(Auth::user()->role == 9 || $facility->hospitalId === Auth::user()->hospitalId){
          $facility->delete();
          return response()->json(['success' => 'Footfall deleted successfully']);
        }
        else{
            return redirect()->route('facilities.index')->with('error', 'Unauthorized Access !');
        }
    }
}
