<h1>Профиль студента: {{ $student->name }}</h1>

<table class="min-w-full">
    <thead>
        <tr>
            <th>Предмет</th>
            <th>Оценка</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        @foreach($student->grades as $grade)
        <tr>
            <td>{{ $grade->subject->title }}</td>
            <td>{{ $grade->score }}</td>
            <td>
                <a href="{{ route('grades.edit', [$grade, $student]) }}" class="text-blue-600">Редактировать</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ route('grades.create', $student) }}" class="mt-4 inline-block bg-green-500 text-white px-4 py-2">
    + Добавить оценку
</a>