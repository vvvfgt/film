<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Film;
use Illuminate\Support\Facades\Storage;

class FilmObserver
{
    public function deleting(Film $film): void
    {
        $film->genres()->detach();
        if ($film->poster && $film->postr != 'poster/default/default.jpg') {
            if (Storage::disk('public')->exists($film->poster)) {
                Storage::disk('public')->delete($film->poster);
            }
        }
    }
}
