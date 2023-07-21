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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePairsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pair $Pair)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pair $Pair)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePairsRequest $request, Pair $Pair)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pair $Pair)
    {
        //
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
