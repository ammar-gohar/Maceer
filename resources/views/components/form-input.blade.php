@props([
    'name',
    'type' => 'text',
    'wire_model',
    'span' => 6,
    'required' => 'required',
    'label' => true
])

<div class="col-md-{{ $span }}">
    @if ($label)
        <label for="{{ $name }}" class="mt-2 form-label">@lang("forms.$name") {{ $required ? '*' : '' }}</label>
    @endif
    <div class="input-group">
        @if ($type == "email")
            <span class="input-group-text" id="basic-addon1">@</span>
        @endif
        <input
            type="{{ $type }}"
            class="form-control @error($wire_model) is-invalid @enderror"
            id="{{ $name }}"
            value="{{ old($name) }}"
            name="{{ $name }}"
            wire:model.blur="{{ $wire_model }}"
            {{ $attributes }}
            {{ $required ?: '' }}
        />
        @error($wire_model)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
