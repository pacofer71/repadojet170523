<x-app-layout>
    <x-miscomponentes.main>
        <div class="px-4 py-2 rounded-xl shadow-xl bg-gray-200 mx-auto w-1/2">
            <form name="a" method="POST" action="{{route('tags.store')}}">
                @csrf
                <x-form-input name="nombre" label="Nombre Etiqueta" placeholder="Nombre...." />
                <div class="mt-4 flex flex-row-reverse">
                    <button type='submit' class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-save"></i> GUARDAR
                    </button>
                    <a href="{{route('tags.index')}}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-xmark"></i> CANCELAR
                    </a>
                </div>
            </form>
        </div>
    </x-miscomponentes.main>
</x-app-layout>
