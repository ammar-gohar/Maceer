@props([
    'title' => '',
])
<x-layouts.app title="{{ $title }}" >
    <div class="container p-5 mx-auto shadow to-print" style="font-size: 1.25rem; position: relative;">
        <div style="position: absolute; top: 10px; left: 10px; font-size: 14px;" id="waterMark">
            <img src="{{ asset('logo.png') }}" alt="logo" style="width: 50px;" class="me-1">|<span class="ms-1">{{ now() }}</span>
        </div>
        <div id="printButton">
            <button type="button" class="mb-5 btn btn-dark" onclick="window.print()">
                <i class="fa-solid fa-print"></i> {{ App::isLocale('ar') ? 'طباعة' : 'Print' }}
            </button>
        </div>
        <div class="mb-1 row" id="reportHeader">
            <div class="col-1">
            </div>
            <div class="text-center col-3">
                <img src="{{ asset('images/menoufia-logo.png') }}" alt="favicon" style="width: 120px;" class="mx-auto">
            </div>
            <div class="col-4">
            </div>
            <div class="text-center col-3">
                <img src="{{ asset('images/enginerring-logo.png') }}" alt="favicon" style="width: 120px;" class="mx-auto">
            </div>
            <div class="col-1">
            </div>
        </div>

        <div class="row containter" id="reportBody">

            {{ $slot }}

        </div>

    </div>
    @push('styles')
        <style>
            @media print{

                .to-print {
                    width: 100% !important;
                    box-shadow: none !important;
                    font-size: 1rem !important;
                    padding: 3rem 1rem !important;
                    height: 100%;
                }
                .to-print table {
                    width: 90% !important;
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
