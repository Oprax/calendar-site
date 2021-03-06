<?php $message->subject('Réservation Montesquieu'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns:v="urn:schemas-microsoft-com:vml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <table bgcolor="#FFFFFF" width="100%" border="0" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td>
                    <table align="center" width="590" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td height="30" style="font-size:30px;line-height:30px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">
                                    <a href="{{ route('welcome') }}">
                                        <img src="{{ route('welcome') }}/static/img/favicon.png" width="75" border="0" alt="Logo">
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td height="30" style="font-size:30px;line-height:30px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="center" style="font-family:Helvetica,sans-serif;mso-line-height-rule:exactly;text-align:center;font-size:40px;line-height:28px;color:#333333;">
                                    Réservation pour Montesquieu
                                </td>
                            </tr>
                            <tr>
                                <td height="30" style="font-size:30px;line-height:30px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="center" style="font-family:Helvetica,sans-serif;mso-line-height-rule:exactly;text-align:center;line-height:40px;color:#333333;">
                                    Bonjour {{ $name }} {{ $forename }}, votre réservation du {{ $arrive_at }} au {{ $leave_at }} a été refusé.
                                </td>
                            </tr>
                            <tr>
                                <td height="30" style="font-size:30px;line-height:30px;">&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>