<style>
    tr:nth-child(even) {background-color: #00000008;}
</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ "Sorteio $draw->id - Jogo do dia " . \Carbon\Carbon::parse($draw->draw_date)->format('d/m/Y H:i') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="container mx-auto p-4">
                    <div style="display:flex;flex-wrap:wrap; gap:0.33%;text-align: center;">
                        @foreach($draw->teams as $team)
                            <div style="width:33%">
                                <h3 style="font-size: 15pt;font-weight: bold;margin-bottom:10px">{{ $team->name }}</h3>
                                <hr>
                                @foreach($team->players as $player)
                                    <div style="padding: 5px">
                                        {{ $player->name }} {{ $player->is_goalkeeper ? " - (Goleiro)" : ""  }}
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
