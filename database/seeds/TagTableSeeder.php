<?php

use App\Tag;
use Illuminate\Database\Seeder;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::truncate();

        $tags = [
            'Web Dev',
            'Software Engineering',
            'Health & Nutrition',
            'Music',
            'Dance',
            'Comedy'
        ];

        foreach($tags as $tag){
            Tag::create([
                'name' => $tag
            ]);
        }
    }
}
