<x-miscomponentes.main>
    <div class="flex w-full mb-2">
        <div class="w-full  flex-1">
            <x-input type="search" placeholder="Buscar..." wire:model="buscar" class="w-full" />
        </div>
        <div class="ml-4">
            @livewire('create-post')
        </div>
    </div>
    @if ($posts->count())
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Detalle
                        </th>
                        <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('titulo')">
                            <i class="fas fa-sort mr-2"></i> Titulo
                        </th>
                        <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('category_id')">
                            <i class="fas fa-sort mr-2"></i>Categoria
                        </th>
                        <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('estado')">
                            <i class="fas fa-sort mr-2"></i>Estado
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <i class="fas fa-info bg-blue-400 px-2 py-1 rounded-md"></i>
                            </th>
                            <td class="px-6 py-4">
                                {{ $item->titulo }}
                            </td>
                            <td class="px-6 py-4">
                                <p class="px-2 py-2 rounded-md text-white font-semibold"
                                    style="background-color:{{ $item->category->color }}">{{ $item->category->nombre }}
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <p @class([
                                    'px-2 py-2 rounded-md text-white font-semibold',
                                    'bg-red-400 line-through' => $item->estado == 'BORRADOR',
                                    'bg-green-400' => $item->estado == 'PUBLICADO',
                                ])>
                                    {{ $item->estado }}
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                Acciones
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-2">
                {{ $posts->links() }}
            </div>
        </div>
    @else
        <p class="font-bold italic text-red-600">No se encontró ningún post o aun no ha creado ninguno</p>
    @endif

</x-miscomponentes.main>
