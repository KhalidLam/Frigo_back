<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {  Category ::create([

        'name' => 'Fruit and vegetables',
      
    ]);
    Category::create([
        'name' => 'Dairy products',
    ]);

    Category::create([
        'name' => 'Spices/Herbs',
    ]);

    Category::create([
        'name' => 'Drinks',
    ]);

    Category::create([
        'name' => 'Meat/Poultry/Fish/Eggs',
    ]);

    Category::create([
        'name' => 'Breads and cereals',
    ]);

    Category::create([
        'name' => 'Sugar',
    ]);
    Category::create([
        'name' => 'Oils',
    ]);
    
    }
}
