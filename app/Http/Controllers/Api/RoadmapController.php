<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\roadmap;
use App\Models\Steps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoadmapController extends Controller
{

    public function createRoadmap(Request $request)
    {
            // Validate the incoming request data
            $request->validate([
                'etat' => 'required|string',
                'steps' => 'required|array',
                'steps.*' => 'exists:steps,id',
                'id_dec' => 'required|exists:declarations,id',
                'id_cit' => 'required|exists:citoyens,id',
                'date_debut' => 'nullable|date',
                'date_fin' => 'nullable|date|after_or_equal:date_debut',
            ]);

            // Create a new roadmap
            $roadmap = Roadmap::create([
                'etat' => $request->input('etat'),
                'id_dec' => $request->input('id_dec'),
                'id_cit' => $request->input('id_cit'),
                'date_debut' => $request->input('date_debut'),
                'date_fin' => $request->input('date_fin'),
            ]);

            // Attach steps to the roadmap
            $roadmap->steps()->attach($request->input('steps'));

            return response()->json(['message' => 'Roadmap created successfully'], 201);
    }
}
