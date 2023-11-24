<?php

namespace App\Http\Controllers;

use App\Http\Requests\Critique\StoreCritiqueRequest;
use App\Http\Requests\Critique\UpdateCritiqueRequest;
use App\Models\Critique;

class CritiqueController extends Controller
{
    public function index()
    {
        return 'test';
    }

    public function store(StoreCritiqueRequest $request)
    {
        //
    }
    public function show(Critique $critique)
    {
        //
    }
    public function update(UpdateCritiqueRequest $request, Critique $critique)
    {
        //
    }
    public function destroy(Critique $critique)
    {
        //
    }
}
