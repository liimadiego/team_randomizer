<style>
    tr:nth-child(even) {background-color: #00000008;}
</style>

<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div style="display:flex;justify-content:space-between;width:100%">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <?php echo e(__('Jogadores')); ?>

            </h2>
            <div>
                <a style="background: #0A2463;"
                   class="text-white font-bold py-2 px-4 rounded"
                   href="<?php echo e(route('player.create')); ?>"
                >
                    <i class="fa-solid fa-plus"></i> Adicionar jogador
                </a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                <?php if($errors->count()): ?>
                    <div style="color: red;">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $erro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e($erro); ?><br>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
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
                            <?php $__currentLoopData = $players; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <?php echo e($player->name); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo e($player->is_goalkeeper ? "Sim" : "Não"); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo e($player->level); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <a href="<?php echo e(route('player.edit', $player->id)); ?>">
                                            <i class="fas fa-edit" style="color:#0A2463;margin-right:10px"></i>
                                        </a>
                                        <button class="text-red-500 hover:text-red-700" onclick="deletePlayer(<?php echo e($player->id); ?>, '<?php echo e($player->name); ?>')">
                                            <i class="fas fa-trash" style="color:#D8315B"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <?php echo e($players->links('vendor.pagination.tailwind')); ?>

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
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/resources/views/players/index.blade.php ENDPATH**/ ?>