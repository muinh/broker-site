@include('emails.style')

<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
    <tr>
        <td align="center" valign="top">
            <table border="0" cellpadding="20" cellspacing="0" width="600" id="emailContainer">
                <tr>
                    <td valign="top">
                        Dear {{ $firstName }},
                        <p>
                            You have successfully submitted a withdrawal request for {{$withdrawalAmount}}.
                        </p>
                        <p>
                            To review the withdrawal policy, please visit <a href="{{secure_url('/terms-and-conditions')}}">Terms & Conditions</a>.
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
