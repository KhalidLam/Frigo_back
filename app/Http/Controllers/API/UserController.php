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

            // $frigo_id = Frigo::where('user_id', $user->id)->get()  ;
            //detail frigo 
            $frigo = $user->frigo;
            return response()->json(['success' => [$frigo, $success]], $this->successStatus);
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


    public function profile(Request $request, $id){
    // $user = User::find($id) ;
    $user = User::with('profile')->find($id) ;

//   return ($user)  ;
     $file = $request->file('image');
     //    dd($file );
         $ext = $file->extension();
         $fileName = Carbon::now()->format('d-m-Y') . '-' . Str::random(10) . '.' . $ext;
         $request->file('image')->move(public_path("/img/"), $fileName);
 
         $user->avatar = 'img/' . $fileName ;
         $user->save() ;
        
        $user->profile->nom = $request->get('nom') ; 
        $user->profile->prenom = $request->get('prenom') ; 
        $user->profile->age = $request->get('age') ; 
        $user->profile->sexe = $request->get('sexe') ; 
        $user->profile->taille = $request->get('taille') ; 
        $user->profile->poids = $request->get('poids') ; 
        $user->profile->membre_date = date_format(date_create( $user->created_at ), "F d, Y ") ;
        $user->profile->save()  ;
  
        return response()->json([ 'success'  => $user    ], $this->successStatus);

    }
}
