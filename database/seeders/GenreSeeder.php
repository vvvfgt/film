<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            'Comedy',
            'Thriller',
            'Action',
            'Adventures',
            'History',
            'Fantasy',
        ];

        $genresForSequence = collect($genres)
            ->map(fn ($item) => ['name' => $item]);

        Genre::factory(count($genres))
            ->sequence(...$genresForSequence)
            ->create();
    }
}
