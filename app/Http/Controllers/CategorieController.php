<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategorieRequest;
use App\Http\Resources\CategorieCollection;
use App\Http\Resources\CategorieResource;
use App\Models\categorie;

class CategorieController extends Controller
{
    

    public function index()
    {  
        $categorie= categorie::all();
        return new CategorieCollection($categorie);
    }


    public function store(CategorieRequest $request)
    {
    
       $categorie= categorie::create([
            'nom'=>$request->nom,
            'description'=>$request->description, 
        ]);
        return new CategorieResource($categorie);
    }


    
    public function show(categorie $categorie)
    {
        return response()->json($categorie);
    }


    public function update(CategorieRequest $request,categorie $categorie)
    {
       
       $categorie->update([
            'nom'=>$request->nom,
            'description'=>$request->description,
           
        ]);
        return new CategorieResource($categorie);
    }

    public function destroy(categorie $categorie)
    {
        $categorie->delete();
        return response()->json([
            'messsage'=>'categorie deleted'
        ]);
    }
}
