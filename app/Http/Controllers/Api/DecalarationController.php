<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Citoyen;
use App\Models\Declaration;
use App\Models\infoAgresseur;
use App\Models\InfoForm;
use App\Models\Medecin;
use App\Models\Psychologue;
use App\Models\User;
use App\Notifications\DeclarationNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DecalarationController extends Controller
{
    public function userExiste(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cin' => 'required',
            'dateN' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check if user exists by cin and dateN
        $user = User::where('cin', $request->cin)->where('dateN', $request->dateN)->first();

        if ($user) {
            // User exists, return a message to login
            return response()->json(['message' => 'User already exists. Please login to continue.'], 200);
        } else {
            $newUser = User::create([
                'fullName' => $request->fullName,
                'cin' => $request->cin,
                'phone' => $request->phone,
                'email' => $request->email,
                'dateN' => $request->dateN,
                'sexe' => $request->sexe,
                'role' => 'citoyen',
                'password' => Hash::make($request->password),
            ]);
            $citoyen = Citoyen::create([
                'id_user' => $newUser->id,
                'uuid' => 'Bouk' . now()->format('Ymd'),
            ]);
            return response()->json([
                'message' => 'Votre profile a bien été envoyé',
                'user' => $newUser,
            ], 201);
        }
    }

    public function addDeclarationFemme(Request $request, $userCin)
    {
        $user = User::where('cin', $userCin)->first();
        $citoyen = Citoyen::where('id_user', $user->id)->first();
        // dd($user);
        if (!$user) {
            return response()->json(['message' => 'Utilisateur introuvable.'], 404);
        }

        $declaration = Declaration::create([
            'heur_v' => $request->heur_v,
            'date_v' => $request->date_v,
            'lieu_v' => $request->lieu_v,
            'id_cit' => $citoyen->id,
            'comment' => $request->comment,
        ]);

        $infoForm = InfoForm::create([
            'id_dec' => $declaration->id,
            'id_cit' => $citoyen->id,
            'fulNamevic' => $user->fullName,
            'dateReclam' => Carbon::now(),
        ]);

        // $infoAgresseurs = [];

        // foreach ($request->agresseurs as $agresseurData) {
        //     $infoAgresseur = InfoAgresseur::create([
        //         'id_dec' => $declaration->id,
        //         'fullNameAg' => $agresseurData['fullNameAg'],
        //         'sexeAg' => $agresseurData['sexeAg'],
        //         'nationnaliteAg' => $agresseurData['nationnaliteAg'],
        //         'ageAg' => $agresseurData['ageAg'],
        //         'professionAg' => $agresseurData['professionAg'],
        //         'niveauScolaireAg' => $agresseurData['niveauScolaireAg'],
        //         'situationFamilialeAg' => $agresseurData['situationFamilialeAg'],
        //         'carractAg' => $agresseurData['carractAg'],
        //     ]);

        //     $infoAgresseurs[] = $infoAgresseur;
        // }

        return response()->json([
            'message' => 'Votre déclaration a bien été envoyée',
            'user' => $user,
            'declaration' => $declaration,
            'infoForm' => $infoForm,
            // 'infoAgresseurs' => $infoAgresseurs,
        ], 201);
    }


    public function addDeclarationEnfant(Request $request, $userCin)
    {
        $validator = Validator::make($request->all(), [
            'fulNamevic' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $tuteur = User::where('cin', $userCin)->first();
        $citoyen = Citoyen::where('id_user', $tuteur->id)->first();

        // dd($tuteur);
        if (!$tuteur) {
            return response()->json([
                'message' => 'Utilisateur introuvable.'
            ]);
        }

        $declaration = Declaration::create([
            'heur_v' => $request->heur_v,
            'date_v' => $request->date_v,
            'lieu_v' => $request->lieu_v,
            'id_cit' => $citoyen->id,
            'comment' => $request->comment,
        ]);

        $infoForm = InfoForm::create([
            'id_dec' => $declaration->id,
            'id_cit' => $citoyen->id,
            'fulNamevic' => $request->fulNamevic,
            'dateReclam' => Carbon::now(),
        ]);

        // $infoAgresseurs = [];

        // foreach ($request->agresseurs as $agresseurData) {
        //     $infoAgresseur = InfoAgresseur::create([
        //         'id_dec' => $declaration->id,
        //         'fullNameAg' => $agresseurData['fullNameAg'],
        //         'sexeAg' => $agresseurData['sexeAg'],
        //         'nationnaliteAg' => $agresseurData['nationnaliteAg'],
        //         'ageAg' => $agresseurData['ageAg'],
        //         'professionAg' => $agresseurData['professionAg'],
        //         'niveauScolaireAg' => $agresseurData['niveauScolaireAg'],
        //         'situationFamilialeAg' => $agresseurData['situationFamilialeAg'],
        //         'carractAg' => $agresseurData['carractAg'],
        //     ]);

        //     $infoAgresseurs[] = $infoAgresseur;
        // }

        return response()->json([
            'message' => 'Votre déclaration a bien été envoyée',
            'tuteur' => $tuteur,
            'declaration' => $declaration,
            'infoForm' => $infoForm,
            // 'infoAgresseurs' => $infoAgresseurs,
        ], 201);
    }


    public function updateInfoForm(Request $request, $declarationId)
    {
        $declaration = Declaration::find($declarationId);
        $infoForm = InfoForm::find($declarationId);

        if (!$declaration || !$infoForm) {
            return response()->json([
                'status' => 404,
                'message' => 'Le formulaire de votre déclaration n\'a pas été trouvé',
            ], 404);
        }

        if ($declaration) {
            $declaration->update([
                'heur_v' => $request->heur_v,
                'date_v' => $request->date_v,
                'lieu_v' => $request->lieu_v,
                // 'id_cit' => $request->id_cit,
                'comment' => $request->comment,
            ]);
        }
        if ($infoForm) {
            $infoForm->update([
                // 'id_dec' => $request->id_dec,
                // 'id_cit' => $request->id_cit,
                // 'dateReclam' => $request->dateReclam,
                'fulNamevic' => $request->fulNamevic,
                'dateN' => $request->dateN,
                'lieuN' => $request->lieuN,
                'cin' => $request->cin,
                'adress' => $request->adress,
                'age' => $request->age,
                'nationnalite' => $request->nationnalite,
                'dejaSignale' => $request->dejaSignale,
                'lieuSignal' => $request->lieuSignal,
                'dateSingnal' => $request->dateSingnal,
                'ville' => $request->ville,
                'NbrAgre' => $request->NbrAgre,
                'RaisonVisit' => $request->RaisonVisit,
                'milieuResid' => $request->milieuResid,
                'handicap' => $request->handicap,
                'addiction' => $request->addiction,
                'niveauScolaire' => $request->niveauScolaire,
                'professionE' => $request->professionE,
                'stituationParent' => $request->stituationParent,
                'professionMere' => $request->professionMere,
                'prefessionPere' => $request->prefessionPere,
                'parrain' => $request->parrain,
                'niveauScolaireParrain' => $request->niveauScolaireParrain,
                'addictionParrain' => $request->addictionParrain,
                'teleParrain' => $request->teleParrain,
                'dureeMariage' => $request->dureeMariage,
                'situationFamiliale' => $request->situationFamiliale,
                'nbrEnf' => $request->nbrEnf,
                'enceint' => $request->enceint,
                'professionF' => $request->professionF,
                'vPhysique' => $request->vPhysique,
                'vPsychique' => $request->vPsychique,
                'cPhysique' => $request->cPhysique,
                'cSexuelle' => $request->cSexuelle,
                'egligence' => $request->egligence,
                'abondonnement' => $request->abondonnement,
                'traiteHumain' => $request->traiteHumain,
                'frequenceV' => $request->frequenceV,
                'typeRelation' => $request->typeRelation,
                'serviceProd' => $request->serviceProd,
                'delivCertif' => $request->delivCertif,
                'soins' => $request->soins,
                'orientationEtab' => $request->orientationEtab,
                'orientationHospitalier' => $request->orientationHospitalier,
                'certificat' => $request->certificat,
            ]);


        $infoAgresseurs = [];

        foreach ($request->agresseurs as $agresseurData) {
            $infoAgresseur = InfoAgresseur::create([
                'id_dec' => $declaration->id,
                'fullNameAg' => $agresseurData['fullNameAg'],
                'sexeAg' => $agresseurData['sexeAg'],
                'nationnaliteAg' => $agresseurData['nationnaliteAg'],
                'ageAg' => $agresseurData['ageAg'],
                'professionAg' => $agresseurData['professionAg'],
                'niveauScolaireAg' => $agresseurData['niveauScolaireAg'],
                'situationFamilialeAg' => $agresseurData['situationFamilialeAg'],
                'carractAg' => $agresseurData['carractAg'],
            ]);

            $infoAgresseurs[] = $infoAgresseur;
        }
        // $notifymed=Medecin::find($request->id_med);
        // $notifymed->notify(new DeclarationNotification(
        //     $declaration,
        //     $request->id_med,
        //     $request->notification_message
        // ));
            return response()->json([
                'status' => 200,
                'message' => 'Le formulaire de votre déclaration a bien été Modifier',
                'declaration' => $declaration,
                'infoForm' => $infoForm,
                'infoAgresseurs' => $infoAgresseurs,

            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Le formulaire de votre déclaration n\'a pas été trouvé',
            ]);
        }
    }

    public function sendNotification(Request $request,$declarationId,$role)
    {
        $declaration = Declaration::find($declarationId);
        if($role=="medecin")
        {
            $notif=Medecin::find($request->id_notif);
        }else if($role=="psy")
        {
            $notif=Psychologue::find($request->id_notif);
        }
        $notif->notify(new DeclarationNotification(
            $declaration,
            $request->id_notif,
            $request->notification_message
        ));
    }

    public function getNotificationMedecin()
    {
        $medecin = Medecin::find(1);

        if ($medecin) {
            $notifications = $medecin->notifications()->latest()->get();

            $content = $notifications->map(function ($notification) {
                return $notification->data;
            });
        } else {
            $content = 'medecin not found.';
        }

        return response()->json([
            'content' => $content,
        ]);
    }


    public function getNotificationPsy()
    {
        $psy = Psychologue::find(1);

        if ($psy) {
            $notifications = $psy->notifications()->latest()->get();

            $content = $notifications->map(function ($notification) {
                return $notification->data[[
                    'id_dec','id_med','message'
                ]];
            });
        } else {
            $content = 'psy not found.';
        }

        return response()->json([
            'status' => 'success',
            'content' => $content,
        ]);
    }


    public function getAllDeclaration()
    {
        $declarations = Declaration::with('infoForm', 'agresseurs')->get();

        return response()->json([
            'declarations' => $declarations,
        ], 200);
    }

    public function getStepsForDeclaration(Request $request, $declarationId)
    {
        $declaration = Declaration::with(['roadmaps.steps'])->find($declarationId);

        if (!$declaration) {
            return response()->json(['message' => 'Declaration not found'], 404);
        }
        return response()->json(['declaration' => $declaration]);
    }
}
