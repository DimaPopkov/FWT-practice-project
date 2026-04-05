@props(['name', 'label', 'options' => [], 'selected' => null])

<div class="form-group">
    <select 
        name="{{ $name }}" 
        id="{{ $name }}" 
        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
        {{ $attributes->merge(['class' => 'form-control']) }}
        
    >
        <option value="">Выберите группу...</option>
        @foreach($options as $value => $display)
            <option value="{{ $value }}" {{ $value == $selected ? 'selected' : '' }}>
                {{ $display }}
            </option>
        @endforeach
    </select>

    @error($name)
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>