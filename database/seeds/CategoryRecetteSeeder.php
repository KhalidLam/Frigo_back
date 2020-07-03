<?php

use App\Categoryrecette;
use Illuminate\Database\Seeder;

class CategoryRecetteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categoryrecette ::create([

            'name' => 'Le Salé', 
        ]);
        Categoryrecette ::create([
            'name' => ' Le Sucré ',
        ]);
        Categoryrecette ::create([
            'name' => ' Les pains ',
        ]);
        Categoryrecette ::create([
            'name' => ' Les  régimes spéciaux ',
        ]);

    }
}
