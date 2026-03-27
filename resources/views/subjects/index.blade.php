@extends('layouts.app')

@section('content')
<div class="container">
    <div>    
        <h2>Журнал предметов</h2>
        
        <form action="{{ route('subjects.index') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-9">
                <input type="text" name="name" class="form-control" placeholder="Название предмета..." value="{{ request('name') }}">
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary" type="submit">Найти</button>
                @if(request('name'))
                    <a href="{{ route('subjects.index') }}" class="btn btn-outline-secondary">Сбросить</a>
                @endif 
                <a class="btn btn-success"> Добавить </a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th> Предмет </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subjects as $subject)
                        <tr>
                            <td class="d-flex gap-0 justify-content-between align-items-center">
                                <div style="flex: 1;"></div>

                                <span class="text-center font16" style="flex: 2;">
                                    {{ $subject->name }}
                                </span>

                                <div style="flex: 1;" class="text-end">
                                    <a href="" class="btn btn-primary">
                                        Подробнее
                                    </a>
                                    <a href="" class="btn btn-warning">
                                        Изменить
                                    </a>
                                    <a href="" class="btn btn-danger">
                                        Удалить
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($subjects instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="d-flex justify-content-center mt-4">
                {{ $subjects->links() }}
            </div>
        @endif
    </div>
</div>
@endsection 