@extends('layouts.app')

@section('content')
<div class="container">
    <div>    
        <h2>Журнал студентов</h2>

        <form action="{{ route('students.index') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-6">
                <input type="text" name="fio" value="{{ request('fio') }}" 
                    class="form-control" placeholder="Поиск по ФИО...">
            </div>
            <div class="col-md-3">
                <input type="date" name="birthday" value="{{ request('birthday') }}" 
                    class="form-control">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Найти</button>
                <a href="{{ route('students.index') }}" class="btn btn-secondary">Сбросить</a>
                <a class="btn btn-success"> Добавить </a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th> Студент </th>
                        <th> Группа </th>
                        <th>  </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td>
                                {{ $student->fio }}
                            </td>
                            <td>
                                {{ $student->group->name }}
                            </td>
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
        
        @if($students instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="d-flex justify-content-center mt-4">
                {{ $students->links() }}
            </div>
        @endif
    </div>
</div>
@endsection 