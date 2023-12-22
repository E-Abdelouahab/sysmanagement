<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AssistantSocial;
use App\Models\Medecin;
use App\Models\Psychologue;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AssistantSocialeController extends Controller
{
    public function addAssistantSociale(Request $request)
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
            'centre' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        } else {
            // Create a new user
            $user = User::create([
                'fullName' => $request->input('fullName'),
                'cin' => $request->input('cin'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'dateN' => $request->input('dateN'),
                'sexe' => $request->input('sexe'),
                'role' => 'assistant sociale',
            ]);

            // Create a new assistant social associated with the user
            $assistantSocial = AssistantSocial::create([
                'identifier' => $request->input('identifier'),
                'centre' => $request->input('centre'),
                'id_user' => $user->id,
            ]);

            return response()->json([
                'message' => 'Compte Assistant Social a été créés avec succès',
                'user' => $user,
                'assistant_social' => $assistantSocial,
            ], 201);
        }
    }


    public function updateAssistantSociale(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'fullName' => 'required|string',
            'cin' => 'required|string|unique:users,cin,'.$id,
            'phone' => 'required|string|unique:users,phone,'.$id,
            'email' => 'nullable|email|unique:users,email,'.$id,
            'dateN' => 'required|date',
            'sexe' => 'nullable|string',
            'identifier' => 'required|string',
            'centre' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        } else {
            $assistant = AssistantSocial::find($id);

            if (!$assistant) {
                return response()->json(['message' => 'Assistant Sociale not found'], 404);
            }

            $user = $assistant->user;

            // Update the user
            $user->update([
                'fullName' => $request->input('fullName'),
                'cin' => $request->input('cin'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'dateN' => $request->input('dateN'),
                'sexe' => $request->input('sexe'),
                'role' => 'assistant sociale',
            ]);

            // Update the assistant social
            $assistant->update([
                'identifier' => $request->input('identifier'),
                'centre' => $request->input('centre'),
            ]);

            return response()->json(
                ['message' => 'Assistant a été mis à jour avec Succès',
                 'data' => $assistant
                ], 200);
        }
    }


    public function deleteAssistantSociale($id)
    {
        $assistant = AssistantSocial::find($id);
        if (!$assistant) {
            return response()->json(['message' => 'Cet assistant n\'existe pas'], 404);
        }
        $user = $assistant->user;

        $assistant->delete();
        $user->delete();

        return response()->json(['message' => 'assistant a été supprimé avec Succès'], 200);
    }


    //Kayna get lte7t Choufha w khtar li rta7ity fiha
    public function getAllEmployees()
    {
        $medecins = Medecin::with('user')->get();
        $psychologues = Psychologue::with('user')->get();
        $assistants = AssistantSocial::with('user')->get();

        $employees = [
            'medecins' => $medecins,
            'psychologues' => $psychologues,
            'assistants' => $assistants,
        ];

        return response()->json(['employees' => $employees], 201);
    }



    // public function getAllEmployees()
    // {
    //     $employees = User::with(['psychologue', 'assistantSocial', 'medecin'])
    //         ->whereIn('role', ['medecin', 'psy', 'assistant sociale'])
    //         ->get();

    //     return response()->json(['employees' => $employees]);
    // }

}
