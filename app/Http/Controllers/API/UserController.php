<?php

namespace App\Http\Controllers\API;

use App\Frigo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
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

        

        // $UserEmail = User::where('email', $request->get('email'))->first();
        //  dd( $UserEmail);
            // if ($UserEmail) {
            //     // dd(   $UserEmail) ;
            //     return response()->json(['cette adresse email est déjà utilisée' => $UserEmail], 208);
           
            // }else{
            //     dd('not  found'); 
            // }
       

            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);


        //la creation du frigo automatic
        $frigo = $user->frigo()->create([
            'name' => 'frigo_' . $user->name,
            'image' => 'img/frigo-rangement-optimisation.jpg'

        ]);

        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
        //    $Auth = Auth::user(); 
        $frigo =  $user->frigo;
        //   dd($frigo);
        return response()->json(['success' => [$frigo, $success]], $this->successStatus);
    }
    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function details()
    {
        $user = Auth::user();
        // dd($frigo_id) ;
        return response()->json(['success' =>  $user], $this->successStatus);
    }
}
