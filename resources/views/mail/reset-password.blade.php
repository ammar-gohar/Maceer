<x-mail::message>
# تغيير كلمة المرور

<p dir="rtl">
مرحبًا، {{ $name }}
لقد تغيرت كلمة المرور الخاصة بك بنجاح في {{ $date }}، لتصبح:<span dir="ltr" style="background: lightgray; padding: 0.25rem 0.5rem; white-space: nowrap;">{{ $password }}</span>.
عند تسجيلك للدخول ستتمكن من تغيير كلمة السر كما تشاء!

شكرًا,<br />
مَسِير
</p>

<hr style="margin: 0 32px;"/>

# Your Maceer account

<p dir="ltr">
Hello, {{ $name }}
Your pssword has been reset successfully at {{ $date }} to be <span dir="ltr" style="background: lightgray; padding: 0.25rem 0.5rem; white-space: nowrap;">{{ $password }}</span>.
Once you login you can change your password as you wish!

Thanks,<br />
{{ config('app.name') }}
</p>

</x-mail::message>
