<?php

namespace App\Http\Controllers;
use App\Http\Resources\PraticienResource;
use App\Models\Praticien;

use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function show($id)
{
    $praticien = Praticien::with('Echelon')->findOrFail($id);
    return new PraticienResource($praticien);
}

public function index()
{
    $praticiens = Praticien::with('Echelon')->get();
    return PraticienResource::collection($praticiens);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
