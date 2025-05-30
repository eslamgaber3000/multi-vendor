<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Store;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Factory as FakerFactory;
use Bezhanov\Faker\Provider\Commerce;




/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $faker = FakerFactory::create();
        $faker->addProvider(new Commerce($faker));
        $name=$faker->productName;
        return [
            'name'=>$name,
            'slug'=>Str::slug($name),
            'description'=>$this->faker->sentence(30),
            'image'=>$this->faker->imageUrl(600,600),
            'category_id'=>Category::inRandomOrder()->first()->id,
            'store_id'=>Store::inRandomOrder()->first()->id,
            'featured'=>rand(0,1),
            'price'=>$this->faker->randomFloat(1,1,499),
            'compare_price'=>$this->faker->randomFloat(1,500,999),
        ];                              
        }
}
