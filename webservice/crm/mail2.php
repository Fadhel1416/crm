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
  img { border: 0; height: 80px; line-height: 100%; outline: none; text-decoration: none; }
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

            <td bgcolor="#ffffff" align="left" style="padding: 30px 0px 5px 30px;">
                  <a href="#" target="_blank">
                      <img alt="Product update video" src="https://yestravaux.com/crm2/images/yestravaux-capture.png" width="550" height="10" border="0">
                  </a>
                </td>
                 </tr>
                <tr>
                <?php if($_REQUEST['message']=="mdp"){?>

                    <td bgcolor="#ffffff" align="center" valign="top" style="padding: 10px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: 'Poppins', sans-serif; font-size: 48px; font-weight: 200; letter-spacing: 2px; line-height: 48px;">
                      <h5 style="font-size: 25px; font-weight: 200; margin: 0;color:#ff4c52"><b> Sécuriser votre compte</b></h5>
                    </td>
                    <?php }else if($_REQUEST['message']=="inscrit"){?>
                      <td bgcolor="#ffffff" align="center" valign="top" style="padding: 10px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: 'Poppins', sans-serif; font-size: 48px; font-weight: 200; letter-spacing: 2px; line-height: 48px;">
                      <h2 style="font-size: 25px; font-weight: 200; margin: 0;color:#0bb2d4"><b>Inscription</b></h2>
                    </td>
                    <?php }else if($_REQUEST['message']=="initPASS"){ ?>
                        <td bgcolor="#ffffff" align="center" valign="top" style="padding: 10px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: 'Poppins', sans-serif; font-size: 48px; font-weight: 200; letter-spacing: 2px; line-height: 48px;">
                      <h2 style="font-size: 25px; font-weight: 200; margin: 0;color:#ff4c52"><b>Réinitialisation mot de passe</b></h2>
                    </td>
                    <?php }else if($_REQUEST['message']=="sendtask"){ ?>
                        <td bgcolor="#ffffff" align="center" valign="top" style="padding: 10px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: 'Poppins', sans-serif; font-size: 48px; font-weight: 200; letter-spacing: 2px; line-height: 48px;">
                      <h2 style="font-size: 25px; font-weight: 200; margin: 0;color:#ff4c52"><b>Confirmations Task</b></h2>
                    </td>
                    <?php }else if($_REQUEST['message']=="TicketReply"){ ?>
                        <td bgcolor="#ffffff" align="center" valign="top" style="padding: 10px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: 'Poppins', sans-serif; font-size: 48px; font-weight: 200; letter-spacing: 2px; line-height: 48px;">
                      <h2 style="font-size: 25px; font-weight: 200; margin: 0;color:#ff4c52"><b>Retour a votre reclamations</b></h2>
                    </td>

                        <?php }?>
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
            
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
              <!-- COPY -->
              <?php if($_REQUEST['message']=="mdp"){?>

              <tr>
        
                  <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 5px 30px; color: #666666; font-family: 'Poppins', sans-serif; font-size: 16px; font-weight: 300; line-height: 25px;">
                  <p style="margin: 0;">Bonjour <?php echo $_REQUEST['name']; ?> ,</p>
                </td>
              </tr>
              <tr>
                <td bgcolor="#ffffff" align="left" style="padding: 5px 20px 20px 30px; color: #666666; font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 50; line-height: 25px;">
                  <p style="margin: 0;">une tentative de modifications de votre mot de passe a été détectée, est-ce que c'est bien vous ? ,S'il ne provient pas de votre côté , veuillez modifiez votre mot de passe pour renforcez la sécurite de votre compte.</p>
                </td>
              </tr>
              <!-- BULLETPROOF BUTTON -->
              <tr>
                <td bgcolor="#ffffff" align="left">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td bgcolor="#ffffff" align="center" style="padding: 20px 10px 60px 10px;">
                        <table border="0" cellspacing="0" cellpadding="0">
                          <tr>
                          <!--td align="center" style="border-radius: 3px;" bgcolor="#ff4c52"><a href="" target="_blank" style="font-size: 18px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 12px 50px; border-radius: 2px; border: 1px solid #ff4c52; display: inline-block;">Accepte Invitation</a></td-->
                          <td align="center" style="border-radius: 3px;" bgcolor="#ff4c52"><a href="https://yestravaux.com/crm2/app/index.php?page=profile" target="_blank" style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 12px 50px; border-radius: 2px; border: 1px solid #ff4c52; display: inline-block;">Mon Profil</a></td>

                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <?php } else if($_REQUEST['message']=="inscrit"){?>
              <!-- COPY -->
              <tr>
        
        <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 5px 30px; color: #666666; font-family: 'Poppins', sans-serif; font-size: 16px; font-weight: 300; line-height: 25px;">
        <p style="margin: 0;">Félicitations <?php echo $_REQUEST['name'];?> ,</p>
      </td>
    </tr>
    <tr>
      <td bgcolor="#ffffff" align="left" style="padding: 5px 20px 20px 30px; color: #666666; font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 300; line-height: 25px;">
        <p style="margin: 0;">Votre compte a été créé avec succès. cliquez  pour vous connectez</p>
      </td>
    </tr>
    <!-- BULLETPROOF BUTTON -->
    <tr>
      <td bgcolor="#ffffff" align="left">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td bgcolor="#ffffff" align="center" style="padding: 20px 10px 60px 10px;">
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                <td align="center" style="border-radius: 3px;" bgcolor="#0bb2d4"><a href="https://yestravaux.com/crm2/app/components/pages/auth_login.php" target="_blank" style="font-size: 10px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 12px 50px; border-radius: 2px; border: 1px solid #0bb2d4; display: inline-block;">Se Connecter</a></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <?php } else if($_REQUEST['message']=="initPASS"){?>
        <tr>
        
        <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 5px 30px; color: #666666; font-family: 'Poppins', sans-serif; font-size: 16px; font-weight: 300; line-height: 25px;">
        <p style="margin: 0;">Bonjour <?php echo $_REQUEST['name'];?> ,</p>
      </td>
    </tr>
    <tr>
      <td bgcolor="#ffffff" align="left" style="padding: 5px 20px 20px 30px; color: #666666; font-family: 'Poppins', sans-serif; font-size: 16px; font-weight: 400; line-height: 25px;">
        <p style="margin: 0;">Pour réinitialiser votre mot de passe veuillez cliquez sur Réinitialiser</p>
      </td>
    </tr>
    <!-- BULLETPROOF BUTTON -->
    <tr>
      <td bgcolor="#ffffff" align="left">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td bgcolor="#ffffff" align="center" style="padding: 20px 10px 60px 10px;">
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                <td align="center" style="border-radius: 3px;" bgcolor="#ff4c52"><a href="<?php echo $_REQUEST['url'];?>" target="_blank" style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 12px 50px; border-radius: 2px; border: 1px solid #ff4c52; display: inline-block;">Réinitialiser</a></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <?php } else if($_REQUEST['message']=="TicketReply"){?>
        <tr>
        
        <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 5px 30px; color: #666666; font-family: 'Poppins', sans-serif; font-size: 16px; font-weight: 300; line-height: 25px;">
        <p style="margin: 0;">Bonjour <?php echo $_REQUEST['name'];?> ,</p>
      </td>
    </tr>
    <tr>
      <td bgcolor="#ffffff" align="left" style="padding: 5px 20px 20px 30px; color: #666666; font-family: 'Poppins', sans-serif; font-size: 16px; font-weight: 400; line-height: 25px;">
        <p style="margin: 0;" class="text-fade"> vous avez envoyer  une reclmations a nous , voici la reponse de votre demande : <br>
      <p style="font-style:italic"><?php echo $_REQUEST["body"];?></p>

      
      </p>
      <br>
      <p style="margin:0;">
          Si vous souhaitez contenu a repondre vous pouvez cliquer sur le button si dessous pour envoyer d'autres reponse.
      </p>
      </td>
    </tr>
    <!-- BULLETPROOF BUTTON -->
    <tr>
      <td bgcolor="#ffffff" align="left">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td bgcolor="#ffffff" align="center" style="padding: 20px 10px 60px 10px;">
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                <td align="center" style="border-radius: 3px;" bgcolor="#ff4c52"><a href="<?php echo $_REQUEST['url'];?>" target="_blank" style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 12px 50px; border-radius: 2px; border: 1px solid #ff4c52; display: inline-block;">Repondre</a></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <?php } else if($_REQUEST['message']=="TicketCreations"){?>
        <tr>
        
        <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 5px 30px; color: #666666; font-family: 'Poppins', sans-serif; font-size: 16px; font-weight: 300; line-height: 25px;">
        <p style="margin: 0;">Bonjour <?php echo $_REQUEST['name'];?> ,</p>
      </td>
    </tr>
    <tr>
      <td bgcolor="#ffffff" align="left" style="padding: 5px 20px 20px 30px; color: #666666; font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 400; line-height: 25px;">
        <p style="margin: 0;" class=""> 
        Votre demande a été reçue et est en cours d'examen par notre équipe d'assistance. Pour ajouter des commentaires supplémentaires, répondez à cet e-mail
      
      </p>
      <br>
      <p style="margin:0;">
      </p>
      </td>
    </tr>
    <!-- BULLETPROOF BUTTON -->
    <tr>
      <td bgcolor="#ffffff" align="left">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td bgcolor="#ffffff" align="center" style="padding: 20px 10px 60px 10px;">
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <?php } else if($_REQUEST['message']=="sendtask"){?>
      <tr>
        
        <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 5px 30px; color: #666666; font-family: 'Poppins', sans-serif; font-size: 16px; font-weight: 300; line-height: 25px;">
        <p style="margin: 0;">Bonjour <?php echo $_REQUEST['name'];?> ,</p>
      </td>
    </tr>
    <tr>
      <td bgcolor="#ffffff" align="left" style="padding: 5px 20px 20px 30px; color: #666666; font-family: 'Poppins', sans-serif; font-size: 16px; font-weight: 400; line-height: 25px;">
        <p style="margin: 0;"><?php echo $_REQUEST['url'];?></p>
      </td>
    </tr>
    <!-- BULLETPROOF BUTTON -->
    <tr>
      <td bgcolor="#ffffff" align="left">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td bgcolor="#ffffff" align="center" style="padding: 20px 10px 60px 10px;">
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>

        <?php }?>
     

              <!-- COPY -->

              <tr>
                <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 40px 30px; border-radius: 0px 0px 0px 0px; color: #666666; font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 400; line-height: 25px;">
                  <p style="margin: 0;">Cheers,<br>CRM Equipe</p>
                </td>
              </tr>
              <tr>
                <td bgcolor="#ffffff" align="center" style="padding: 30px 10px 10px 10px;">
                  <a href="https://yestravaux.com/crm2/app/components/pages/auth_login.php" target="_blank">
                      <img alt="Product update video" src="https://yestravaux.com/crm2/images/Captureyestravaux.png" width="500" height="400" border="0">
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
    
    <!-- FOOTER -->
    <tr>
        <td align="center" style="padding: 10px 0px 50px 0px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
            <tr>
            <td align="center" valign="top" width="600">
            <![endif]-->
            <?php if($_REQUEST['message']=="mdp"){
               $color="#ff4c52";
            }else if($_REQUEST['message']=="inscrit"){
                $color="#0bb2d4";
            }
            else
            {
                $color="#ff4c52";
            }
            ?>
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" bgcolor="<?php echo $color;?>">
           
              <!-- NAVIGATION -->
              <tr>
              
                <td bgcolor="#ffffff" align="left" style="padding: 30px 30px 30px 30px; color: #aaaaaa; font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 500; line-height: 18px;">
                  <p style="margin: 0;">
                    <a href="#" target="_blank" style="color: #999999; font-weight: 700;">Dashboard</a> -
                    <a href="#" target="_blank" style="color: #999999; font-weight: 700;">Billing</a> -
                    <a href="#" target="_blank" style="color: #999999; font-weight: 700;">Help</a>
                  </p>
                </td>
              </tr>
              <!-- PERMISSION REMINDER -->
              <tr>
                <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 30px 30px; color: #aaaaaa; font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 500; line-height: 18px;">
                  <p style="margin: 0;">Vous avez reçu cet e-mail car vous venez de créer un nouveau compte. Si ça a l'air bizarre, <a href="https://yestravaux.com/crm2/app/components/pages/auth_login.php" target="_blank" style="color: #999999; font-weight: 700;">Voir sur votre navigateur</a>.</p>
                </td>
              </tr>
              <!-- UNSUBSCRIBE -->
              <tr>
                <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 30px 30px; color: #aaaaaa; font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 500; line-height: 18px;">
                  <p style="margin: 0;">Si ces e-mails deviennent ennuyeux, n'hésitez pas à <a href="#" target="_blank" style="color: #999999; font-weight: 700;">unsubscribe</a>.</p>
                </td>
              </tr>
              <!-- ADDRESS -->
              <tr>
                <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 30px 30px; color: #aaaaaa; font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 500; line-height: 18px;">
                  <p style="margin: 0;">DESK HOSTEUR -Route du Lac Lussy 201, 1618 Châtel-Saint-Denis, SUISSE.</p>
                </td>
              </tr>
		      <!-- COPYRIGHT -->
              <tr>
                <td align="center" style="padding: 30px 30px 30px 30px; color: #333333; font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 500; line-height: 18px;">
                  <p style="margin: 0;">Copyright © <?php echo date('Y');?> Admin. Tous les droits sont réservés.</p>
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
    </tr>
</table>

</body>
</html>
