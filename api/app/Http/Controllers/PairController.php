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
                    'to' => $pair->currencyTo->code,
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
        return response('success', 200);
        // Vérifier si la devise 'from' existe
        $fromCurrency = Currency::where('code', $request->input('from'))->first();
        if (!$fromCurrency) {
            // Si la devise 'from' n'existe pas, la créer
            $fromCurrency = Currency::create(['code' => $request->input('from')]);
        }

        // Vérifier si la devise 'to' existe
        $toCurrency = Currency::where('code', $request->input('to'))->first();
        if (!$toCurrency) {
            // Si la devise 'to' n'existe pas, la créer
            $toCurrency = Currency::create(['code' => $request->input('to')]);
        }

        // Vérifier si la paire existe
        $pair = Pair::where('from_currency_id', $fromCurrency->id)
            ->where('to_currency_id', $toCurrency->id)
            ->first();

        if (!$pair) {
            // Si la paire n'existe pas, la créer
            $pair = Pair::create([
                'from_currency_id' => $fromCurrency->id,
                'to_currency_id' => $toCurrency->id,
                'conversion_rate' =>  $request->input('conversion_rate'),
            ]);
            return response()->json(['message' => 'New pair successfully added.']);
        } else {
            // Si la paire existe, mettre à jour la conversion
            return response()->json('Error: this pair already exist',304);
        }
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
        //
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
            $fromCurrency = Currency::where('code', $fromCurrencyCode)->firstOrFail();
            $toCurrency = Currency::where('code', $toCurrencyCode)->firstOrFail();

            $conversionRatefromPair = Pair::select(['conversion_rate', 'id'])->where('from_currency_id', $fromCurrency->id)->where('to_currency_id', $toCurrency->id)->firstOrFail();

            $convertedValue =  $conversionRatefromPair->conversion_rate * $amoutToConvert;
            //Ajoute +1 au field count a chaque appel de l'api
            $pair = Pair::where('id', $conversionRatefromPair->id)->firstOrFail();
            $pair->count += 1;
            $pair->update();

            return response()->json([
                ["converted_value" => $convertedValue], 200
            ]);
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
