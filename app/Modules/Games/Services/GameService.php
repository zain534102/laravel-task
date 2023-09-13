<?php

namespace App\Modules\Games\Services;

use App\Modules\Common\Services\BaseService;
use App\Modules\Games\Contracts\Repositories\GameRepository;
use App\Modules\Games\Game;
use App\Modules\Games\Requests\CreateGameRequest;
use App\Modules\Games\Requests\UpdateGameRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class GameService extends BaseService
{
    /**
     * GameService constructor.
     *
     * @param GameRepository $gameRepository
     */
    public function __construct(private readonly GameRepository $gameRepository)
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->has('all')) {
            $games = $this->gameRepository->get();
        } else {
            $games = $this->gameRepository->paginate();
        }
        $data = $this->gameRepository->transformCollection($games);
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateGameRequest $request
     * @return JsonResponse
     */
    public function store(CreateGameRequest $request, array $includes)
    {
        DB::beginTransaction();
        try {
            $game = $this->gameRepository->create($request->validated())
                ->load(includes_to_camel_case($includes));
            $this->gameRepository->setModel($game);
            $data = $this->gameRepository->transformItem($includes);
            DB::commit();
            return response()->json($data, 201);
        }
        catch (\Exception $exception){
            Log::info("Error message while creating user submission",['error'=> $exception->getMessage(),'error_file'=>$exception->getFile(),'line'=>$exception->getLine()]);
            DB::rollBack();
            return response()->json(['There is an issue on creation'],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param string $gameId
     * @return JsonResponse
     */
    public function show(int $gameId)
    {
        $game = $this->gameRepository->findByParams([$gameId]);
        $this->gameRepository->setModel($game);
        $data = $this->gameRepository->transformItem();
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateGameRequest $request
     * @param Game $game
     * @return JsonResponse
     */
    public function update(UpdateGameRequest $request, Game $game, array $includes)
    {
         DB::beginTransaction();
         try {
            $this->gameRepository->setModel($game);
            $this->gameRepository->update($request->all())->load(includes_to_camel_case($includes));
            $data = $this->gameRepository->transformItem();
            DB::commit();
            return response()->json($data);
         }
         catch (\Exception $exception){
             Log::info("Error message while creating user submission",['error'=> $exception->getMessage(),'error_file'=>$exception->getFile(),'line'=>$exception->getLine()]);
             DB::rollBack();
             return response()->json(['There is an issue on updating record'],Response::HTTP_INTERNAL_SERVER_ERROR);
         }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Game $game
     * @return JsonResponse
     */
    public function destroy(Game $game)
    {
        $this->gameRepository->setModel($game);
        $this->gameRepository->delete();
        $data = $this->gameRepository->transformNull();
        return response()->json($data, 202);
    }
}
