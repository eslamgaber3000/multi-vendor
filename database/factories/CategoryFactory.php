<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Factory as FakerFactory;
use Bezhanov\Faker\Provider\Commerce;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
          // Create a Faker instance and add the Commerce provider
          $faker = FakerFactory::create();
          $faker->addProvider(new Commerce($faker));

        $name = $faker->department; // This will now work with the Commerce provider

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $faker->sentence(15),
            'image' => $faker->imageUrl(),
        ];
    }
}
