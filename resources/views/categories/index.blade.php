<x-app-layout>
    <x-miscomponentes.main>
        <div class="mb-2 flex flex-row-reverse">
            <a href="{{ route('categories.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-add"></i> NUEVA
            </a>
        </div>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            NOMBRE
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            COLOR
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ACCIONES
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $item->id }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $item->nombre }}
                            </td>
                            <td class="px-6 py-4">
                                <p class="px-2 py-2 rounded-xl" style="background-color:{{ $item->color }}">&nbsp;</p>
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('categories.destroy', $item) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('categories.edit', $item) }}"><i class='fas fa-edit'></i></a>
                                    <button type='submit'><i class="ml-4 fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

    </x-miscomponentes.main>
</x-app-layout>
