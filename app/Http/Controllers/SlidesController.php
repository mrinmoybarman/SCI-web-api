<?php

namespace App\Http\Controllers;

use App\Slides;
use Illuminate\Http\Request;
use App\Hospital;
use DataTables;
use Illuminate\Support\Facades\Auth;

class SlidesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if(Auth::user()->role ===9){
                $data = Slides::all();
                $data = Slides::join('users', 'slides.addedBy', '=', 'users.id')
                    ->join('hospitals', 'slides.hospitalId', '=', 'hospitals.id')
                    ->select('slides.*', 'users.name as added_by_name', 'hospitals.name as hospital_name')
                    ->get();
            }
            else{
                $data = Slides::Where('slides.hospitalId',Auth::user()->hospitalId)
                    ->join('users', 'slides.addedBy', '=', 'users.id')
                    ->join('hospitals', 'slides.hospitalId', '=', 'hospitals.id')
                    ->select('slides.*', 'users.name as added_by_name', 'hospitals.name as hospital_name')
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

        return view('slides.index', compact('hospitals', 'userHospitalId'));  // yajra Datatable will call it from frontend through ajax, ['hospitals' => Hospital::all()] 
    }

    public function store(Request $request)
    {
        $request->validate([
            'hospitalId' => 'required|exists:hospitals,id',
            'indexx' => 'required|integer',
            'photo' => 'required|image|max:2048',
        ]);

        $data = $request->all();
        $data['addedBy'] = Auth::id();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('slides_photo', 'public');
        }

        Slides::create($data);

        return redirect()->route('slides.index')->with('success', 'Slide added successfully.');
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

        $slide = Slides::findOrFail($id);
        return view('slides.edit', compact('slide', 'userHospitalId', 'hospitals'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'hospitalId' => 'required|exists:hospitals,id',
            'indexx' => 'required|integer',
            'photo' => 'nullable|image|max:2048',
        ]);

        $slide = Slides::findOrFail($id);

        // dd($slide, Auth::user());
        if(Auth::user()->role == 9 || $slide->hospitalId === Auth::user()->hospitalId){

            $slide->hospitalId = $request->hospitalId;
            $slide->indexx = $request->indexx;
            
            if ($request->hasFile('photo')) {
                $imagePath = $request->file('photo')->store('facility_photo', 'public');
                $slide->photo = $imagePath;
            }
        
            $slide->save();
    
            return redirect()->route('slides.index')->with('success', 'Slide updated successfully!');
        }

        else{
            return redirect()->route('slides.index')->with('error', 'Unauthorized Access !');
        }
        
    }


    public function destroy($id)
    {
        $slide = Slides::findOrFail($id);
        if(Auth::user()->role == 9 || $slide->hospitalId === Auth::user()->hospitalId){
          $slide->delete();
          return response()->json(['success' => 'Slide deleted successfully']);
        }
        else{
            return redirect()->route('slides.index')->with('error', 'Unauthorized Access !');
        }
    }
}
