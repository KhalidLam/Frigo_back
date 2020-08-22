<?php

namespace App\Http\Controllers\API;

use App\Frigo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Validator;

class UserController extends Controller
{
    public $successStatus = 200;
    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function login()
    {
        if (Auth::attempt(['email'  => request('email'), 'password' => request('password')])) {
            $user = Auth::user();

            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['name'] =  $user->name;
            // $frigo_id = Frigo::where('user_id', $user->id)->get()  ;
            //detail frigo 
            $frigo = $user->frigo;
            return response()->json(['success' => [$frigo, $success  ]], $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
  //la creation du frigo automatic
        $frigo = $user->frigo()->create([
            'name' => 'frigo_' . $user->name,
            'image' => 'img/frigo-rangement-optimisation.jpg'

        ]);
        // $profile = $user->profile()->create([
        //     'prenom' =>   $user->name,  
        // ]);
     
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
        //    $Auth = Auth::user(); 
        $frigo =  $user->frigo;
        //   dd($frigo);
        return response()->json(['success' => [$frigo,
        // $profile, 
        $success]], $this->successStatus); 

    }
    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function details()
    { 
        $user = Auth::user() ;
        $user->profile ;
        return response()->json(['success'  => $user    ], $this->successStatus);
    }


    public function update(Request $request )
    {  
        $user = Auth::user();
    }

    
    public function EditAvatar(Request $request  ){

        $user = User::find(Auth()->user()->id) ;
        $file = $request->file('image');
        
         $ext = $file->extension();
         $fileName = Carbon::now()->format('d-m-Y') . '-' . Str::random(10) . '.' . $ext;
         $request->file('image')->move(public_path("/img/"), $fileName);
 
         $user->avatar = 'img/' . $fileName ;
         $user->save() ;
         return response()->json([ 'success'  => $user    ], $this->successStatus);

    }
    public function profile(Request $request ){
    // $user = User::find($id) ;
    $user = User::with('profile')->find(Auth()->user()->id) ;
    if( $request->get('name') !== 'undefined' ){
        $user->name =$request->get('name') ;  
    }
      
        $user->save() ;
        foreach ($request->except('name') as $key => $value) {
            if( $value !== 'undefined' ){
                $user->profile->$key = $value;  
            }
        } 
        $user->profile->membre_date = date_format(date_create( $user->created_at ), "F d, Y ") ;
        $user->profile->save()  ; 
        return response()->json([ 'success'  => $user    ], $this->successStatus);

    }
}
