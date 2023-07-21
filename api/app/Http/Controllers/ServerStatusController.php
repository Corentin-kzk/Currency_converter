<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Pair;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ServerStatusController extends Controller
{
    public function serverStatus(Request $request)
    {
        try {
            // Effectuer une requête HTTP GET à l'URL du serveur Laravel
            $ServerResponse = Http::get(env('APP_URL'));
    
            // Vérifier le code de statut HTTP pour déterminer le statut du serveur
            if ($ServerResponse->ok()) {
                return response()->json("The Laravel server is online and functioning correctly.", 200);
            } else {
                return response()->json("The Laravel server returned an HTTP status code: " . $ServerResponse->status(), 500);
            }
        } catch (\Exception $e) {
            return response()->json("An error occurred while attempting to connect to the Laravel server: " . $e->getMessage(), $e->getCode());
        }
        // return $json = json_encode(['status' => '200','health' => 'server is running']);
    }
}
