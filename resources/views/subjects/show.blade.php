<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Информация о предмете') }}: {{ $subject->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-4">
                    <p for="title" class="block text-l font-medium text-gray-700 mb-3">Название предмета</p>
                    <p class="text-l text-gray-600 uppercase font-bold"> {{ $subject->name }} </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>