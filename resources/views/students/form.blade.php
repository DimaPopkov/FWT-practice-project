<form action="{{ route('students.update', $student) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label class="block font-medium text-sm text-gray-700">ФИО</label>
        <input type="text" name="name" value="{{ old('name', $student->name) }}" class="w-full border-gray-300 rounded-md shadow-sm">
    </div>

    <div class="mb-4">
        <label class="block font-medium text-sm text-gray-700">Группа</label>
        <select name="group_id" class="w-full border-gray-300 rounded-md shadow-sm">
            @foreach($groups as $group)
                <option value="{{ $group->id }}" {{ $student->group_id == $group->id ? 'selected' : '' }}>
                    {{ $group->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="flex items-center gap-4">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Сохранить изменения
        </button>
        <a href="{{ route('students.show', $student) }}" class="text-gray-600 hover:underline">Отмена</a>
    </div>
</form>