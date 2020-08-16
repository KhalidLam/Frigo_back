<?php

use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $faker = \Faker\Factory::create();
        // $faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));

        // factory(App\Category::class, 8)->create()->each(function($u) {
        //     $u->question()
        //       ->saveMany(
        //           factory(App\Question::class, rand(1, 5))->make()
        //       )
        //       ->each(function ($q) {
        //         $q->answers()->saveMany(factory(App\Answer::class, rand(1, 5))->make());
        //       });
        // });
        // // $faker->promotionCode; // KillerPromotion257835
        // // $faker->department; // Kids & Games
        // // $faker->department(6); // Games, Industrial, Books & Automotive
        // // $faker->department(3, true); // Jewelry, Music & Shoes
        // $faker->productName; //
}
}