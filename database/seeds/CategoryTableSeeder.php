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
    { 
        
        Category ::create([

        // 'name' => 'Fruit and vegetables',
        'name' => 'Fruit et légumes',
      
    ]);
    Category::create([
        // 'name' => 'Dairy products',
        'name' => 'Produit laitier',
    ]);

    Category::create([
        // 'name' => 'Spices/Herbs',
        'name' => 'Epices/Herbes',

    ]);

    Category::create([
        'name' => 'Boisson',
    ]);

    Category::create([
        // 'name' => 'Meat/Poultry/Fish/Eggs',
        'name' => 'Viande/Poisson/Oeuf',

    ]);

    Category::create([
        // 'name' => 'Breads and cereals',
        'name' => 'Céréale et féculent ',
    ]);

    Category::create([
        'name' => 'Sucre',
    ]);
    Category::create([
        'name' => 'Matière grasse',
    ]);
    
    }
}
