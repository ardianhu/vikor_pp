<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $tags = [
            'Postgres',
            'Neon',
            'Web Development',
            'Laravel',
            'PHP',
            'JavaScript',
            'Database',
            'Design',
            'UI/UX',
            'AI',
            'Machine Learning',
            'Cloud Computing',
            'DevOps',
            'Security',
        ];

        foreach ($tags as $tagname) {
            Tag::create(['name' => $tagname]);
        }
    }
}
