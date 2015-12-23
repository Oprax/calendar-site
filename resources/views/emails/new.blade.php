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
                                    Nouvelle Réservation
                                </td>
                            </tr>
                            <tr>
                                <td height="30" style="font-size:30px;line-height:30px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="center" style="font-family:Helvetica,sans-serif;mso-line-height-rule:exactly;text-align:center;line-height:40px;color:#333333;">
                                    Une réservation vient d'être effectuée par {{ $name }} {{ $forename }}.
                                </td>
                            </tr>
                            <tr>
                                <td height="30" style="font-size:30px;line-height:30px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="center" style="font-family:Helvetica,sans-serif;mso-line-height-rule:exactly;text-align:center;line-height:40px;color:#333333;">
                                    <div><!--[if mso]>
                                      <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{ route('reservation.edit', compact('id')) }}" style="height:36px;v-text-anchor:middle;width:200px;" arcsize="56%" strokecolor="#adadad" fillcolor="#fafafb">
                                        <w:anchorlock/>
                                        <center style="color:#2f353e;font-family:sans-serif;font-size:13px;font-weight:bold;">Voir la Réservation</center>
                                      </v:roundrect>
                                    <![endif]--><a href="{{ route('reservation.edit', compact('id')) }}"
                                    style="background-color:#fafafb;border:1px solid #adadad;border-radius:20px;color:#2f353e;display:inline-block;font-family:sans-serif;font-size:13px;font-weight:bold;line-height:36px;text-align:center;text-decoration:none;width:200px;-webkit-text-size-adjust:none;mso-hide:all;">Voir la Réservation</a>
                                    </div>
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