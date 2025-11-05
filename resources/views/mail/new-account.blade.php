<x-mail::message>
    # A Warm Welcome to [Your App Name]!

    Hello **{{ $recipientName }}**,

    We're delighted to let you know that your account as a **{{ $accountType }}** has been set up! You now have full access to [Your App Name] and all the features designed to make your experience smooth and easy.

    To get started, please use the temporary credentials below to log in:

    **Your Login Email:** {{ $email }}
    **Temporary Password:** {{ $tempPassword }}

    **Quick Tip:** For your security, please **change this temporary password** immediately after your first successful login.

    Ready to jump in? Click the button below to head straight to the login page:

    <x-mail::button :url="$loginUrl">
        Start Using [Your App Name]
    </x-mail::button>

    We're truly excited to have you join our community! If anything comes up, please don't hesitate to reach out to the administrator.

    Thanks and welcome aboard,<br>
    The Team at {{ config('app.name') }}
</x-mail::message>
