@include('emails.style')
<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
    <tr>
        <td align="center" valign="top">
            <table border="0" cellpadding="20" cellspacing="0" width="600" id="emailContainer">
                <tr>
                    <td valign="top">
                        Dear {{ $firstName }},
                        <br>
                        <p>
                            We received your request submitted at the Forgot Password form online.
                            If you did not request to retrieve a password, please ignore this email.
                        </p>
                        <br>
                        <p>
                            To generate a new password, please follow the link below.
                        </p>
                        <a href="{{array_get($data, 'link') }}">{{array_get($data, 'link') }}</a>
                        <p>
                            Please note, the link expires in 24 hours.
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