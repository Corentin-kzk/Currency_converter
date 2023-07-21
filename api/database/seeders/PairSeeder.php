<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Pair;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PairSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = Currency::all();

        foreach ($currencies as $currency1) {
            foreach ($currencies as $currency2) {
                if ($currency1->id !== $currency2->id) {
                    Pair::create([
                        'from_currency_id'=> $currency1->id,
                        'to_currency_id'=> $currency2->id,
                         'conversion_rate' => rand(0, 10) / 10
                    ]);
                }
            }
        }
    }
}
