<x-layouts.app title="{{ __('modules.reports.course-students', ['course' => $lang == 'ar' ? $enrollments->first()->course->name_ar : $enrollments->first()->course->name_ar, 'semester' => $semester->name], locale: $lang) }}" >
    <div class="container mx-auto shadow to-print" dir="{{ $lang == 'ar' ? 'rtl' : 'ltr' }}" style="font-size: 1.25rem; position: relative;">
        <div style="position: absolute; top: 10px; left: 10px; font-size: 14px;" id="waterMark">
            <img src="{{ asset('logo.png') }}" alt="logo" style="width: 50px;" class="me-1"> | <span class="ms-1">{{ now() }}</span>
        </div>
        <div id="printButton" class="p-5">
            <button type="button" class="btn btn-dark" onclick="window.print()">
                <i class="fa-solid fa-print"></i> @lang('modules.reports.print', locale: $lang)
            </button>
        </div>

        <div class="row containter" id="reportBody">
            <div class="p-2">
                <div class="row" style="font-size: 1rem">
                    <div class="mb-2 text-center col-md-12 fs-5">
                        <strong>{{ __('modules.reports.course-students', ['course' => $lang == 'ar' ? $enrollments->first()->course->name_ar : $enrollments->first()->course->name_ar, 'semester' => $semester->name], locale: $lang) }}</strong>
                    </div>
                </div>
                <div class="mb-3 row">
                    <!-- Student Info Table -->
                    <div class="mt-4 col-12">
                        <table class="table mb-4 table-bordered table-sm" style="font-size: 1rem;">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>@lang('modules.students.name', locale: $lang)</th>
                                    <th>@lang('modules.students.academic_number', locale: $lang)</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($enrollments as $enroll)
                                    <tr>
                                        <td style="width: 1%; white-space:nowrap;">{{ $loop->iteration }}</td>
                                        <td style="width: 1%; white-space:nowrap;">{{ $enroll->student->full_name }}</td>
                                        <td style="width: 1%; white-space:nowrap;">{{ $enroll->student->student->academic_number }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @push('styles')
        <style>
            @media print{

                .to-print {
                    width: 100% !important;
                    box-shadow: none !important;
                    font-size: 1rem !important;
                    padding-top: 3rem !important;
                    padding-bottom: 3rem !important;
                    height: 100%;
                }
                .to-print table {
                    /* width: 90% !important; */
                    margin: 0 auto !important;
                }
                #printButton {
                    display: none !important;
                }
            }
        </style>
    @endpush
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(() => {
                    window.print()
                }, 1000);;
            });
        </script>
    @endpush
</x-layouts.app>
