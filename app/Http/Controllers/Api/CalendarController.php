<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\calendrier;
use App\Models\Medecin;
use App\Models\Psychologue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CalendarController extends Controller
{
    public function addAssistantSocialeEvent(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
            'victimeName' => 'required|string',
            'role' =>'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors(),
            ], 422);
        }else{
            $event = new calendrier([
                'victimeName' => $request->victimeName,
                'id_user' => auth()->user()->id,
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin,
                'role' => $request->role,

            ]);
    
            $event->save();
    
            return response()->json([
                'status'=> 201,
                'message' => 'Event added successfully'
            ],201);
        }

       
    }

    public function addMedecinEvent(Request $request)
    {
        $medecin=Medecin::where('id',1)->first();

        $validator =  Validator::make($request->all(), [
            'date_debut' => 'required',
            'date_fin' => 'required',
            'victimeName' => 'required|string',
            'role' =>'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors(),
            ], 422);
        }else{
            $event = new calendrier([
                'victimeName' => $request->victimeName,
                'id_user' => $medecin->id,
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin,
                'role' => $request->role,

            ]);
    
            $event->save();
    
            return response()->json([
                'status'=> 201,
                'message' => 'Event added successfully'
            ],201);
        }

        
    }

    public function addPsyEvent(Request $request)
    {
        $psy=Psychologue::where('id',1)->first();

        $validator =  Validator::make($request->all(), [
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
            'victimeName' => 'required|string',
            'role' =>'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors(),
            ], 422);
        }else{
            $event = new calendrier([
                'victimeName' => $request->victimeName,
                'id_user' => $psy->id,
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin,
                'role' => $request->role,

            ]);
            
            $event->save();
            return response()->json([
                'status'=> 201,
                'message' => 'Event added successfully'
            ],201);
        }

    }

    public function getRendezVAssist()
    {
        $events = calendrier::where('id_user', auth()->user()->id)->where('role', 'ass')->get();

        return response()->json([
            'status' => 200,
            'data' => $events,
        ]);
    }

    public function getRendezVMedecin()
    {
        $medecin = Medecin::where('id', 1)->first();
        $events = calendrier::where('id_user', $medecin->id)->where('role', 'medecin')->get();

        return response()->json([
            'status' => 200,
            'data' => $events,
        ]);
    }

    public function getRendezVPsy()
    {
        $psy = Psychologue::where('id', 1)->first();
        $events = calendrier::where('id_user', $psy->id)->where('role', 'psy')->get();

        return response()->json([
            'status' => 200,
            'data' => $events,
        ]);
    }


    public function deleteRendezV($eventId)
    {
        $event = calendrier::find($eventId);

        if (!$event) {
            return response()->json([
                'status' => 404,
                'message' => 'Event not found',
            ], 404);
        }

        $event->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Event deleted successfully',
        ]);
    }


    public function updateRendezV(Request $request, $eventId)
    {
        $event = calendrier::find($eventId);

        if (!$event) {
            return response()->json([
                'status' => 404,
                'message' => 'Event not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'victimeName' => 'required|string',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors(),
            ], 422);
        }

        $event->update([
            'victimeName' => $request->victimeName,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Rendez vous modifié avec Succée',
            'data' => $event,
        ]);
    }



    
}
