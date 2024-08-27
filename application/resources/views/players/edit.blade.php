<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Jogador') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('player.update', $player->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Nome
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $player->name) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div class="mb-4">
                            <label for="level" class="block text-sm font-medium text-gray-700">
                                Nível <span class="text-gray-500"><i>(1 - 5)</i></span>
                            </label>
                            <input type="number" name="level" id="level" value="{{ old('level', $player->level) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" max="5" min="1">
                        </div>

                        <div class="mb-4">
                            <label for="is_goalkeeper" class="block text-sm font-medium text-gray-700">
                                Goleiro
                            </label>
                            <select name="is_goalkeeper" id="is_goalkeeper"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="1" {{ old('is_goalkeeper', $player->is_goalkeeper) == 1 ? 'selected' : '' }}>Sim</option>
                                <option value="0" {{ old('is_goalkeeper', $player->is_goalkeeper) == 0 ? 'selected' : '' }}>Não</option>
                            </select>
                        </div>

                        
                        @if($errors->count())
                            <div style="color: red;">
                                @foreach($errors->all() as $erro)
                                    {{ $erro }}<br>
                                @endforeach
                            </div>
                        @endif

                        <div class="flex justify-end">
                            <a href="{{ route('player.index') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Cancelar
                            </a>
                            <button type="submit"
                                style="background: #0A2463;"
                                class="text-white font-bold py-2 px-4 rounded">
                                Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const level = document.querySelector("#level");

        level.addEventListener("change", e => {
            if(e.target.value > 5){
                level.value = 5;
            }
        })
    </script>
</x-app-layout>
