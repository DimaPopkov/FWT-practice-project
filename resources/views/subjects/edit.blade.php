<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Редактировать предмет') }}: {{ $subject->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('subjects.update', $subject) }}" method="POST" class="max-w-md">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Название предмета</label>
                        <input type="text" 
                               name="name" 
                               id="name"
                               value="{{ old('name', $subject->name) }}" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('name') border-red-500 @enderror" 
                               required>
                        
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="btn btn-success">
                            Сохранить изменения
                        </button>
                        
                        <a href="{{ route('subjects.index') }}" class="text-sm text-gray-600 hover:underline">
                            Отмена
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>