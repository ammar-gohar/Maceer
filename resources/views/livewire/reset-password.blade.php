<form wire:submit='reset_password()' class="px-3">
    <h5 class="fs-5">@lang('forms.reset_password'):</h5>
    <x-form-input name="password" wire_model="password" span="12" required="required" />
    <x-form-input name="new_password" wire_model="new_password" span="12" required="required" />
    <x-form-input name="new_password_confirmation" wire_model="new_password_confirmation" span="12" required="required" />
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li class="text-danger">{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <button class="mt-3 btn btn-dark">
        @lang('forms.reset_password')
    </button>
</form>
