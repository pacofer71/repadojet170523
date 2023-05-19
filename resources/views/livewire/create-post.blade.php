<div>
    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        wire:click="$set('openCrear', true)">
        <i class="fas fa-add mr-2"></i>Nuevo
    </button>
    <x-dialog-modal wire:model="openCrear">
        <x-slot name="title">
            Crear Post
        </x-slot>
        <x-slot name="content">
            @wire('defer')
                <x-form-input name="titulo" label="Título del Post" placeholder="Título ..." />
                <x-form-textarea name="contenido" placeholder="Contenido..." label="Contenido del Post" />
                <x-form-group name="estado" label="Estado del Post" inline>
                    <x-form-radio name="estado" value="PUBLICADO" label="Publicado" />
                    <x-form-radio name="estado" value="BORRADOR" label="Borrador" />
                </x-form-group>
                <x-form-select name="category_id" :options="$categorias" label="Categoria del Post" />
            @endwire
            <div class="mt-4">
                <span class="text-gray-700">Imagen del Post</span>
            </div>
            <div class="relative mt-4 w-full h-64 bg-gray-100">
                @isset($imagen)
                    <img src="{{ $imagen->temporaryUrl() }}" class="rounded-xl w-full h-full">
                @else
                    <img src="{{ Storage::url('noimage.jpg') }}" class="rounded-xl w-full h-full">
                @endisset
                <label for="img"
                    class="absolute bottom-2 end-2
                bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fa-solid fa-cloud-arrow-up"></i> Subir Imagen</label>
                <input type="file" name="imagen" accept="image/*" class="hidden" id="img"
                    wire:model="imagen" />
            </div>
            @error('imagen')
                <p class="text-red-500 italic text-xs">{{ $message }}</p>
            @enderror

        </x-slot>
        <x-slot name="footer">
            <div class="flex flex-row-reverse">
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                    wire:click="guardar()" wire:loading.attr="disabled">
                    <i class="fas fa-save mr-2"></i>GUARDAR
                </button>
                <button class="mr-4 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" wire:click="cerrar()">
                    <i class="fas fa-xmark mr-2"></i>CANCELAR
                </button>

            </div>
        </x-slot>
    </x-dialog-modal>
</div>
