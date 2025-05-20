<?php

namespace App\Http\Controllers;

use App\NewsAndEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Hospital;
use App\NewsEventPhoto;

class NewsAndEventController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if(Auth::user()->role ===9){
                $data = NewsAndEvent::with('photos')
                    ->join('users', 'news_and_events.addedBy', '=', 'users.id')
                    ->join('hospitals', 'news_and_events.hospitalId', '=', 'hospitals.id')
                    ->select('news_and_events.*', 'users.name as added_by_name', 'hospitals.name as hospital_name')
                    ->get();
            }
            else{
                $data = NewsAndEvent::with('photos')
                    ->where('news_and_events.hospitalId',Auth::user()->hospitalId)
                    ->join('users', 'news_and_events.addedBy', '=', 'users.id')
                    ->join('hospitals', 'news_and_events.hospitalId', '=', 'hospitals.id')
                    ->select('news_and_events.*', 'users.name as added_by_name', 'hospitals.name as hospital_name')
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


        return view('news_and_events.index', compact('hospitals', 'userHospitalId'));  // yajra Datatable will call it from frontend through ajax, ['hospitals' => Hospital::all()] 
    }

    public function store(Request $request)
    {
        $request->validate([
            'hospitalId' => 'required|exists:hospitals,id',
            'name' => 'required|string|max:255',
            'indexx' => 'required|integer',
            'date' => 'required|date',
            'details' => 'required|string',
            'photos.*' => 'required|image|max:2048',
        ]);

        $data = $request->all();
        $data['addedBy'] = Auth::id();

        $newsEvent = NewsAndEvent::create($data);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $image) {
                $path = $image->store('news_and_events_photo', 'public');

                // Create record in news_event_photos table
                NewsEventPhoto::create([
                    'news_event_id' => $newsEvent->id,
                    'photo_path' => $path,
                ]);
            }
        }


        return redirect()->route('news_and_events.index')->with('success', 'News/Event added successfully.');
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

        $news_and_event = NewsAndEvent::findOrFail($id);
        return view('news_and_events.edit', compact('news_and_event', 'userHospitalId', 'hospitals'));
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

        $facility = NewsAndEvent::findOrFail($id);

        if(Auth::user()->role == 9 || $facility->addedBy === Auth::user()->id){

            $facility->hospitalId = $request->hospitalId;
            $facility->name = $request->name;
            $facility->indexx = $request->indexx;
            $facility->details = $request->details;
            $facility->date = $request->date;
        
            $facility->save();

            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $image) {
                    $path = $image->store('news_and_events_photo', 'public');

                    // Create record in news_event_photos table
                    NewsEventPhoto::create([
                        'news_event_id' => $facility->id,
                        'photo_path' => $path,
                    ]);
                }
            }
    
            return redirect()->route('news_and_events.index')->with('success', 'News/Event updated successfully!');
        }

        else{
            return redirect()->route('news_and_events.index')->with('error', 'Unauthorized Access !');
        }
        
    }


    public function destroy($id)
    {
        $facility = NewsAndEvent::findOrFail($id);
        if(Auth::user()->role == 9 || $facility->addedBy === Auth::user()->id){
            $facility->delete();
            return response()->json(['success' => 'News/Event deleted successfully']);
        }
        else{
            return redirect()->route('news_and_events.index')->with('error', 'Unauthorized Access !');
        }
        
    }
}
