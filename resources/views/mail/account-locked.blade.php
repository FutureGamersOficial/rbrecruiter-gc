@component('mail::message')
# Hi {{ $name }},

We wanted to let you know that your account at {{ config('app.name') }} has been locked due to security concerns. Don't worry! You haven't been suspended! We lock accounts for a number of reasons, including, but not limited to:

 - Suspicious activity was detected;
 - You failed to activate 2FA within the required timeframe;
 - Your password was detected on a 3rd party security breach;
 - You started an account deletion request;
 - Your password expired.

Please note that your account may be locked for reasons other than those listed above; If you think this was an error, please let us know, but keep in mind that this is an automated process and we can't manually unlock accounts. You will not be able to sign in or use the app while your account is locked.

Usually, you will receive another email with more information regarding your specific circumstances.

Thank you,<br>
The team at {{ config('app.name') }}
@endcomponent
