<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NewsEventPhoto;
use Illuminate\Support\Facades\Storage;


class NewsEventPhotoController extends Controller
{
   public function Destroy($id)
    {
        $photo = NewsEventPhoto::findOrFail($id);

        // Delete from storage
        if (
            Storage::disk('public')->exists($photo->photo_path)) {
            Storage::disk('public')->delete($photo->photo_path);
        }

        // Delete from database
        $photo->delete();

        return back()->with('success', 'Photo deleted successfully.');
    }
}
