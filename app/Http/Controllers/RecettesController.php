<?php

namespace App\Http\Controllers;

use App\Recette;
use Illuminate\Http\Request;

class RecettesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Recette::all() ;
    }

  
    public function store(Request $request)
    {
         return Recette::create($request->all()) ;
    }

    public function show($id)
    {
        return Recette::find($id) ;
    }

  
   
    public function update(Request $request, $id)
    {
        $recette =Recette::findOrFail($id) ;
        $recette->update($request->all()) ;

        return $recette ;
        
    }


    public function destroy($id)
    {
        $recette =Recette::findOrFail($id) ;
        $recette->delete() ;

        return 204  ;
    }
}
