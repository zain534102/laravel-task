<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Modules\Games\Game;
use App\Modules\Games\Requests\CreateGameRequest;
use App\Modules\Games\Requests\UpdateGameRequest;
use App\Modules\Games\Services\GameService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GameController extends Controller
{

    /**
     * @var array
     */
    private array $includes;

    /**
     * GameController constructor.
     *
     * @param GameService $gameService
     * @param Request $request
     */
    public function __construct(Request $request, private readonly GameService $gameService)
    {
        $this->includes = $request->has('include') ? explode(',', $request->input('include')) : [];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        return $this->gameService->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateGameRequest $request
     * @return JsonResponse
     */
    public function store(CreateGameRequest $request): JsonResponse
    {
       return $this->gameService->store($request,$this->includes);
    }

    /**
     * Display the specified resource.
     *
     * @param string $gameId
     * @return JsonResponse
     */
    public function show(string $gameId): JsonResponse
    {
       return $this->gameService->show($gameId);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateGameRequest $request
     * @param Game $game
     * @return JsonResponse
     */
    public function update(UpdateGameRequest $request, Game $game): JsonResponse
    {
         return $this->gameService->update($request,$game,$this->includes);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Game $game
     * @return JsonResponse
     */
    public function destroy(Game $game): JsonResponse
    {
        return $this->gameService->destroy($game);
    }
}
