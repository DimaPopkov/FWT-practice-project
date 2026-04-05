<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Выставить оценку') }}
        </h2>
    </x-slot>

    <form action="{{ route('grades.store', $student) }}" method="POST">
        @include('grades.form')
    </form>
    @if ($errors->any())
        <div class="alert alert-danger" style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 20px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</x-app-layout>