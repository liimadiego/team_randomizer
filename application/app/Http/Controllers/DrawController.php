<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\DrawRepository;
use App\Repositories\PlayerRepository;
use App\Repositories\TeamRepository;
use Illuminate\Support\MessageBag;
use App\Http\Requests\DrawRequest;
use Illuminate\Support\Facades\DB;

class DrawController extends Controller
{
    protected DrawRepository $drawRepository;
    protected PlayerRepository $playerRepository;
    protected TeamRepository $teamRepository;

    public function __construct(
        DrawRepository $drawRepository,
        PlayerRepository $playerRepository,
        TeamRepository $teamRepository 
    )
    {
        $this->drawRepository = $drawRepository;
        $this->playerRepository = $playerRepository;
        $this->teamRepository = $teamRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $draws = $this->drawRepository->paginate();

        return view('draws.index', compact('draws'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $players = $this->playerRepository->findAll();
        $everyTenPlayers = $players->chunk(6);

        return view('draws.create', compact('everyTenPlayers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DrawRequest $request)
    {
        try{   

            $storedDraw = $this->drawRepository->create([
                'players_per_team' => $request->input('players_per_team'),
                'total_teams' => $request->input('total_teams'),
                'confirmed_players' => $request->input('confirmed_players'),
                'draw_date' => $request->input('draw_date')
            ]);

            $counter = 1;
            foreach ($request->input('teams') as $team) {
                $storedTeam = $this->teamRepository->create([
                    'draw_id' => $storedDraw->id,
                    'name' => "Time $counter"
                ]);

                foreach ($team['players'] as $player) {
                    DB::table('player_team')
                        ->insert([
                            'team_id' => $storedTeam->id,
                            'player_id' => $player['id']
                        ]);
                }

                $counter++;
            }

            return response()->json([
                'result' => true,
                'messages' => 'Salvo com sucesso!',
                'id' => $storedDraw->id
            ]);
        } catch (Exception $ex){
            return response()->json([
                'result' => false,
                'messages' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $draw = $this->drawRepository->getDrawTeamsPlayers($id);

        return view('draws.details', compact('draw'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DrawRequest $request, string $id)
    {
        try{   
            if (!$request->validated()) {
                return back()->withInput($request->input())->withErrors(new MessageBag(['Dados inválidos, tente novamente!']));
            }

            $this->drawRepository->updateById([
                'name' => $request->input('name'),
                'is_goalkeeper' => $request->input('is_goalkeeper'),
                'level' => $request->input('level')
            ], $id);
            
            return redirect()->route('draw.index');
        } catch (\Exception $ex) {
            return redirect()->back()->withInput($request->all())->withErrors(new MessageBag([$ex->getMessage()]));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        try{   
            $data = $this->drawRepository->destroy($id);

            return response()->json([
                'result' => true,
                'messages' => 'Excluido com sucesso!',
            ]);
        } catch (Exception $ex){
            return response()->json([
                'result' => false,
                'messages' => $e->getMessage()
            ]);
        }
    }
}
