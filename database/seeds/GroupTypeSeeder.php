<?php

use App\GroupType;
use Illuminate\Database\Seeder;

class GroupTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        GroupType::truncate();

        $types = [
            'music' => 'Music Group',
            'dance' => 'Dance Group',
            'comedy' => 'Comedy Group'
        ];

        foreach($types as $name => $label){
            GroupType::create([
                'name' => $name,
                'label' => $label
            ]);
        }
    }
}
