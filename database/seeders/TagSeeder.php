<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tags;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'programming',
            'AI',
            'gaming',
            'musik',
            'film',
            'random',
            'berita',
            'edukasi',
            'lifestyle'
        ];

        foreach ($tags as $tag) {
            Tags::create([
                'name' => $tag,
            ]);
        };
    }
}
