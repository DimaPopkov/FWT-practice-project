<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Информация о студенте</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; } {{-- Для поддержки кириллицы --}}
        h1 { text-align: center; }
    </style>
</head>
<body>
    <h1>Карточка студента</h1>
    <p><strong>ФИО:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Роль:</strong> {{ $user->role }}</p>
    {{-- Аватар по заданию в PDF выводить НЕ нужно --}}
</body>
</html>