<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Журнал студентов') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container">
                <div>

                    <form action="{{ route('students.index') }}" method="GET" class="row g-3 mb-4">
                        <div class="col-md-6">
                            <input type="text" name="name" value="{{ request('name') }}" 
                                class="form-control" placeholder="Поиск по ФИО...">
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="birthday" value="{{ request('birthday') }}" 
                                class="form-control">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">Найти</button>
                            <a href="{{ route('students.index') }}" class="btn btn-secondary">Сбросить</a>
                            @can('create', App\Models\User::class) <a class="btn btn-success"> Добавить </a> @endcan
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-center">
                            <thead class="thead-dark">
                                <tr>
                                    <th> Студент </th>
                                    <th> Дата рождения </th>
                                    <th> Группа </th>
                                    <th>  </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                    <tr>
                                        <td>
                                            {{ $student->name }}
                                        </td>
                                        <td>
                                            {{ $student->formatted_birthday }}
                                        </td>
                                        @if($student->group)
                                            <td>
                                                {{ $student->group->name }}
                                            </td>
                                        @else
                                            <td>
                                                Нет данных
                                            </td>
                                        @endif
                                        
                                        <td>
                                            @can('view', $student)
                                                <a href="" class="btn btn-primary">
                                                    Подробнее
                                                </a>
                                            @endcan
                                            @can('update', $student)
                                                <a href="" class="btn btn-warning">
                                                    Изменить
                                                </a>
                                            @endcan
                                            @can('delete', $student)
                                                <a href="" class="btn btn-danger">
                                                    Удалить
                                                </a>
                                            @endcan
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
        </div>
    </div>
</x-app-layout>