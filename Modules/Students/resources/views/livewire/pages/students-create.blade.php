<div class="px-4 mx-auto my-4 card card-secondary card-outline" style="width: 90%;">
    <!--begin::Header-->
    <div class="card-header">
        <div class="card-title">@lang('forms.add_student')</div>
    </div>
    <!--end::Header-->
    @if ($status)
        <div class="alert alert-success" role="alert">
            Student added successfully!
        </div>
    @endif
    <!--begin::Form-->
    <form wire:submit='create_student()'>
        @csrf
      <!--begin::Body-->
      <div class="card-body">
        <!--begin::Row-->
        <div class="row g-3">
          <!--begin::Col-->
          <div class="col-md-4">
            <label for="firstName" class="form-label">@lang('forms.first_name')</label>
            <input
              type="text"
              class="form-control"
              id="firstName"
              value="{{ old('first_name') }}"
              name="first_name"
              wire:model='form.first_name'
              required
            />
            @error('form.first_name')
                <span class="text-danger">* {{ $message }}</span>
            @enderror
          </div>
          <!--end::Col-->
          <!--begin::Col-->
          <div class="col-md-4">
            <label for="middleName" class="form-label">@lang('forms.middle_name')</label>
            <input
              type="text"
              class="form-control"
              id="middleName"
              value="{{ old('middle_name') }}"
              name="middle_name"
              wire:model='form.middle_name'
              required
            />
            @error('form.middle_name')
                <span class="text-danger">* {{ $message }}</span>
            @enderror
          </div>
          <!--end::Col-->
          <!--begin::Col-->
          <div class="col-md-4">
            <label for="lastName" class="form-label">@lang('forms.last_name')</label>
            <input
              type="text"
              class="form-control"
              id="lastName"
              value="{{ old('last_name') }}"
              name="last_name"
              wire:model='form.last_name'
              required
            />
            @error('form.last_name')
                <span class="text-danger">* {{ $message }}</span>
            @enderror
          </div>
          <!--end::Col-->
          <!--begin::Col-->
          <div class="col-md-6">
            <label for="nationalID" class="form-label">@lang('forms.national_id')</label>
              <input
                type="text"
                class="form-control"
                id="nationalID"
                value="{{ old('national_id') }}"
                name="national_id"
                wire:model='form.national_id'
                required
              />
              @error('form.national_id')
                <span class="text-danger">* {{ $message }}</span>
            @enderror
          </div>
          <!--end::Col-->
          <!--begin::Col-->
          <div class="col-md-6">
            <label for="phone" class="form-label">@lang('forms.phone')</label>
            <div class="input-group">
              <input
                type="text"
                class="form-control"
                id="phone"
                value="{{ old('phone') }}"
                name="phone"
                wire:model='form.phone'
                required
              />
              @error('form.phone')
                <span class="text-danger">* {{ $message }}</span>
            @enderror
            </div>
          </div>
          <!--end::Col-->
          <!--begin::Col-->
          <div class="col-md-6">
            <label for="email" class="form-label">@lang('forms.email')</label>
            <div class="input-group">
                <span class="input-group-text" id="basic-addon1">@</span>
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  name="email"
                  value="{{ old('email') }}"
                  wire:model='form.email'
                  required
                />
            </div>
            @error('form.email')
                <span class="text-danger">* {{ $message }}</span>
            @enderror
          </div>
          <!--end::Col-->
          <!--begin::Col-->
          <div class="col-md-6">
            <label for="validationCustom04" class="form-label">@lang('forms.gender')</label>
            <div class="d-flex input-group justify-content-evenly">
                <div class="d-flex">
                    <input type="radio" name="gender" id="genderM" class="me-2" value="m" {{ old('gender') == 'm' ? 'checked' : '' }} wire:model.live='form.gender'>
                    <label for="genderM" class="form-label">@lang('forms.male')</label>
                </div>
                <div class="d-flex">
                    <input type="radio" name="gender" id="genderF" value="f" class="me-2" {{ old('gender') == 'f' ? 'checked' : '' }} wire:model.live='form.gender'>
                    <label for="genderF" class="form-label">@lang('forms.female')</label>
                </div>
            </div>
            @error('form.gender')
                <span class="text-danger">* {{ $message }}</span>
            @enderror
          </div>
          <!--end::Col-->
        <!--end::Row-->
      </div>
      <!--end::Body-->
      <!--begin::Footer-->
      <div class="mt-3 card-footer">
        <button class="btn btn-dark" type="submit">@lang('forms.create')</button>
      </div>
      <!--end::Footer-->
    </form>
    <!--end::Form-->
</div>
