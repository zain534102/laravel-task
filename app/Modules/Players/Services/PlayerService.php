<?php

namespace App\Modules\Players\Services;

use App\Modules\Common\Services\BaseService;
use App\Modules\Players\Contracts\Repositories\PlayerRepository;
use App\Modules\Players\Player;
use App\Modules\Players\Requests\CreatePlayerRequest;
use App\Modules\Players\Requests\UpdatePlayerRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class PlayerService extends BaseService
{
    /**
     * PlayerService constructor.
     *
     * @param PlayerRepository $playerRepository
     */
    public function __construct(private readonly PlayerRepository $playerRepository)
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
            $players = $this->playerRepository->get();
        } else {
            $players = $this->playerRepository->paginate();
        }
        $data = $this->playerRepository->transformCollection($players);
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreatePlayerRequest $request
     * @return JsonResponse
     */
    public function store(CreatePlayerRequest $request, array $includes)
    {
        DB::beginTransaction();
        try {
            $player = $this->playerRepository->create($request->validated())
                ->load(includes_to_camel_case($includes));
            $this->playerRepository->setModel($player);
            $data = $this->playerRepository->transformItem($includes);
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
     * @param string $playerId
     * @return JsonResponse
     */
    public function show(int $playerId)
    {
        $player = $this->playerRepository->findByParams([$playerId]);
        $this->playerRepository->setModel($player);
        $data = $this->playerRepository->transformItem();
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePlayerRequest $request
     * @param Player $player
     * @return JsonResponse
     */
    public function update(UpdatePlayerRequest $request, Player $player, array $includes)
    {
         DB::beginTransaction();
         try {
            $this->playerRepository->setModel($player);
            $this->playerRepository->update($request->all())->load(includes_to_camel_case($includes));
            $data = $this->playerRepository->transformItem();
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
     * @param Player $player
     * @return JsonResponse
     */
    public function destroy(Player $player)
    {
        $this->playerRepository->setModel($player);
        $this->playerRepository->delete();
        $data = $this->playerRepository->transformNull();
        return response()->json($data, 202);
    }
}
