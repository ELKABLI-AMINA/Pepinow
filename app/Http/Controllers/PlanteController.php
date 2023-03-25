<?php

namespace App\Http\Controllers;


use App\Models\plante;
use Illuminate\Http\Request;
use  App\Http\Resources\PlanteResource;
use App\Http\Resources\PlanteCollection;
use App\Http\Requests\PlanteRequest;
class PlanteController extends Controller
{
    
    public function index()
    {  
        $plante= plante::all();
        return new PlanteCollection($plante);
    }

   

   
    public function store(PlanteRequest $request)
    {
    
       $plante= plante::create([
            'nom'=>$request->nom,
            'description'=>$request->description,
            'image'=>$request->image,
            'prix'=>$request->prix,
            'categorie_id'=>$request->categorie_id,
            'user_id'=>1,
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
            'nom'=>$request->nom,
            'description'=>$request->description,
            'image'=>$request->image,
            'prix'=>$request->prix,
            'categorie_id'=>$request->categorie_id,
            'user_id'=>1,
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
