<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Журнал групп') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container">
                <div>
                    
                    <form action="{{ route('groups.index') }}" method="GET" class="row g-3 mb-4">
                        <div class="col-md-9">
                            <input type="text" name="name" value="{{ request('name') }}" class="form-control" placeholder="Поиск по названию группы...">
                            
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary" type="submit">Найти</button>
                            @if(request('name'))
                                <a href="{{ route('groups.index') }}" class="btn btn-outline-secondary">Сбросить</a>
                            @endif    
                            @can('create', App\Models\User::class) <a class="btn btn-success"> Добавить </a> @endcan
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-center">
                            <thead class="thead-dark">
                                <tr>
                                    <th> Группа </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($groups as $group)
                                    <tr>
                                        <td class="d-flex gap-0 justify-content-between align-items-center">
                                            <div style="flex: 1;"></div>

                                            <span class="text-center font16" style="flex: 1;">
                                                {{ $group->name }}
                                            </span>

                                            <div style="flex: 1;" class="text-end">
                                                @can('view', $group)
                                                    <a href="" class="btn btn-primary">
                                                        Подробнее
                                                    </a>
                                                @endcan
                                                @can('update', $group)
                                                    <a href="" class="btn btn-warning">
                                                        Изменить
                                                    </a>
                                                @endcan
                                                @can('delete', $group)
                                                    <a href="" class="btn btn-danger">
                                                        Удалить
                                                    </a>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                    
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if($groups instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="d-flex justify-content-center mt-4">
                            {{ $groups->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>