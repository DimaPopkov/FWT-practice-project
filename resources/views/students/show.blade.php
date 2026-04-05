<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Профиль студента: {{ $student->name }}
            </h2>
            
            @can('update', $student)
                <a href="{{ route('students.edit', $student) }}" class="btn btn-secondary">
                    Редактировать профиль
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600 uppercase font-bold">Name:</p>
                        <p class="text-lg text-gray-900">{{ $student->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 uppercase font-bold">Email:</p>
                        <p class="text-lg text-gray-900">
                            @if($student->email)
                                {{ $student->email }}
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 uppercase font-bold">Группа:</p>
                        <p class="text-lg text-gray-900">{{ $student->group->name ?? 'Без группы' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>