<?php

namespace App\Http\Controllers;


use App\Models\plante;
use Illuminate\Http\Request;
use App\Http\Requests\PlanteRequest;
use Illuminate\Support\Facades\Auth;
use  App\Http\Resources\PlanteResource;
use App\Http\Resources\PlanteCollection;

class PlanteController extends Controller
{  
    public function __construct()
    {
      
        $this->middleware('permission:consulter_plantes', ['only' => ['index','show']]);
        $this->middleware('permission:créer_plante', ['only' =>  ['store']]);
        $this->middleware('permission:éditer_plantes', ['only' =>  ['update']]);
        $this->middleware('permission:supprimer_plantes', ['only' =>  ['destroy']]);
    } 
    
    public function index()
    {  
        $plante= plante::all();
        return new PlanteCollection($plante);
    }

   

   
    public function store(PlanteRequest $request)
    {
    
       $plante= plante::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'image'=>$request->image,
            'prix'=>$request->prix,
            'categorie_id'=>$request->categorie_id,
            'user_id'=>Auth::user()->id,
        ]);
        return new PlanteResource($plante);
    }

   


    public function show(plante $plante)
    {
        return response()->json($plante);
    }

   
    

   
    public function update(PlanteRequest $request,plante $plante)
    {
       
       $plante->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'image'=>$request->image,
            'prix'=>$request->prix,
            'categorie_id'=>$request->categorie_id,
        ]);
        return new PlanteResource($plante);
    }

   

    
    public function destroy(plante $plante)
    {
        $plante->delete();
        return response()->json([
            'messsage'=>'plante deleted'
        ]);
    }
}
