@extends('layouts.app')

@section('content')
<div class="container">
    <div>    
        <h2>Журнал оценок</h2>
        <a class="btn btn-success btn_align"> Добавить </a>
        
        @if($grades->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th> Студент </th>
                            <th> Дата рождения </th>
                            <th> Группа </th>
                            <th> Предмет </th>
                            <th> Оценка </th>
                            <th>  </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grades as $grade)
                            <tr class="{{ $grade->user->grade_class }}">
                                <td>{{ $grade->user->fio }}</td>
                                <td>{{ $grade->user->formatted_birthday }}</td>
                                <td>{{ $grade->user->group->name ?? "Не указана" }}</td>
                                <td>{{ $grade->subject->name ?? "Не указана" }}</td>
                                <td>{{ $grade->grade ?? "Не указана" }}</td>
                                <td>
                                    <a href="" class="btn btn-primary">
                                        Подробнее
                                    </a>
                                    <a href="" class="btn btn-warning">
                                        Изменить
                                    </a>
                                    <a href="" class="btn btn-danger">
                                        Удалить
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="d-flex justify-content-center mt-4">
                    {{ $users->links() }}
                </div>
            @endif
            
        @else
            <div class="alert alert-info">
                Студенты не найдены
            </div>
        @endif
    </div>
</div>
@endsection 