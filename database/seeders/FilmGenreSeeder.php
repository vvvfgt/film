<?php

namespace Database\Seeders;

use App\Models\Film;
use App\Models\Genre;
use Illuminate\Database\Seeder;

class FilmGenreSeeder extends Seeder
{
    public function run(): void
    {
        $films = Film::all();
        $genres = Genre::all();

        foreach ($films as $film) {
            $film->genres()->attach(
                $genres->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}
