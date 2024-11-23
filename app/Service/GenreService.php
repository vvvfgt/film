<?php

namespace App\Service;

use App\Exceptions\FilmChangeStatus;
use App\Models\Genre;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class GenreService
{
    /**
     * @throws FilmChangeStatus
     */
    public function store(array $data): Genre
    {
        try {
            return Genre::query()
                ->create($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new FilmChangeStatus('Shame', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(int $id): void
    {
        $genre = Genre::query()->findOrFail($id);

        $genre->delete();
    }

    /**
     * @throws FilmChangeStatus
     */
    public function update(array $data, int $id): void
    {
        /** @var Genre $genre */
        $genre = Genre::query()->findOrFail($id);

        try {
            $genre->update($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new FilmChangeStatus('Shame', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function find(int $id): Genre
    {
        /** @var Genre $genre */
        $genre = Genre::query()->findOrFail($id);

        return $genre;
    }
}
