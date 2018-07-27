@include('emails.style')

<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
    <tr>
        <td align="center" valign="top">
            <table border="0" cellpadding="20" cellspacing="0" width="600" id="emailContainer">
                <tr>
                    <td valign="top">
                        Dear {{ $firstName }},
                        <p>
                            You have successfully deposited {{$depositAmount}}.
                        </p>
                        <p>
                            To start trading, please proceed to the Trading Platform or schedule a free consultation call
                            with one of our analysts.
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
