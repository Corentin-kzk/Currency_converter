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
        ['name' => 'United States Dollar', 'code' => 'USD'],
        ['name' => 'British Pound Sterling', 'code' => 'GBP'],
        ['name' => 'Japanese Yen', 'code' => 'JPY'],
        ['name' => 'Canadian Dollar', 'code' => 'CAD'],
        ['name' => 'Swiss Franc', 'code' => 'CHF'],
        ['name' => 'Australian Dollar', 'code' => 'AUD'],
        ['name' => 'Chinese Yuan', 'code' => 'CNY'],
        ['name' => 'Mexican Peso', 'code' => 'MXN'],
        ['name' => 'Indian Rupee', 'code' => 'INR'],
        ['name' => 'New Zealand Dollar', 'code' => 'NZD'],
        ['name' => 'South Korean Won', 'code' => 'KRW'],
        ['name' => 'Singapore Dollar', 'code' => 'SGD']
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
