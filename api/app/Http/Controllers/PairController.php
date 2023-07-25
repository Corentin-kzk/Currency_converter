<?php

namespace App\Http\Controllers;

use App\Models\Pair;
use App\Http\Requests\StorePairsRequest;
use App\Http\Requests\UpdatePairsRequest;
use App\Models\Currency;
use Illuminate\Http\Request;

class PairController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $pairs = Pair::with('currencyFrom', 'currencyTo')->get();

            // // Remplacer les identifiants par les codes de devise dans chaque paire
            $pairs->transform(function ($pair) {
                return [
                    'id' => $pair->id,
                    'from' => $pair->currencyFrom->code,
                    'from_name' => $pair->currencyFrom->name,
                    'to' => $pair->currencyTo->code,
                    'to_name' => $pair->currencyTo->name,
                    'conversion_rate' => $pair->conversion_rate,
                    'count' => $pair->count,
                ];
            });

            return response()->json(['pairs' => $pairs], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), $th->getCode());
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePairsRequest $request)
    {
        // Valider les données envoyées depuis le front-end
        $validatedData = $request->validate([
            'from' => 'required|string',
            'to' => 'required|string|different:from',
            'conversion_rate' => 'required|string'
        ]);

        // Récupérer les devises correspondant aux valeurs "from" et "to"
        $fromCurrency = Currency::where('name', $validatedData['from'])->first();
        $toCurrency = Currency::where('name', $validatedData['to'])->first();

        // Vérifier si les devises existent en base de données
        if (!$fromCurrency || !$toCurrency) {

            return response()->json(['message' => 'currency not found'], 404);
        }

        // Vérifier si la paire existe en base de données
        $pairAlreadyExist = Pair::where('to_currency_id', $toCurrency->id)->where('from_currency_id', $fromCurrency->id)->first();
        if ($pairAlreadyExist) {
            return response()->json(['message' => 'This pair already exist'], 302);
        }

        Pair::create(['to_currency_id' => $toCurrency->id, 'from_currency_id' =>  $fromCurrency->id, 'conversion_rate' =>  $validatedData['conversion_rate']]);

        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pair $Pair)
    {
        $pair = Pair::with('currencyFrom', 'currencyTo')->where('id', $Pair->id)->get();

        // // Remplacer les identifiants par les codes de devise dans chaque paire
        $pair->transform(function ($pair) {
            return [
                'id' => $pair->id,
                'from' => $pair->currencyFrom->code,
                'to' => $pair->currencyTo->code,
                'conversion_rate' => $pair->conversion_rate,
            ];
        });
        return response()->json($pair[0], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePairsRequest $request, Pair $Pair)
    {
        $Pair->conversion_rate = $request->input('conversion_rate');
        $Pair->save();
        return response('success', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pair $Pair)
    {
        $Pair->delete();
        return response()->json(['message' => 'Success'], 200);
    }

    public function publicIndex()
    {
        try {
            $pairs = Pair::with('currencyFrom', 'currencyTo')->get();

            // // Remplacer les identifiants par les codes de devise dans chaque paire
            $pairs->transform(function ($pair) {
                return [
                    'id' => $pair->id,
                    'from' => $pair->currencyFrom->code,
                    'to' => $pair->currencyTo->code,
                    'conversion_rate' => $pair->conversion_rate,
                ];
            });

            return response()->json(['pairs' => $pairs], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), $th->getCode());
        }
    }

    /**
     * get conversion with pair
     */

    public function getConvertedDataFromPair(Request $request)
    {
        try {
            $request->validate([
                'from' => 'required|exists:currencies,code',
                'to' => 'required|exists:currencies,code',
                'amount' => 'required|numeric'
            ]);
            // Récupérer les codes de devise "from", "to" et amount fournis dans le corps de la requête
            $fromCurrencyCode = $request->input('from');
            $toCurrencyCode = $request->input('to');
            $amoutToConvert = $request->input('amount');

            // Récupérer les identifiants des devises associées aux codes de devises "from" et "to"
            $fromCurrency = Currency::where('code', $fromCurrencyCode)->first();
            $toCurrency = Currency::where('code', $toCurrencyCode)->first();

            $conversionRatefromPair = Pair::select(['conversion_rate', 'id'])->where('from_currency_id', $fromCurrency->id)->where('to_currency_id', $toCurrency->id)->first();

            $convertedValue =  $conversionRatefromPair->conversion_rate * $amoutToConvert;
            //Ajoute +1 au field count a chaque appel de l'api
            $pair = Pair::where('id', $conversionRatefromPair->id)->firstOrFail();
            $pair->count += 1;
            $pair->update();

            return response()->json(
                ["converted_value" => $convertedValue],
                200
            );
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), $th->getCode());
        }
    }

    /**
     * get field count on pair
     */
    public function getCountByCurrenciesCode(Request $request)
    {
        // Valider les données reçues dans le corps de la requête
        try {
            $request->validate([
                'from' => 'required|exists:currencies,code',
                'to' => 'required|exists:currencies,code',
            ]);
            // Récupérer les codes de devise "from" et "to" fournis dans le corps de la requête
            $fromCurrencyCode = $request->input('from');
            $toCurrencyCode = $request->input('to');
            // Récupérer les identifiants des devises associées aux codes de devises "from" et "to"
            $fromCurrency = Currency::where('code', $fromCurrencyCode)->firstOrFail();
            $toCurrency = Currency::where('code', $toCurrencyCode)->firstOrFail();

            $pairFounded = Pair::select(['count'])->where('from_currency_id', $fromCurrency->id)->where('to_currency_id', $toCurrency->id)->firstOrFail();
            // Retourner la valeur de "count" sous forme de réponse JSON
            return response()->json(['count' => $pairFounded->count]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), $th->getCode());
        }
    }
}
