<style>
    tr:nth-child(even) {background-color: #00000008;}
</style>

<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;justify-content:space-between;width:100%">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Jogadores') }}
            </h2>
            <div>
                <a style="background: #0A2463;"
                   class="text-white font-bold py-2 px-4 rounded"
                   href="{{ route('player.create') }}"
                >
                    <i class="fa-solid fa-plus"></i> Adicionar jogador
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                @if($errors->count())
                    <div style="color: red;">
                        @foreach($errors->all() as $erro)
                            {{ $erro }}<br>
                        @endforeach
                    </div>
                @endif
                <table class="w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nome
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Goleiro
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nível
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($players as $player)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $player->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $player->is_goalkeeper ? "Sim" : "Não" }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $player->level }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <a href="{{ route('player.edit', $player->id) }}">
                                            <i class="fas fa-edit" style="color:#0A2463;margin-right:10px"></i>
                                        </a>
                                        <button class="text-red-500 hover:text-red-700" onclick="deletePlayer({{ $player->id }}, '{{ $player->name }}')">
                                            <i class="fas fa-trash" style="color:#D8315B"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $players->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    </div>

    <script>

    function deletePlayer(id, player){
        Swal.fire({
            title: `Tem certeza que deseja excluir ${player}?`,
            text: "Isso não poderá ser defeito",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Tenho certeza",
            cancelButtonText: "Cancelar"
        }).then((resultSA) => {
            if(resultSA.isConfirmed){
                fetch(`/player/delete/${id}`)
                    .then(r => r.json())
                    .then(data => {
                        if (data.result) {
                            Swal.fire({
                                title: "Deletado",
                                text: "O jogador foi deletado",
                                icon: "success"
                            }).then(resultSuccess => {
                                location.reload();
                            });
                        }else{
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Algo deu errado!"
                            });
                        }
                    })
            }
        });
    }

    </script>
</x-app-layout>
