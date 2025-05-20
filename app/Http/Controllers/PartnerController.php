<?php

namespace App\Http\Controllers;

use App\Partner;
use App\Hospital;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if(Auth::user()->role ===9){
                $data = Partner::join('users', 'partners.addedBy', '=', 'users.id')
                    ->join('hospitals', 'partners.hospitalId', '=', 'hospitals.id')
                    ->select('partners.*', 'users.name as added_by_name', 'hospitals.name as hospital_name')
                    ->get();
            }
            else{
                $data = Partner::Where('partners.hospitalId',Auth::user()->hospitalId)
                    ->join('users', 'partners.addedBy', '=', 'users.id')
                    ->join('hospitals', 'partners.hospitalId', '=', 'hospitals.id')
                    ->select('partners.*', 'users.name as added_by_name', 'hospitals.name as hospital_name')
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

        return view('partners.index', compact('hospitals', 'userHospitalId'));  // yajra Datatable will call it from frontend through ajax, ['hospitals' => Hospital::all()] 
    }

    public function store(Request $request)
    {
        $request->validate([
            'hospitalId' => 'required|exists:hospitals,id',
            'name' => 'required|string|max:255',
            'indexx' => 'required|integer',
            'photo' => 'required|image|max:2048',
        ]);

        $data = $request->all();
        $data['addedBy'] = Auth::id();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('partner_photo', 'public');
        }

        Partner::create($data);

        return redirect()->route('partners.index')->with('success', 'Partner added successfully.');
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

        $partner = Partner::findOrFail($id);
        return view('partners.edit', compact('partner', 'userHospitalId', 'hospitals'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'hospitalId' => 'required|exists:hospitals,id',
            'name' => 'required|string|max:255',
            'indexx' => 'required|integer',
            'photo' => 'nullable|image|max:2048',
        ]);

        $partner = Partner::findOrFail($id);

        // dd($slide, Auth::user());
        if(Auth::user()->role == 9 || $partner->hospitalId === Auth::user()->hospitalId){

            $partner->hospitalId = $request->hospitalId;
            $partner->indexx = $request->indexx;
            $partner->name = $request->name;
            
            if ($request->hasFile('photo')) {
                $imagePath = $request->file('photo')->store('partner_photo', 'public');
                $partner->photo = $imagePath;
            }
        
            $partner->save();
    
            return redirect()->route('partners.index')->with('success', 'Partner updated successfully!');
        }

        else{
            return redirect()->route('partners.index')->with('error', 'Unauthorized Access !');
        }
        
    }


    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);
        if(Auth::user()->role == 9 || $partner->hospitalId === Auth::user()->hospitalId){
          $partner->delete();
          return response()->json(['success' => 'Partner deleted successfully']);
        }
        else{
            return redirect()->route('partners.index')->with('error', 'Unauthorized Access !');
        }
    }
}
