<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\FilmChangeStatus;
use App\Http\Requests\PublishStatusRequest;
use App\Http\Requests\StoreFilmRequest;
use App\Http\Requests\UpdateFilmRequest;
use App\Http\Resources\FilmResource;
use App\Models\Film;
use App\Service\FilmService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class FilmController extends Controller
{
    public function __construct(
        private readonly FilmService $filmService
    ) {}

    public function index(): JsonResponse
    {
        $films = Film::query()
            ->where('published', true)
            ->with('genres')
            ->paginate(5);

        return response()
            ->json(
                $films,
                Response::HTTP_OK
            );
    }

    /**
     * @throws FilmChangeStatus
     */
    public function store(StoreFilmRequest $request): JsonResponse
    {
        $this->filmService->store($request);
        return response()
            ->json([], Response::HTTP_OK);
    }

    public function show(int $id): JsonResponse
    {
        $film = $this->filmService->find($id);

        return response()
            ->json(FilmResource::make($film), Response::HTTP_OK);
    }

    public function update(UpdateFilmRequest $request, int $id): JsonResponse
    {
        $this->filmService->update($request, $id);

        return response()
            ->json([], Response::HTTP_OK);
    }

    /**
     * @throws FilmChangeStatus
     */
    public function destroy(int $id): JsonResponse
    {
        $this->filmService->destroy($id);

        return response()
            ->json([], Response::HTTP_OK);
    }

    /**
     * @throws FilmChangeStatus
     */
    public function setPublishStatus(PublishStatusRequest $request): JsonResponse
    {
        $data = $request->validated();

        $this->filmService->setPublishStatus($data);
        return response()
            ->json([], Response::HTTP_OK);
    }

    public function genreFilms(int $id): JsonResponse
    {
        $films = $this->filmService->genreFilms($id);

        return response()
            ->json($films, Response::HTTP_OK);
    }
}
