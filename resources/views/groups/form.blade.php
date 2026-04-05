<h3 class="text-lg font-bold mb-4">Добавить студента в группу</h3>

<form action="{{ route('groups.add-user', $group) }}" method="POST" class="flex gap-4">
    @csrf
    <select name="user_id" class="rounded-md shadow-sm border-gray-300 flex-1">
        <option value=""> Выберите студента без группы </option>
        @foreach($availableStudents as $student)
            <option value="{{ $student->id }}">{{ $student->name }} 
                @if($student->email)
                    ({{ $student->email }})
                @endif
            </option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-success">Добавить</button>
</form>