<!DOCTYPE html>
<html>
<head>
    <title>Ваша успеваемость</title>
</head>
<body>
    <h1>Здравствуйте, {{ $user->name }}!</h1>
    <p>Вот ваши текущие оценки по предметам:</p>

    <ul>
        @forelse($performance as $subject => $score)
            <li><strong>{{ $subject }}:</strong> {{ $score }}</li>
        @empty
            <li>Оценок пока нет.</li>
        @endforelse
    </ul>

    <p>Удачи в учебе!</p>
</body>
</html>