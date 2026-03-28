<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Журнал оценок') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container">
                <div>
                    <a class="btn btn-success btn_align mb-3"> Добавить </a>
                    
                    @if($grades->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped text-center">
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
                                            <td>{{ $grade->user->name }}</td>
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
                            Оценки не найдены
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>