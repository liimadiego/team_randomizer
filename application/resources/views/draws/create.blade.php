<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Criar sorteio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="max-width:900px">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div>
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900">
                                Jogadores confirmados
                            </div>
                        </div>

                        <div style="overflow-x: auto">
                            <div style="display:flex">
                                @foreach($everyTenPlayers as $playersColumn)
                                    <div class="p-4" style="width:200px;display:flex;flex-direction:column;min-width: 150px;">
                                        @foreach ($playersColumn as $player)
                                            <div style="margin: 7px 0">
                                                <input 
                                                    checked
                                                    class="player_tag" 
                                                    type="checkbox" 
                                                    id="player_{{ $player->id }}" 
                                                    value="{{ $player->id }}___{{ $player->name }}___{{ $player->level }}___{{ $player->is_goalkeeper }}"
                                                />
                                                <label for="player_{{ $player->id }}">
                                                    {{ $player->name }}
                                                    {{ $player->is_goalkeeper ? " (Goleiro)" : "" }}

                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <div style="margin: 1rem">
                        <label for="players_per_team" class="block text-sm font-medium text-gray-700">
                            Jogadores por time
                        </label>
                        <input type="number" name="players_per_team" id="players_per_team"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="5">
                    </div>
                    <div style="margin: 1rem">
                        <label for="draw_date" class="block text-sm font-medium text-gray-700">
                            Data e hora do jogo
                        </label>
                        <input value="2024-09-12 22:50" id="draw_date" type="datetime-local" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                    </div>
                    @if($errors->count())
                        <div style="color: red;">
                            @foreach($errors->all() as $erro)
                                {{ $erro }}<br>
                            @endforeach
                        </div>
                    @endif

                    <div class="flex justify-end" style="margin-top: 2rem">
                        <a href="{{ route('draw.index') }}"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                            Cancelar
                        </a>
                        <button
                            onclick="drawTeams()"
                            style="background: #0A2463;"
                            class="text-white font-bold py-2 px-4 rounded">
                            Sortear
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function drawTeams(){
            let playersPerTeam = document.querySelector("#players_per_team");
            let confirmedPlayers = getConfirmedPlayers();
            let validatedDateTime = validateDateTime();
            
            if(!validatedDateTime.success){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: validatedDateTime.errorMsg
                });

                return;
            }

            if(playersPerTeam.value == ""){
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Você esqueceu de definir o número de jogadores por time!"
                });

                return;
            }

            let teams = createBalancedTeams(confirmedPlayers, playersPerTeam.value)
            
            if(!!teams){
                const storeUrl = "{{ route('draw.store') }}";
                const dataToReq = {
                    players_per_team: playersPerTeam.value,
                    total_teams: teams.length,
                    draw_date: validatedDateTime.value,
                    confirmed_players: confirmedPlayers.length,
                    teams: teams
                }

                fetch(storeUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(dataToReq)
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        const drawId = data.id;
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Times criados com sucesso!',
                            text: `O sorteio foi salvo e será exibido`
                        }).then(() => {
                            window.location.href = `/draw/${drawId}`;
                        });
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Ocorreu um erro ao salvar os times. Tente novamente mais tarde.'
                        });
                    });
            }

        }

        function getConfirmedPlayers(){
            let players = [];
            let playersCheckboxes = document.querySelectorAll(".player_tag");

            if (!playersCheckboxes || playersCheckboxes.length === 0) {
                return players;
            }

            playersCheckboxes.forEach(playerCheckbox => {
                if(playerCheckbox.checked){
                    let [id, name, level, is_goalkeeper] = playerCheckbox.value.split("___");
                    if (id && name && level && is_goalkeeper) {
                        players.push({ id, name, level, is_goalkeeper });
                    }
                }
            });

            return players;
        }

        function createBalancedTeams(players, maxPlayersPerTeam) {
            let goalkeepers = [];
            let nonGoalkeepers = [];
            
            players.forEach(player => {
                if (player.is_goalkeeper === "1") {
                    goalkeepers.push(player);
                } else {
                    nonGoalkeepers.push(player);
                }
            });

            shuffleArray(goalkeepers)
            goalkeepers = goalkeepers.slice(0, Math.ceil(players.length / maxPlayersPerTeam));
            const numTeams = Math.max(2, Math.ceil(players.length / maxPlayersPerTeam));
            
            // if(numTeams > goalkeepers.length){
            //     Swal.fire({
            //         icon: "error",
            //         title: "Oops...",
            //         text: `impossível formar ${numTeams} times, só existem ${goalkeepers.length} goleiros`
            //     });

            //     return false;
            // }
            
            if(!(maxPlayersPerTeam * 2 <= (goalkeepers.length + nonGoalkeepers.length))){
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Não existem jogadores suficientes para montar 2 times!"
                });

                return false;
            }

            let teams = goalkeepers.map(goalkeeper => ({
                players: [goalkeeper],
                totalLevel: parseInt(goalkeeper.level)
            }));

            shuffleArray(nonGoalkeepers);

            nonGoalkeepers.forEach(player => {
                const teamsWithFreeSlots = teams.filter(team => team.players.length < maxPlayersPerTeam);
                const teamToAdd = teamsWithFreeSlots.reduce((prev, curr) => {
                    return curr.totalLevel < prev.totalLevel ? curr : prev;
                }, teamsWithFreeSlots[0]);

                if(teamToAdd){
                    teamToAdd.players.push(player);
                    teamToAdd.totalLevel += parseInt(player.level);
                }
            });

            teams.forEach((team, index) => {
                if(index < numTeams - 1){
                    while(team.players.length < maxPlayersPerTeam){
                        let lastIndex = teams.length - 1;
                        let lastTeamPlayers = teams[lastIndex].players;
                        let players = team.players;
                        let topPlayer = findTopPlayerWithIndex(lastTeamPlayers)

                        players.push(topPlayer)
                        team.totalLevel += parseInt(topPlayer.level)

                        lastTeamPlayers.splice(topPlayer.index, 1);
                        teams[lastIndex].totalLevel -= parseInt(topPlayer.level)
                    }
                }
            })

            teams = teams.map(team => ({
                ...team,
                averageLevel: (team.totalLevel / team.players.length).toFixed(2)
            }));

            return teams;
        }

        function shuffleArray(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
        }

        function findTopPlayerWithIndex(players) {
            const topPlayer = players
                .map((player, index) => ({ ...player, index })) 
                .filter(player => player.is_goalkeeper === "0")
                .reduce((topPlayer, currentPlayer) => {
                    return parseInt(currentPlayer.level) > parseInt(topPlayer.level) ? currentPlayer : topPlayer;
                });

            return topPlayer;
        }

        function validateDateTime() {
            const dateElement = document.querySelector('input[type="datetime-local"]');
            if(dateElement.value == ""){
                return {
                    success: false,
                    errorMsg: "Selecione data e hora."
                }
            }

            const selectedDateTime = new Date(dateElement.value);
            const now = new Date();
            
            const tenMinuteAhead = new Date(now.getTime() + 10 * 60 * 1000);

            if(!(selectedDateTime > tenMinuteAhead)){
                return {
                    success: false,
                    errorMsg: "É necessário marcar com ao menos 10 minutos de antecedência."
                }
            }
            return { success: true, value: dateElement.value };
        }

    </script>
</x-app-layout>
