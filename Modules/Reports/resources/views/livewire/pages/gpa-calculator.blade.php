<x-page module="reports" title="modules.reports.gpa_calculator" >

    <div class="card-body">

        <div class="row">
            <div class="col-md-6">
                <label for="currentGpa" class="mt-2 form-label">@lang("modules.students.current_gpa") *</label>
                <div class="input-group">
                    <input
                        id="currentGpa"
                        type="number"
                        step="0.01"
                        min="0"
                        max="4"
                        class="form-control"
                        name="currentGpa"
                        placeholder="{{ App::isLocale('ar') ? 'مثال: 3.5' : 'example: 3.5' }}"
                    />
                </div>
            </div>

            <div class="col-md-6">
                <label for="currentHours" class="mt-2 form-label">@lang("modules.students.total_earned_credits") *</label>
                <div class="input-group">
                    <input
                        id="currentHours"
                        type="number"
                        min="0"
                        max="180"
                        class="form-control"
                        name="currentHours"
                        placeholder="{{ App::isLocale('ar') ? 'مثال: 60' : 'example: 60' }}"
                    />
                </div>
            </div>

            <div class="col-md-6">
                <label for="targetGpa" class="mt-2 form-label">@lang("modules.students.target_gpa") *</label>
                <div class="input-group">
                    <input
                        id="targetGpa"
                        type="number"
                        step="0.01"
                        min="0"
                        max="4"
                        class="form-control"
                        name="targetGpa"
                        placeholder="{{ App::isLocale('ar') ? 'مثال: 3.5' : 'example: 3.5' }}"
                    />
                </div>
            </div>
        </div>

        <!--begin::Col-->
        <div class="col-md-12" id="semesters">
            <label class="form-label">{{ App::isLocale('ar') ? 'الفصول المتبقية' : 'Remaining semesters' }}</label>
            <div id="semesterList">
            </div>
            <button type="button" class="mt-3 btn btn-dark btn-sm" onclick="addSemester('{{ App::isLocale('ar') ? 'عدد ساعات الفصل الدراسي' : 'Semester credits' }}')">
                <i class="bi bi-plus-circle"></i> {{ App::isLocale('ar') ? 'إضافة فصل دراسي' : 'Add semester' }}
            </button>
        </div>
        <!--end::Col-->

        <div id="result">
        </div>

    </div>

    <div class="card-footer">
        <button class="btn btn-dark" onclick="calculateGpa()">
            {{ App::isLocale('ar') ? 'احسب' : 'Calculate' }}
        </button>
    </div>

</x-page>
@push('scripts')
    <script src="{{ asset("js/GPA.js") }}"></script>
@endpush
