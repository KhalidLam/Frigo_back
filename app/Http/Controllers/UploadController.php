<?php

namespace App\Http\Controllers;

use App\Photo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    public function uploadPhoto(Request $request)
    {
        $file = $request->file('file');
        // dd($file);
        $ext = $file->extension();
        $name = $request->file('file');
        // $mytime = Carbon::now()->format('d-m-Y');
        // $random = Str::random(10);
        $name = Carbon::now()->format('d-m-Y') . '-' . Str::random(10) . '.' . $ext;

        list($width, $height) = getimagesize($file);

        $path = Storage::disk('public')->putFileAs(
            'uploadImages',
            $file,
            $name
        );
        // $user = User::find(1);
        $user = Auth::User();

        // dd($user);
        $photo = $user->photos()->create([
            'uri' => $path,
            'public' => false,
            'width' => $width,
            'height' => $height
        ]);

        return response()->json(['upload' => 'success'], 200);
    }
    public function getPhoto()
    {

        $user = Auth::User();


        $photos = $user->photos()->get();

        return response()->json($photos, 200);
    }


    public function storeImage(Request $request){

        $file = $request->file('photo');
        $fileName = "frigo.jpg" ;
        $request->file('photo')->move(public_path("/img/"), $fileName ) ;
        $photoURL = url('/img/'.$fileName) ;
        return response()->json(['url'=> $photoURL],200) ;
    }
}
