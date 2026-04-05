<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Редактировать группу: {{ $group->name }}
        </h2>
    </x-slot>

    <div class="py-12 space-y-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white p-6 shadow sm:rounded-lg mb-6">
                <form action="{{ route('groups.update', $group) }}" method="POST">
                    @csrf @method('PUT')
                    <label class="block font-medium text-sm text-gray-700">Название группы</label>
                    <div class="flex gap-4 mt-1">
                        <input type="text" name="name" value="{{ old('name', $group->name) }}" class="rounded-md shadow-sm border-gray-300 focus:ring-indigo-500 flex-1">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Обновить имя</button>
                    </div>
                </form>
            </div>

            <div class="bg-white p-6 shadow sm:rounded-lg mb-6 border-l-4 border-green-500">
                @include('groups.form')
            </div>

            <div class="bg-white shadow sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"> Студент </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"> Почта </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase"> Действие </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($currentStudents as $user)
                        <tr>
                            <td class="px-6 py-4">{{ $user->name }}</td>
                            <td class="px-6 py-4">
                                @if($user->email)
                                    {{ $user->email }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('groups.remove-user', [$group, $user]) }}" method="POST" onsubmit="return confirm('Удалить студента из группы?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Исключить</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>