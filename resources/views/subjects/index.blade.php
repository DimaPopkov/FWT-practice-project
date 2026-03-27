<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Журнал предметов') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container">
                <div>
                    
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
                        <table class="table table-bordered table-striped text-center">
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

                                            <span class="text-center font16" style="flex: 1;">
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
        </div>
    </div>
</x-app-layout>