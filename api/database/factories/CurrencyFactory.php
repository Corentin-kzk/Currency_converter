<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\currency>
 */
class CurrencyFactory extends Factory
{

    protected $model =  Currency::class;

    // Liste de devises monétaires et leurs codes
   
    protected $currencies = [
        ['name'=> 'Euro', 'code'=> 'EUR'],
        ['name'=> 'Dollar américain', 'code'=> 'USD'],
        ['name'=> 'Livre sterling', 'code'=> 'GBP'],
        ['name'=> 'Yen japonais', 'code'=> 'JPY'],
        ['name'=> 'Dollar canadien', 'code'=> 'CAD'],
        ['name'=> 'Franc suisse', 'code'=> 'CHF'],
        ['name'=> 'Dollar australien', 'code'=> 'AUD'],
        ['name'=> 'Yuan chinois', 'code'=> 'CNY'],
        ['name'=> 'Peso mexicain', 'code'=> 'MXN'],
        ['name'=> 'Roupie indienne', 'code'=> 'INR'],
        ['name'=> 'Dollar néo-zélandais', 'code'=> 'NZD'],
        ['name'=> 'Won sud-coréen', 'code'=> 'KRW'],
        ['name'=> 'Dollar singapourien', 'code'=> 'SGD']
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $currency = $this->faker->unique()->randomElement($this->currencies);

        return [
            'code' => $currency['code'],
            'name' => $currency['name'],
        ];
    }
}
