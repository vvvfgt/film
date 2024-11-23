<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\FilmChangeStatus;
use App\Http\Requests\StoreGenreRequest;
use App\Http\Requests\UpdateGenreRequest;
use App\Http\Resources\GenreResource;
use App\Models\Genre;
use App\Service\GenreService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GenreController extends Controller
{
    public function __construct(
        private readonly GenreService $genreService
    ) {}

    public function index(): JsonResponse
    {
        return response()
            ->json(
                GenreResource::collection(Genre::all()),
                Response::HTTP_OK
            );
    }

    public function store(StoreGenreRequest $request): JsonResponse
    {
        $data = $request->validated();

        return response()
            ->json(
                $this->store($data),
                Response::HTTP_OK
            );
    }

    public function show(int $id): JsonResponse
    {
        $genre = $this->genreService->find($id);

        return response()
            ->json(
                GenreResource::make($genre),
                Response::HTTP_OK
            );
    }

    /**
     * @throws FilmChangeStatus
     */
    public function update(UpdateGenreRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();

        $this->genreService->update($data, $id);

        return response()
            ->json([], Response::HTTP_OK);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->genreService->destroy($id);

        return response()
            ->json([], Response::HTTP_OK);
    }
}
