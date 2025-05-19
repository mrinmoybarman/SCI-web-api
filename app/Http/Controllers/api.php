<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Doctor;
use App\Facility;
use App\Footfall;
use App\Hospital;
use App\NewsAndEvent;
use App\Slides;
use App\Updates;


class api extends Controller
{

    public function getCentreDoctor(Request $request){
        
        // get the centre code from body 
        $hospitalId = $request->hospitalId;

        // get doctors for the specific centre 
        $doctors = Doctor::where('hospitalId',$hospitalId)->where('status',1)->orderBy('indexx', 'desc')->get();

        // return as a json object
        return response()->json($doctors, 200);
    }

    public function getSingleDoctor($id){
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return response()->json(['message' => 'Doctor not found'], 404);
        }

        return response()->json($doctor);
    }

    public function getCenterFecility(Request $request){
        
        // get the centre code from body 
         $hospitalId = $request->hospitalId;

        // get news update  for the specific centre 
        $newsEvents = Facility::orderBy('id','desc')->where('hospitalId',$hospitalId)->get();
        return response()->json($newsEvents, 200);
    }
    
    public function getCentreFootfall(Request $request){
        
        // get the centre code from body 
        $hospitalId = $request->hospitalId;

        // get counts for the specific centre 
        $counts = Footfall::orderBy('id','desc')->where('hospitalId',$hospitalId)->first();

        return response()->json($counts, 200);
    }

    public function getHospitals(Request $request){
        // get all hospitals 
        $hospitals = Hospital::orderBy('id','desc')->get();

        return response()->json($hospitals, 200);
    }

    public function getSingleHospital($id){
        $doctor = Hospital::find($id);

        if (!$doctor) {
            return response()->json(['message' => 'Hospital not found'], 404);
        }

        return response()->json($doctor);
    }

    public function getCentreNewsEvents(Request $request){
        
        // get the centre code from body 
        $hospitalId = $request->hospitalId;

        // get news & event for the specific centre 
        $newsEvents = NewsAndEvent::orderBy('id','desc')->where('hospitalId',$hospitalId)->where('status',1)->get();

        return response()->json($newsEvents, 200);
    }

    public function getCentreSlides(Request $request){
        
        // get the centre code from body 
        $hospitalId = $request->hospitalId;

        // get news & event for the specific centre 
        $newsEvents = Slides::orderBy('id','desc')->where('hospitalId',$hospitalId)->get();

        return response()->json($newsEvents, 200);
    }

    public function getCentreUpdate(Request $request){
        
        // get the centre code from body 
        $hospitalId = $request->hospitalId;

        // get news update  for the specific centre 
        $newsEvents = Updates::orderBy('id','desc')->where('hospitalId',$hospitalId)->get();
        return response()->json($newsEvents, 200);
    }

    
    

}
