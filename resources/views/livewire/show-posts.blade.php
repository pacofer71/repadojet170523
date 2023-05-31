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
                                <button wire:click="detalle('{{ $item->id }}')"><i
                                        class="fas fa-info bg-blue-400 px-2 py-1 rounded-md"></i></button>
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
                                    'px-2 py-2 rounded-md text-white font-semibold cursor-pointer',
                                    'bg-red-400 line-through' => $item->estado == 'BORRADOR',
                                    'bg-green-400' => $item->estado == 'PUBLICADO',
                                ]) wire:click="cambiarEstado('{{$item->id}}')">
                                    {{ $item->estado }}
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <button wire:click="editar('{{$item->id}}')" wire:loading.attr="disabled">
                                    <i class="fas fa-edit text-yellow-400"></i>
                                </button>
                                <button wire:click="confirmar('{{$item->id}}')" wire:loading.attr="disabled">
                                    <i class="fas fa-trash text-red-400"></i>
                                </button>
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
    <!-- ______________________ Modal para detalle ____________________________________ -->
    @isset($miPost->category)
    <x-dialog-modal wire:model="openDetalle">
        <x-slot name="title">
            Detalle Post
        </x-slot>
        <x-slot name="content">
            <div
                class="mx-auto max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <img class="rounded object-cover object-center w-full" src="{{Storage::url($miPost->imagen)}}" alt=""  />
                <div class="p-5">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{$miPost->titulo}}</h5>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{$miPost->contenido}}</p>
                    <p class="mb-6 font-normal text-gray-700 dark:text-gray-400">
                        CATEGORIA:<span class="px-2 py-2 rounded" style="background-color:{{$miPost->category->color}}">{{$miPost->category->nombre}}</span>
                    </p>
                    <p class="mb-6 font-normal text-gray-700 dark:text-gray-400">
                        ESTADO:<span @class([
                            "px-2 py-2 rounded",
                            "bg-red-400"=>$miPost->estado=="BORRADOR",
                            "bg-green-400"=>$miPost->estado=="PUBLICADO",
                            ])>{{$miPost->estado}}</span>
                    </p>
                    <p class="mb-6 font-normal text-gray-700 dark:text-gray-400">
                        Fecha última actualización: {{$miPost->updated_at->format('d/m/Y h:i:s')}}
                    </p>

                </div>
            </div>

        </x-slot>
        <x-slot name="footer">
            <button class="mr-4 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" wire:click="$set('openDetalle', false)">
                <i class="fas fa-xmark mr-2"></i>CERRAR
            </button>
        </x-slot>
    </x-dialog-modal>
    @endisset
    <!-- ___________________________________________ MODAL PARA EDITAR ____________________________ -->
    @if($miPost)
    <x-dialog-modal wire:model="openEditar">
        <x-slot name="title">
            Editar Post
        </x-slot>
        <x-slot name="content">
            @wire($miPost, 'defer')
                <x-form-input name="miPost.titulo" label="Título del Post" placeholder="Título ..." />
                <x-form-textarea name="miPost.contenido" placeholder="Contenido..." label="Contenido del Post" />
                <x-form-group name="estado" label="Estado del Post" inline>
                    <x-form-radio name="miPost.estado" value="PUBLICADO" label="Publicado" />
                    <x-form-radio name="miPost.estado" value="BORRADOR" label="Borrador" />
                </x-form-group>
                <x-form-select name="miPost.category_id" :options="$categorias" label="Categoria del Post" />
            @endwire
            <div class="mt-4">
                <span class="text-gray-700">Imagen del Post</span>
            </div>
            <div class="relative mt-4 w-full h-64 bg-gray-100">
                @isset($imagen)
                    <img src="{{ $imagen->temporaryUrl() }}" class="rounded-xl w-full h-full">
                @else
                    <img src="{{ Storage::url($miPost->imagen) }}" class="rounded-xl w-full h-full">
                @endisset
                <label for="img1"
                    class="absolute bottom-2 end-2
                bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fa-solid fa-cloud-arrow-up"></i> Subir Imagen</label>
                <input type="file" name="imagen" accept="image/*" class="hidden" id="img1"
                    wire:model="imagen" />
            </div>
            @error('imagen')
                <p class="text-red-500 italic text-xs">{{ $message }}</p>
            @enderror

        </x-slot>
        <x-slot name="footer">
            <div class="flex flex-row-reverse">
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                    wire:click="update" wire:loading.attr="disabled">
                    <i class="fas fa-save mr-2"></i>EDITAR
                </button>
                <button class="mr-4 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" wire:click="$set('openEditar', false)">
                    <i class="fas fa-xmark mr-2"></i>CANCELAR
                </button>

            </div>
        </x-slot>
    </x-dialog-modal>
    @endif
</x-miscomponentes.main>
