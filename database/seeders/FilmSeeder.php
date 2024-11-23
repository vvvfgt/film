<?php

namespace Database\Seeders;

use App\Models\Film;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FilmSeeder extends Seeder
{
    public function run(): void
    {
        $posters = Storage::disk('public')
            ->allFiles('poster');

        $posterForSequence = collect($posters)
            ->map(fn ($item) => ['poster' => $item]);

        Film::factory(count($posters))
            ->sequence(...$posterForSequence)
            ->create();
    }
}
