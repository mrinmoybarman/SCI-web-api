<?php

namespace App\Http\Controllers;

use App\Footfall;
use App\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;


class FootfallController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if(Auth::user()->role ===9){
                $data = Footfall::join('users', 'footfalls.addedBy', '=', 'users.id')
                    ->join('hospitals', 'footfalls.hospitalId', '=', 'hospitals.id')
                    ->select('footfalls.*', 'users.name as added_by_name', 'hospitals.name as hospital_name')
                    ->get();
            }
            else{
                $data = Footfall::Where('footfalls.hospitalId',Auth::user()->hospitalId)
                    ->join('users', 'footfalls.addedBy', '=', 'users.id')
                    ->join('hospitals', 'footfalls.hospitalId', '=', 'hospitals.id')
                    ->select('footfalls.*', 'users.name as added_by_name', 'hospitals.name as hospital_name')
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

        return view('footfall.index', compact('hospitals', 'userHospitalId'));  // yajra Datatable will call it from frontend through ajax, ['hospitals' => Hospital::all()] 
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'location' => 'required|string|max:255',
        //     'level' => 'required|string|max:255',
        //     'address' => 'required|string|max:255',
        //     'email' => 'nullable|email',
        //     'logo_primary' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        //     'logo_secondary' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        // ]);

        // $data = $request->only(['name', 'email', 'location', 'level']);

        
        // dd($request);

        $data = $request->all();
        $data['addedBy'] = Auth::id();
        Footfall::create($data);

        return redirect()->route('footfall.index')->with('success', 'Footfall added successfully.');
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

        $footfall = Footfall::findOrFail($id);
        return view('footfall.edit', compact('footfall', 'userHospitalId', 'hospitals'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'hospitalId' => 'required|exists:hospitals,id',  // Ensure hospital exists
            'date' => 'required|date',
            'patient' => 'required|numeric',
            'chemo' => 'required|numeric',
            'radiation' => 'required|numeric',
            'doctors' => 'required|numeric',
            'total_beds' => 'required|numeric',
        ]);

        // dd('validated');

        $footfall = Footfall::findOrFail($id);

        // dd($footfall);

        if(Auth::user()->role == 9 || $footfall->addedBy === Auth::user()->id){
            $footfall->update([
                'hospitalId' => $request->hospitalId,
                'date' => $request->date,
                'patient' => $request->patient,
                'chemo' => $request->chemo,
                'radiation' => $request->radiation,
                'doctors' => $request->doctors,
                'total_beds' => $request->total_beds,
            ]);
    
            return redirect()->route('footfall.index')->with('success', 'Footfall updated successfully!');
        }

        else{
            return redirect()->route('footfall.index')->with('error', 'Unauthorized Access !');
        }
        
    }


    public function destroy($id)
    {
        $footfall = Footfall::findOrFail($id);
        if(Auth::user()->role == 9 || $footfall->addedBy === Auth::user()->id){
            $footfall->delete();
            return response()->json(['success' => 'Footfall deleted successfully']);
        }
        else{
            return redirect()->route('footfall.index')->with('error', 'Unauthorized Access !');
        }
    }
}
