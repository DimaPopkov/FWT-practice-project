@csrf
<div class="space-y-4">
    <div class="mb-3">    
        <label>Студент:</label>
        @if(isset($grade))
            {{-- берем студента из связи --}}
            <strong>{{ $grade->user->fio ?? $grade->user->name }}</strong>
            <input type="hidden" name="user_id" value="{{ $grade->user_id }}">
        @elseif(isset($student))
            {{-- режим создания для конкретного студента --}}
            <strong>{{ $student->fio ?? $student->name }}</strong>
            <input type="hidden" name="user_id" value="{{ $student->id }}">
        @else
            {{-- выпадающий список --}}
            <select name="user_id" class="form-control">
                @foreach($students as $s)
                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach
            </select>
        @endif
    </div>

    <div>
        <label class="block">Предмет</label>
        <select name="subject_id" class="w-full border rounded p-2">
            @foreach($subjects as $subject)
                <option value="{{ $subject->id }}" 
                    {{ (isset($grade) && $grade->subject_id == $subject->id) ? 'selected' : '' }}>
                    {{ $subject->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block">Оценка</label>
        <input type="number" name="grade" name="value" value="{{ old('grade', $grade ?? '') }}" 
            class="w-full border rounded p-2" min="1" max="100">
    </div>
    
    <button type="submit" class="btn btn-success btn_align mb-3">
        {{ isset($grade) ? 'Обновить' : 'Выставить' }}
    </button>
</div>