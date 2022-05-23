<!DOCTYPE html>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<style type="text/css">
    /* FONTS */
    @import url('https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i');

    /* CLIENT-SPECIFIC STYLES */
    body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
    table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
    img { -ms-interpolation-mode: bicubic; }

    /* RESET STYLES */
    img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
    table { border-collapse: collapse !important; }
    body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }

    /* iOS BLUE LINKS */
    a[x-apple-data-detectors] {
        color: inherit !important;
        text-decoration: none !important;
        font-size: inherit !important;
        font-family: inherit !important;
        font-weight: inherit !important;
        line-height: inherit !important;
    }

    /* MOBILE STYLES */
    @media screen and (max-width:600px){
        h1 {
            font-size: 32px !important;
            line-height: 32px !important;
        }
    }

    /* ANDROID CENTER FIX */
    div[style*="margin: 16px 0;"] { margin: 0 !important; }
</style>
</head>
<body style="background-color: #f3f5f7; margin: 0 !important; padding: 0 !important;">

<!-- HIDDEN PREHEADER TEXT -->
<div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: 'Poppins', sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">
</div>

<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <!-- LOGO -->
    <tr>
        <td align="center">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
            <tr>
            <td align="center" valign="top" width="600">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                <tr>
                    <td align="center" valign="top" style="padding: 40px 10px 10px 10px;">
                        <a href="#" target="_blank" style="text-decoration: none;">
							<span style="display: block; font-family: 'Poppins', sans-serif; color: #3e8ef7; font-size: 36px;" border="0"></span>
                        </a>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <!-- HERO -->
    <tr>
        <td align="center" style="padding: 0px 10px 0px 10px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
            <tr>
            <td align="center" valign="top" width="600">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                <tr>
                    <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px;">
                      <h1 style="font-size: 36px; font-weight: 600; margin: 0; font-family: 'Poppins', sans-serif;color:#0bb2d4">Cher <?php echo $_REQUEST["name"];?>!</h1>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <!-- COPY BLOCK -->
    <tr>
        <td align="center" style="padding: 0px 10px 0px 10px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
            <tr>
            <td align="center" valign="top" width="600">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
              <!-- COPY -->
              <?php if ($_REQUEST["message"]=="TicketCreations"){?>
              <tr>
                <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 20px 30px; color: #666666; font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 400; line-height: 23px;">
                  <p style="margin: 0;">Nous tenons à vous confirmer que nous avons bien reçu votre demande et qu'un ticket a été créé.
                Un représentant de l'assistance examinera votre demande et vous enverra une réponse (généralement dans les 24 heures).

               </p><br>
               <p style="margin:0";> Pour voir le statut du ticket ou ajouter des commentaires, veuillez visiter : </p>
               
               <br>
               

               <p style="margin:0";> <a href="<?php echo $_REQUEST['lien']."&source=client";?>" target="_blank" style="color:red"><?php echo $_REQUEST['lien'];?></a></p>
                </td>
              </tr>
              <?php } else {?>


                <tr>
                <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 20px 30px; color: #666666; font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 400; line-height: 23px;">
                <p style="margin: 0;">Il y a une nouvelle réponse sur votre ticket. Vous pouvez voir votre ticket en visitant : </p>
                
                <br>

                <a href="<?php echo $_REQUEST['url'];?>" target="_blank" style="color:red;font-size:10px"><?php echo $_REQUEST['url'];?></a>

                </td>
              </tr>


                <?php }?>
                <?php if ($_REQUEST["message"]=="TicketReply"){?>
                    
                <tr>
                <td bgcolor="#ffffff" align="left" style="padding: 10px 30px 20px 30px; color: #666666; font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 400; line-height: 25px;">
                <p style="margin: 0;font-size:14px"><b>Commentaire du ticket</b></p><br>
                <p style="margin: 0;"><a style="font-size:12px;font-family:Poppins,Arial,sans-serif;;text-decoration:none;background-color:#c49e36;color:#fefefe;padding: 5px 5px; border-radius: 2px;border-radius: 3px 3px 3px 3px;"><?php echo $_REQUEST['commenter'];?></a> -<a style="text-decoration:none;color:#462be2;font-style:italic"><?php echo $_REQUEST['body'];?></a></p>

                </td>
              </tr>


    <?php }?>


    
              <!-- BULLETPROOF BUTTON -->
              <!--tr>
                <td bgcolor="#ffffff" align="center">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td bgcolor="#ffffff" align="center" style="padding: 20px 30px 30px 30px;">
                        <table border="0" cellspacing="0" cellpadding="0">
                          <tr>
                              <td align="center" style="border-radius: 3px;" bgcolor="#0bb2d4"><a href="#" target="_blank" style="font-size: 18px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 12px 50px; border-radius: 2px; border: 1px solid #0bb2d4; display: inline-block;">My Account</a></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </!--tr-->
              <!-- COPY -->
              <?php if ($_REQUEST["message"]=="TicketCreations"){?>

              <tr>
                <td bgcolor="#ffffff" align="left" style="padding: 10px 30px 20px 30px; color: #666666; font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 400; line-height: 25px;">
                  <p style="margin: 0;">
                  Merci pour votre patience.</p>
                </td>
              </tr>
              <?php }?>

              <!-- COPY -->
              <tr>
                <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 10px 30px; border-radius: 0px 0px 0px 0px; color: #666666; font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 400; line-height: 25px;">
                  <p style="margin: 0;">Sincèrement,<br>Desk Hosteur, Équipe d'assistance</p>
                </td>
              </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <!-- FOOTER -->
    <tr>
        <td align="center" style="padding: 10px 10px 50px 10px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
            <tr>
            <td align="center" valign="top" width="600">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" bgcolor="#0bb2d4">
              <!-- NAVIGATION -->
            
              <!-- ADDRESS -->
              <tr>
                <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 30px 30px; color: #aaaaaa; font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 400; line-height: 18px;">
                  <p style="margin: 0;">DESK HOSTEUR - Route du Lac Lussy 201, 1618 Châtel-Saint-Denis, SUISSE</p>
                </td>
              </tr>
		      <!-- COPYRIGHT -->
              <tr>
                <td align="center" style="padding: 30px 30px 30px 30px; color: #333333; font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 400; line-height: 18px;">
                  <p style="margin: 0;">Copyright ©<?php echo date('Y');?> Desk Hosteur. Tous les droits sont réservés.</p>
                </td>
              </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
</table>

</body>
</html>
