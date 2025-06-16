<div class="px-4 mx-auto my-4 card card-dark card-outline" style="width: 90%;">
    <!--begin::Header-->
    <div class="px-4 card-header row">
        <div class="card-title d-flex align-items-center fs-4 fw-bold">@lang('modules.courses.library.index', ['course' => App::isLocale('ar') ? $course->name_ar : $course->name])</div>
    </div>
    @can('library.create')
        <div class="px-4 card-header row">
            <div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="btn-group" role="group">

                        <label class="btn btn-success mb-0">
                            <i class="bi bi-plus-circle"></i> @lang('modules.courses.library.add')
                            <input type="file" wire:model="file" class="d-none" />
                        </label>

                        <button class="btn btn-primary" wire:click="startUpload" @if(!$file) disabled @endif>
                            <i class="bi bi-upload"></i> @lang('modules.courses.library.upload')
                        </button>

                        <button class="btn btn-warning text-dark" wire:click="cancelUpload">
                            <i class="bi bi-x-circle"></i> @lang('modules.courses.library.cancel')
                        </button>
                        {{ $file }}
                    </div>

                    <div class="flex-grow-1">
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar" role="progressbar"
                                style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}"
                                aria-valuemin="0" aria-valuemax="100">
                                {{ $progress }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
    <!--end::Header-->

    <div class="card-body" style="overflow-x: scroll;">
        <div class="container">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                @foreach($course->media as $file)
                    <div class="col">
                        <div class="card shadow-sm">
                            @if(str_starts_with($file->mime_type, 'image/'))
                                <img src="{{ $file->getUrl() }}" class="card-img-top" alt="{{ $file->name }}">
                            @else
                                <div class="text-center py-4">
                                    <i class="bi bi-file-earmark fs-1"></i>
                                </div>
                            @endif

                            <div class="card-body">
                                <h5 class="card-title text-truncate mb-2" title="{{ $file->name }}" style="float: none;">
                                    {{ $file->name }}
                                </h5>

                                <p class="mb-3">
                                    {{ $file->updated_at->diffForHumans() }}
                                </p>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex gap-2">
                                        <a href="{{ $file->getUrl() }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <button wire:click="download({{ $file->id }})" class="btn btn-outline-success btn-sm">
                                            <i class="bi bi-download"></i>
                                        </button>
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

<script>
    document.addEventListener('livewire:load', () => {
        Livewire.on('upload:progress', event => {
            @this.set('progress', event.detail.progress);
        });

        Livewire.on('upload:finish', () => {
            @this.set('progress', 100);
        });

        Livewire.on('upload:error', () => {
            @this.set('progress', 0);
        });

        Livewire.on('upload:started', () => {
            @this.set('progress', 1);
        });
    });
</script>
