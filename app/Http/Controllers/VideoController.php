<?php

namespace App\Http\Controllers;

use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Hospital;
use DataTables;class VideoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if(Auth::user()->role ===9){
                $data = Video::join('users', 'videos.addedBy', '=', 'users.id')
                    ->join('hospitals', 'videos.hospitalId', '=', 'hospitals.id')
                    ->select('videos.*', 'users.name as added_by_name', 'hospitals.name as hospital_name')
                    ->get();
            }
            else{
                $data = Video::Where('videos.hospitalId',Auth::user()->hospitalId)
                    ->join('users', 'videos.addedBy', '=', 'users.id')
                    ->join('hospitals', 'videos.hospitalId', '=', 'hospitals.id')
                    ->select('videos.*', 'users.name as added_by_name', 'hospitals.name as hospital_name')
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
        return view('videos.index', compact('hospitals', 'userHospitalId'));  // yajra Datatable will call it from frontend through ajax, ['hospitals' => Hospital::all()] 
    }

    public function store(Request $request)
    {
        $request->validate([
            'hospitalId' => 'required|exists:hospitals,id',
            'name' => 'required|string|max:255',
            'indexx' => 'required|integer',
            'link' => ['nullable', 'url', 'required_without:video'],
            'video' => ['nullable', 'mimes:mp4,avi,mov', 'max:20480', 'required_without:link'],
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'link.required_without' => 'Either link or video is required.',
            'video.required_without' => 'Either link or video is required.',
        ]);

        $videoPath = null;

        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('videos', 'public');
        }

        $photoPath = $request->file('photo')->store('thumbnails', 'public');

        Video::create([
            'hospitalId' => $request->hospitalId,
            'addedBy' => auth()->id(), // assumes user is authenticated
            'name' => $request->name,
            'indexx' => $request->indexx,
            'link' => $request->link,
            'video' => $videoPath,
            'photo' => $photoPath,
        ]);

        return redirect()->route('videos.index')->with('success', 'Video created successfully.');
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

        $video = Video::findOrFail($id);
        return view('videos.edit', compact('video', 'userHospitalId', 'hospitals'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request data including optional video
        $request->validate([
            'hospitalId' => 'required|exists:hospitals,id',
            'name' => 'required|string|max:255',
            'indexx' => 'required|integer',
            'link' => 'nullable|string',
            'video' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:51200', // max 50MB
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $update = Video::findOrFail($id);

        // Check if user has permission
        if (Auth::user()->role == 9 || $update->hospitalId === Auth::user()->hospitalId) {

            // Handle video file upload if present
            if ($request->hasFile('video')) {
                // Optionally delete the old video if it exists
                if ($update->video && file_exists(public_path('uploads/videos/' . $update->video))) {
                    unlink(public_path('uploads/videos/' . $update->video));
                }

                $video = $request->file('video');
                $videoName = time() . '_' . uniqid() . '.' . $video->getClientOriginalExtension();
                $video->move(public_path('uploads/videos'), $videoName);

                $update->video = $videoName;
            }

            if ($request->hasFile('photo')) {
                $imagePath = $request->file('photo')->store('thumbnails', 'public');
                $update->photo = $imagePath;
            }

            // Update the other fields
            $update->hospitalId = $request->hospitalId;
            $update->name = $request->name;
            $update->indexx = $request->indexx;
            $update->link = $request->link;
            $update->save();

            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Update successful',
                    'redirect' => route('videos.index'),
                ]);
            }

            return redirect()->route('videos.index')->with('success', 'Update record modified successfully!');
        }

        if ($request->ajax()) {
                return response()->json([
                    'message' => 'Update successful',
                    'redirect' => route('videos.index'),
                ]);
        }
        return redirect()->route('videos.index')->with('error', 'Unauthorized Access!');
    }



    public function destroy($id)
    {
        $update = Video::findOrFail($id);
        if(Auth::user()->role == 9 || $update->hospitalId === Auth::user()->hospitalId){
          $update->delete();
          return response()->json(['success' => 'Video deleted successfully']);
        }
        else{
            return redirect()->route('videos.index')->with('error', 'Unauthorized Access !');
        }
    }
}
