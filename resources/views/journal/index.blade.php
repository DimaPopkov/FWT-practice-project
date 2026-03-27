<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Главная') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container">
                <div>       
                    @if($users->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped text-center">
                                <thead class="thead-dark">
                                    <tr>
                                        <th> Студент </th>
                                        <th> Дата рождения </th>
                                        <th> Группа </th>
                                        @foreach($subjects as $subject)
                                            <th> {{ $subject->name }} </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $student)
                                        <tr class="{{ $student->grade_class }}">
                                            <td>{{ $student->name }}</td>
                                            <td>{{ $student->formatted_birthday }}</td>
                                            <td>{{ $student->group->name ?? "Не указана" }}</td>
                                            
                                            @foreach($subjects as $subject)
                                                <td class="text-center">
                                                    {{ $gradesMap[$student->id][$subject->id] ?? "-" }}
                                                </td>
                                            @endforeach
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
                            Журнал не найден
                        </div>
                    @endif
                </div>

                <div class="table-responsive">
                    <p class="p-6 text-3xl leading-tight font-semibold text-center">Показатели групп по предметам</p>
                    <table class="table table-bordered table-striped text-center">
                        <thead class="thead-dark">
                            <tr>
                                <th>Группа</th>
                                @foreach($subjects as $subject)
                                    <th>{{ $subject->name }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($groups as $group)
                                <tr>
                                    <td>{{ $group->name }}</td>
                                    
                                    @foreach($subjects as $subject)
                                        <td class="text-center">
                                            @php
                                                $currentGroupStats = $groupsStats->get($group->id);
                                                
                                                $avgValue = $currentGroupStats ? $currentGroupStats->get($subject->id) : null;
                                            @endphp

                                            {{ $avgValue ?? '—' }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <h2 class="p-6 text-3xl leading-tight font-semibold text-center">Лучшие студенты</h2>
                <div class="flex justify-center column-gap-5">
                    <div class="text-center">
                        <h4 class="text-xl"> Студенты - отличники </h4>
                        @foreach($bestStudents as $student)
                            <p class="text-xl"> {{ $loop->iteration }}. {{ $student->name }} </p>
                        @endforeach
                    </div>
                    <div class="text-center">
                        <h4 class="text-xl"> Студенты - хорошисты </h4>
                        @foreach($goodStudents as $student)
                            <p class="text-xl"> {{ $loop->iteration }}. {{ $student->name }} </p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>