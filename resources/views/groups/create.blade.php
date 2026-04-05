<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Добавление группы') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('groups.store') }}" method="POST" class="max-w-md">
                    @csrf

                    <!-- Название группы -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Название группы</label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name') }}" 
                               class="mt-1 block w-full border-gray-300 rounded-md focus:ring-indigo-500 @error('name') border-red-500 @enderror" 
                               placeholder="Название"
                               required>
                        
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="btn btn-success">
                            Создать группу
                        </button>
                        
                        <a href="{{ route('groups.index') }}" class="text-sm text-gray-600">
                            Отмена
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>