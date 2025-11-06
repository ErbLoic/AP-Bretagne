<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Praticien;

class PraticienControlleur extends Controller
{
    public function index()
    {
        $praticiens = Praticien::all();
        return view('praticiens.index', compact('praticiens'));
    }

    public function show($id)
    {
        $praticien = Praticien::findOrFail($id);
        return view('praticiens.show', compact('praticien'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $praticiens = Praticien::where('nom', 'like', '%' . $query . '%')
            ->get();

        return view('praticiens.index', compact('praticiens'));
    }
}
