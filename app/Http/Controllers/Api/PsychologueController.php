<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Psychologue;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PsychologueController extends Controller
{
    public function AddPsy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullName' => 'required|string',
            'cin' => 'required|string|unique:users',
            'phone' => 'required|string|unique:users',
            'email' => 'nullable|email|unique:users',
            'password' => 'required|string|min:6',
            'dateN' => 'required|date',
            'sexe' => 'nullable|string',
            'identifier' => 'required|string',
            'centre' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }else{

            $user = User::create([
                'fullName' => $request->input('fullName'),
                'cin' => $request->input('cin'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'dateN' => $request->input('dateN'),
                'sexe' => $request->input('sexe'),
                'role' => 'psy',
            ]);
            $psychologue = Psychologue::create([
                'identifier' => $request->input('identifier'),
                'centre' => $request->input('centre'),
                'id_user' => $user->id,
            ]);
            return response()->json(
                ['message' => 'Psychologue a été créeé avec Succées',
                 'data' => $psychologue
                ], 200);
        }
    }

    public function updatePsy(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'fullName' => 'required|string',
            'cin' => 'required|string',
            'phone' => 'required|string',
            'email' => 'nullable|email',
            'dateN' => 'required|date',
            'sexe' => 'nullable|string',
            'identifier' => 'required|string',
            'centre' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        } else {
            $psychologue = Psychologue::find($id);

            if (!$psychologue) {
                return response()->json(['message' => 'Psychologue not found'], 404);
            }

            $user = $psychologue->user;
            $user->update([
                'fullName' => $request->input('fullName'),
                'cin' => $request->input('cin'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'dateN' => $request->input('dateN'),
                'sexe' => $request->input('sexe'),
                'role' => 'psy',
            ]);

            // Update the psychologue
            $psychologue->update([
                'identifier' => $request->input('identifier'),
                'centre' => $request->input('centre'),
            ]);

            return response()->json(
                ['message' => 'Psychologue a été mis à jour avec Succès',
                 'data' => $psychologue
                ], 200);
        }
    }

    public function deletePsy($id)
    {
        $psychologue = Psychologue::find($id);
        if (!$psychologue) {
            return response()->json(['message' => 'Ce Psychologue n\'existe pas'], 404);
        }
        $user = $psychologue->user;

        $psychologue->delete();
        $user->delete();

        return response()->json(['message' => 'Psychologue a été supprimé avec Succès'], 200);
    }

}
