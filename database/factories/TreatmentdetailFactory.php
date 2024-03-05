<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Treatment;
use App\Models\Treatmentdetail;
use App\Models\User;

class TreatmentdetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Treatmentdetail::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'patient_id' => User::factory(),
            'dentist_id' => User::factory(),
            'treatment_id' => Treatment::factory(),
        ];
    }
}
