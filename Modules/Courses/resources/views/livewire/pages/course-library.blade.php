<div class="px-4 mx-auto my-4 card card-dark card-outline" style="width: 90%;">
    <!--begin::Header-->
    <div class="px-4 card-header row">
        <div class="card-title d-flex align-items-center fs-4 fw-bold">@lang('modules.courses.library.index', ['course' => App::isLocale('ar') ? $course->name_ar : $course->name])</div>
    </div>
    @can('library.create')
        <div
            class="px-4 card-header row"
            x-data="{ progress: 0 }"
            x-on:livewire-upload-start="progress = 0"
            x-on:livewire-upload-progress="progress = $event.detail.progress"
            x-on:livewire-upload-finish="progress = 100"
            x-on:livewire-upload-error="progress = 0"
        >
            <div class="gap-2 mb-2 d-flex align-items-center">

                <!-- Buttons -->
                <div class="btn-group" role="group">
                    <!-- File Picker -->
                    <label class="mb-0 btn btn-success">
                        <i class="bi bi-plus-circle"></i> @lang('modules.courses.library.add')
                        <input type="file" wire:model="files" class="d-none" multiple>
                    </label>

                    <!-- Upload Button -->
                    <button
                        class="btn btn-primary"
                        wire:click="startUpload"
                        wire:loading.attr="disabled"
                        wire:target="files,startUpload"
                        @if (count($files) === 0) disabled @endif
                    >
                        <i class="bi bi-upload"></i> @lang('modules.courses.library.upload')
                    </button>
                </div>

                <!-- Progress Bar -->
                <div class="flex-grow-1">
                    <template x-if="progress > 0">
                        <div class="progress" style="height: 20px;">
                            <div
                                class="progress-bar"
                                role="progressbar"
                                :style="`width: ${progress}%`"
                                x-text="`${progress}%`"
                                aria-valuemin="0"
                                aria-valuemax="100"
                            ></div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- File Previews -->
            @if ($files)
                <div class="mt-3 row">
                    @foreach ($files as $index => $file)
                        <div class="mb-3 col-md-3" wire:click="removeFile({{ $index }})" style="cursor: pointer;">
                            @if (str_starts_with($file->getMimeType(), 'image/'))
                                <img src="{{ $file->temporaryUrl() }}" class="border rounded img-fluid" style="max-height: 150px;">
                            @else
                                <div class="p-2 text-center border rounded bg-light small">
                                    <i class="bi bi-file-earmark"></i><br>
                                    {{ $file->getClientOriginalName() }}
                                </div>
                            @endif
                            <div class="mt-1 text-center text-danger small">
                                    @lang('modules.courses.library.click_to_remove')</div>
                            </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endcan
    <!--end::Header-->

    <div class="card-body" style="overflow-x: scroll;">
        <div class="container">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                @foreach($course->media as $file)
                    <div class="col">
                        <div class="shadow-sm card">
                            @if(str_starts_with($file->mime_type, 'image/'))
                                <img src="{{ $file->getUrl() }}" class="card-img-top" alt="{{ $file->name }}">
                            @else
                                <div class="py-4 text-center">
                                    <i class="bi bi-file-earmark fs-1"></i>
                                </div>
                            @endif

                            <div class="card-body">
                                <h5 class="mb-2 card-title text-truncate" title="{{ $file->name }}" style="float: none;">
                                    {{ $file->name }}
                                </h5>

                                <p class="mb-3">
                                    {{ $file->updated_at->diffForHumans() }}
                                </p>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="gap-2 d-flex">
                                        <a href="{{ $file->getUrl() }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ $file->getUrl() }}" target="_blank" class="btn btn-outline-dark btn-sm" download>
                                            <i class="bi bi-download"></i>
                                        </a>
                                    </div>

                                    <small class="text-muted">
                                        @php
                                            $size = number_format($file->size / 1024 / 1024, 2);
                                            if($size < 0) {
                                                $size = [
                                                    $size,
                                                    App::isLocale('ar') ? 'ميجابايت' : 'MB',
                                                ];
                                            } else {
                                                $size = [
                                                    number_format($file->size / 1024, 2),
                                                    App::isLocale('ar') ? 'كيلوبايت' : 'KB',
                                                ];
                                            };
                                        @endphp
                                        {{ "$size[0] $size[1]" }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:load', () => {
            Livewire.on('livewire-upload-progress', progress => {
                const rounded = Math.floor(progress / 20) * 20;
                Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id')).set('progress', rounded);
            });
        });
    </script>
@endpush
