@props([
    'name',
    'type' => 'text',
    'wire_model',
    'span' => 6,
])
<div class="col-md-{{ $span }}">
    <label for="{{ $name }}" class="form-label">@lang("forms.$name")</label>
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
            required
        />
        @error($wire_model)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
