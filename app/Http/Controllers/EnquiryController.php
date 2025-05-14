<?php

namespace App\Http\Controllers;

use App\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Hospital;
use DataTables;
use Illuminate\Support\Facades\Auth;


class EnquiryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if(Auth::user()->role ===9){
                $data = Enquiry::all();
                $data = Enquiry::join('hospitals', 'enquiries.hospitalId', '=', 'hospitals.id')
                    ->select('enquiries.*', 'hospitals.name as hospital_name')
                    ->get();
            }
            else{
                $data = Enquiry::Where('enquiries.hospitalId',Auth::user()->hospitalId)
                    ->join('hospitals', 'enquiries.hospitalId', '=', 'hospitals.id')
                    ->select('enquiries.*', 'hospitals.name as hospital_name')
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
        return view('enquiries.index', compact('hospitals', 'userHospitalId'));  // yajra Datatable will call it from frontend through ajax, ['hospitals' => Hospital::all()] 
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hospitalId' => 'required|exists:hospitals,id',
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'mobile'     => 'required|string|max:15',
            'message'    => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
                'message' => 'Validation failed.'
            ], 422);
        }

        $data = $request->all();

        Enquiry::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Message Sent Successfully.'
        ], 200);
    }

    public function destroy($id)
    {
        $facility = Enquiry::findOrFail($id);
        if(Auth::user()->role == 9 || $facility->hospitalId === Auth::user()->hospitalId){
          $facility->delete();
          return response()->json(['success' => 'Enquiry deleted successfully']);
        }
        else{
            return redirect()->route('enquiries.index')->with('error', 'Unauthorized Access !');
        }
    }
}
