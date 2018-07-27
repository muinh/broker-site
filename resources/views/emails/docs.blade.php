<style>
    body { font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; }
    #emailBody tr > td { vertical-align: top; background: #e2e2e2; }
    #emailBody tr:nth-child(2n) > td { background: #efefef; }
</style>
<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
    <tr>
        <td align="center" valign="top">
            <table border="0" cellpadding="20" cellspacing="0" width="600" id="emailContainer">
                <tr>
                    <td align="center" valign="top">
                        <table border="0" cellpadding="20" cellspacing="0" width="100%" id="emailHeader">
                            <tr>
                                <td align="center" valign="top">
                                    <h3>Customer sent the documents</h3>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center" valign="top">
                        <table border="0" cellpadding="10" cellspacing="0" width="100%" id="emailBody">
                            <tr><td align="right">CID</td><td><strong>{{ array_get($data, 'id') }}</strong></td></tr>
                            <tr><td align="right">First Name</td><td><strong>{{ array_get($data, 'FirstName') }}</strong></td></tr>
                            <tr><td align="right">Last Name</td><td><strong>{{ array_get($data, 'LastName') }}</strong></td></tr>
                            <tr><td align="right">Passport</td><td><img src="{{ $message->embed(array_get($data, 'passport')->getRealPath()) }}" style="display: block;max-width:200px; margin:0 auto;"></td></tr>
                            <tr><td align="right">Credit Card Front</td><td><img src="{{ $message->embed(array_get($data, 'creditCardFront')->getRealPath()) }}" style="display: block;max-width:200px; margin:0 auto;"></td></tr>
                            <tr><td align="right">Credit Card Back</td><td><img src="{{ $message->embed(array_get($data, 'creditCardBack')->getRealPath()) }}" style="display: block;max-width:200px; margin:0 auto;"></td></tr>
                            <tr><td align="right">Utility Bill</td><td><img src="{{ $message->embed(array_get($data, 'utilityBill')->getRealPath()) }}" style="display: block;max-width:200px; margin:0 auto;"></td></tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>