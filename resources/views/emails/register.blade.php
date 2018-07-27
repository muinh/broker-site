@include('emails.style')

<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
    <tr>
        <td align="center" valign="top">
            <table border="0" cellpadding="20" cellspacing="0" width="600" id="emailContainer">
                <tr>
                    <td valign="top">
                        Dear {{ $firstName }},
                        <h3>Welcome to {{ env('SITE_NAME') }}™!</h3>
                        <p>
                            You have successfully registered.
                        </p>
                        <p>
                            To activate your trading account, please proceed to the deposit page.
                        </p>
                        <p>
                            Please consult our <a href="{{secure_url('/faq')}}">FAQ (frequently asked questions)</a> section if you have any
                            questions
                            regarding your {{ env('SITE_NAME') }}™ Trading Account.
                        </p>
                        <br>
                        <br>
                        <br>
                        @include('emails.footer')
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
