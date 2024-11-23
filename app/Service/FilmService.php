<?php

declare(strict_types=1);

namespace App\Service;

use App\Exceptions\FilmChangeStatus;
use App\Http\Requests\StoreFilmRequest;
use App\Http\Requests\UpdateFilmRequest;
use App\Models\Film;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class FilmService
{
    /**
     * @throws FilmChangeStatus
     */
    public function setPublishStatus(array $data): void
    {
        /** @var Film $film */
        $film = Film::query()->findOrFail($data['id']);

        $status = $data['status'] ?? true;

       try {
           $film->update([
               'published' => $status,
           ]);
       } catch (\Exception $e) {
           Log::error($e->getMessage());
           throw new FilmChangeStatus('Shame', Response::HTTP_INTERNAL_SERVER_ERROR);
       }
    }

    public function genreFilms(int $id): LengthAwarePaginator
    {
        return Film::query()
            ->where('published', true)
            ->with('genres')
            ->whereHas('genres', function (Builder $builder) use ($id) {
                $builder->where('id', $id);
            })
            ->paginate(5);
    }

    /**
     * @throws FilmChangeStatus
     */
    public function store(StoreFilmRequest $request): void
    {
        $data = $request->validated();
        if (!empty($data['genres'])) {
            $genres = $data['genres'];
            unset($data['genres']);
        }

        try {
            if ($request->hasFile('poster') && $request->file('poster')->isValid()) {
                $file = $request->file('poster');
                $fileName = $file->getClientOriginalName();
                $poster = Storage::disk('public')
                    ->putFileAs('poster', $file, $fileName);
                unset($data['poster']);
                $data[] = ['poster' => $poster];
            }

            $film = Film::query()->create($data);

            if (!empty($genres)) {
                $film->genres()->attach($genres);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new FilmChangeStatus('Shame', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function find(int $id): Film
    {
        return Film::query()
            ->where('published', true)
            ->with('genres')
            ->findOrFail($id);
    }

    /**
     * @throws FilmChangeStatus
     */
    public function update(UpdateFilmRequest $request): void
    {
        $data = $request->validated();

        $id = $request->route('id');

        /** @var Film $film */
        $film = Film::query()->findOrFail($id);

        if (!empty($data['genres'])) {
            $genres = $data['genres'];
            unset($data['genres']);
        }

        try {
            if ($request->hasFile('poster') && $request->file('poster')->isValid()) {
                $file = $request->file('poster');
                $fileName = $file->getClientOriginalName();

                if ($film->poster != 'poster/' . $fileName) {
                    if (Storage::disk('public')->exists($film->poster)) {
                        Storage::disk('public')->delete($film->poster);
                    }

                    $poster = Storage::disk('public')
                        ->putFileAs('poster', $file, $fileName);
                    unset($data['poster']);
                    $data[] = ['poster' => $poster];
                }

                $film->update($data);

                if (!empty($genres)) {
                    $film->genres()->sync($genres);
                } else {
                    $film->genres()->distinct();
                }
            }

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new FilmChangeStatus('Shame', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws FilmChangeStatus
     */
    public function destroy(int $id): void
    {
        $film = Film::query()->findOrFail($id);

        try {
            $film->delete();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new FilmChangeStatus('Shame', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
