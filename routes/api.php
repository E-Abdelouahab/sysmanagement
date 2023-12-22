<?php

use App\Http\Controllers\Api\AssistantSocialeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CalendarController;
use App\Http\Controllers\Api\DecalarationController;
use App\Http\Controllers\Api\MedecinController;
use App\Http\Controllers\Api\PsychologueController;
use App\Http\Controllers\Api\RoadmapController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('event/assist/add', [CalendarController::class, 'addAssistantSocialeEvent']);
    Route::get('AssisEvent', [CalendarController::class, 'getRendezVAssist']);
});
//For all users :

// Authentications
Route::post('user/craete', [AuthController::class, 'create']);
Route::post('login', [AuthController::class, 'login']);

//Declarations
Route::post('user/search', [DecalarationController::class, 'userExiste']);
Route::post('declarationFemme/create/{userCin}', [DecalarationController::class, 'addDeclarationFemme']);
Route::post('declarationEnf/create/{userCin}', [DecalarationController::class, 'addDeclarationEnfant']);
Route::post('infoForm/update/{declarationId}', [DecalarationController::class, 'updateInfoForm']);
Route::get('allDeclarations', [DecalarationController::class, 'getAllDeclaration']);

//Rendez-vous
Route::post('event/medecin/add', [CalendarController::class, 'addMedecinEvent']);
Route::post('event/psy/add', [CalendarController::class, 'addPsyEvent']);
Route::get('MedecinEvent', [CalendarController::class, 'getRendezVMedecin']);
Route::get('PsyEvent', [CalendarController::class, 'getRendezVPsy']);
Route::delete('/rendez-vous/{eventId}',[CalendarController::class, 'deleteRendezV']);
Route::post('/rendez-vous/update/{eventId}',[CalendarController::class, 'updateRendezV']);

//Add users and Employee
Route::post('/medecins/create', [MedecinController::class, 'AddMedecin']);
Route::post('/medecins/update/{id}', [MedecinController::class, 'updateMedecin']);
Route::delete('/medecins/delete/{id}', [MedecinController::class, 'deleteMedecin']);

Route::post('/psy/create', [PsychologueController::class, 'AddPsy']);
Route::post('/psy/update/{id}', [PsychologueController::class, 'updatePsy']);
Route::delete('/psy/delete/{id}', [PsychologueController::class, 'deletePsy']);

Route::post('/assistant/create', [AssistantSocialeController::class, 'addAssistantSociale']);
Route::post('/assistant/update/{id}', [AssistantSocialeController::class, 'updateAssistantSociale']);
Route::delete('/assistant/delete/{id}', [AssistantSocialeController::class, 'deleteAssistantSociale']);
Route::get('/AllEmployees', [AssistantSocialeController::class, 'getAllEmployees']);

Route::post('/roadmap/create', [RoadmapController::class, 'createRoadmap']);
Route::get('/declarations/{declarationId}/steps', [DecalarationController::class, 'getStepsForDeclaration']);


Route::get('/notification/medecin', [DecalarationController::class,'getNotificationMedecin']);
Route::get('/notification/psy', [DecalarationController::class,'getNotificationPsy']);
