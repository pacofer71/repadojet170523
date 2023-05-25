<x-app-layout>
    <x-miscomponentes.main>
        <form name="qa" action="{{ route('contacto.procesar') }}" method='POST' placeholder="Su nombre...">
            @csrf
            <x-form-input name="nombre" label="Nombre del Contacto" />
            @auth
                @bind(auth()->user())
                    <x-form-input name="email" label="Email de contacto" readonly />
                @endbind
            @else
                <x-form-input name="email" label="Email de contacto" />
            @endauth
            <x-form-textarea name="contenido" rows='4' placeholder="Dejenos su mensaje..." label="Contenido" />
            
            <div class="mt-4 flex flex-row-reverse">
                <button type='submit'
                    class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fa-solid fa-paper-plane"></i> ENVIAR
                </button>
                <a href="/" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-xmark"></i> CANCELAR
                </a>
            </div>
        </form>
    </x-miscomponentes.main>
</x-app-layout>
