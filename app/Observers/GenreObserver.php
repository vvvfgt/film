<?php

namespace App\Observers;

use App\Models\Genre;

class GenreObserver
{
    public function deleting(Genre $genre): void
    {
        $genre->films()->detach();
    }
}
