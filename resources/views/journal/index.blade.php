@extends('layouts.app')

@section('content')
<div class="container">
    <div>    
        <h2>Журнал оценок</h2>
        
        @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
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
                                <td>{{ $student->fio }}</td>
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
                Студенты не найдены
            </div>
        @endif
    </div>

    <div class="table-responsive">
        <h2>Показатели групп по предметам</h2>
        <table class="table table-bordered table-striped">
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

    <h2>Лучшие студенты</h2>
    <div class="row-container">
        <div>
            <h4> Студенты - отличники </h4>
            @foreach($bestStudents as $student)
                <p class="font24"> {{ $loop->iteration }}. {{ $student->fio }} </p>
            @endforeach
        </div>
        <div>
            <h4> Студенты - хорошисты </h4>
            @foreach($goodStudents as $student)
                <p class="font24"> {{ $loop->iteration }}. {{ $student->fio }} </p>
            @endforeach
        </div>
    </div>
</div>
@endsection 