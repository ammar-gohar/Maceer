<x-mail::message>
# Order Shipped

Hello, {{ $name }}
Your account on Schoolary is now ready with passord <span style="background: lightgray; padding: 0.25rem 0.5rem;">{{ $password }}</span>.
Once you login you can change your password as you wish!

{{-- <x-mail::button :url="$url">
View Order
</x-mail::button> --}}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
