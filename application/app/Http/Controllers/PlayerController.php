<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PlayerRepository;
use Illuminate\Support\MessageBag;
use App\Http\Requests\PlayerRequest;

class PlayerController extends Controller
{
    protected PlayerRepository $playerRepository;

    public function __construct(PlayerRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $players = $this->playerRepository->paginate();

        return view('players.index', compact('players'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('players.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlayerRequest $request)
    {
        try{   
            if (!$request->validated()) {
                return back()->withInput($request->input())->withErrors(new MessageBag(['Dados inválidos, tente novamente!']));
            }

            $this->playerRepository->create([
                'name' => $request->input('name'),
                'is_goalkeeper' => $request->input('is_goalkeeper'),
                'level' => $request->input('level')
            ]);
            
            return redirect()->route('player.index');
        } catch (\Exception $ex) {
            return redirect()->back()->withInput($request->all())->withErrors(new MessageBag([$ex->getMessage()]));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $player = $this->playerRepository->findOne($id);

        return view('players.edit', compact('player'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlayerRequest $request, string $id)
    {
        try{   
            if (!$request->validated()) {
                return back()->withInput($request->input())->withErrors(new MessageBag(['Dados inválidos, tente novamente!']));
            }

            $this->playerRepository->updateById([
                'name' => $request->input('name'),
                'is_goalkeeper' => $request->input('is_goalkeeper'),
                'level' => $request->input('level')
            ], $id);
            
            return redirect()->route('player.index');
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
            $data = $this->playerRepository->destroy($id);

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
