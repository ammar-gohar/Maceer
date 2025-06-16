<x-mail::message>
# Your Maceer account

Hello, {{ $name }}
Your account on Maceer is now ready with password <span style="background: lightgray; padding: 0.25rem 0.5rem;">{{ $password }}</span>.
Once you login you can change your password as you wish!

{{-- <x-mail::button :url="$url">
View Order
</x-mail::button> --}}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
