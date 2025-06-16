<x-layouts.app title="{{ __('forms.pasword.email') }} | Maceer" >

    <div class="login-page bg-body-dark">

        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="mx-2">@lang('general.lang')</span><i class="bi bi-globe2"></i>
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item @if(App::isLocale('ar')) bg-secondary-subtle @endif" href="/language/ar">العربية</a>
                </li>
                <li>
                    <a class="dropdown-item @if(App::isLocale('en')) bg-secondary-subtle @endif" href="/language/en">English</a>
                </li>
            </ul>
        </div>

        <div class="login-box" style="width:500px;">
            <div class="card card-outline card-dark">
                <div class="card-header">
                    <h1 class="mb-0 text-center"><b>Maceer</h1>
                </div>
                <div class="card-body login-card-body">
                    <p class="">@lang('general.passwords.reset')</p>
                    <form action="{{ route('password.email') }}" method="post">
                        @csrf
                        <div class="input-group">
                            <div class="form-floating">
                                <input id="email" type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="" autofocus autocomplete="email"/>
                                <label for="email">@lang('forms.email')</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-envelope"></span></div>
                        </div>
                        @error('email')
                            <p class="text-danger">* {{ $message }}</p>
                        @enderror
                        <!--begin::Row-->
                        <div class="mt-3 row">
                            <div class="col-4">
                                <div class="gap-2 d-grid">
                                <button type="submit" class="btn btn-dark">@lang('forms.passwords.send_email')</button>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!--end::Row-->
                    </form>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
        <!-- /.login-box -->
        <!--begin::Third Party Plugin(OverlayScrollbars)-->
        <script
        src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
        integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
        crossorigin="anonymous"
        ></script>
        <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
        <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"
        ></script>
        <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
        <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"
        ></script>
        <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
        <script src="../../../dist/js/adminlte.js"></script>
        <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    </div>

</x-layouts.app>
