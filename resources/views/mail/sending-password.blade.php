<x-mail::message>
# حسابك في مَسِير

<div dir="rtl">
مرحبًا، {{ $name }}
حسابك في مَسِير جاهز الآن بكلمة مرور <span style="background: lightgray; padding: 0.25rem 0.5rem; white-space: nowrap;">{{ $password }}</span>.
عند تسجيلك للدخول ستتمكن من تغيير كلمة السر كما تشاء!

شكرًا,<br>
مَسِير
</div>

<hr style="margin: 0 32px;"/>

<div dir="ltr">
    # Your Maceer account

    Hello, {{ $name }}
    Your Macceer account on is now ready with password <span style="background: lightgray; padding: 0.25rem 0.5rem; white-space: nowrap;">{{ $password }}</span>.
    Once you login you can change your password as you wish!

    Thanks,<br>
    {{ config('app.name') }}
</div>

</x-mail::message>
