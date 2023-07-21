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
        ['name' => 'Euro', 'code' => 'EUR'],
        ['name' => 'Dollar américain', 'code' => 'USD'],
        ['name' => 'Livre sterling', 'code' => 'GBP'],
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
