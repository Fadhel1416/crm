<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

</head>
<body>
<table style="font-size: 12px; font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif; border-collapse: collapse;" border="0" width="600" cellpadding="0" align="center" bgcolor="#ffffff">
<tbody>
<tr style="text-align: center; color: #333333;"> 
<td bgcolor="#ffffff">This is an automatic email, please do not reply.</td>
</tr>
<tr>
<td bgcolor=""><img src="https://www.yestravaux.com/img/yes-travaux-header.png" alt="" border="0" />&nbsp;</td>
</tr>
<tr>
<td>
<table style="font-size: 16px; font-family: 'Arial MS', Arial, Helvetica, sans-serif; border-collapse: collapse;" border="0" width="96%" cellpadding="0" align="center" bgcolor="#ffffff">
<tbody>
<tr>
    <?php if($_REQUEST['message']=="mdp"){ ?>
<td bgcolor="#FFFFFF"  style="text-align: left; color: #333333;">Bonjour <b><?php echo $_REQUEST['name']; ?></b>,<br><br>
une tentative de modifications de votre mot de passe a été détectée, est-ce que c'est bien vous ?<br><br>
S'il ne provient pas de votre côté , veuillez modifiez votre mot de passe pour renforcez la sécurite de votre compte.<br><br>
<?php } else if($_REQUEST['message']=="inscrit"){ ?>
    <td bgcolor="#FFFFFF"  style="text-align: left; color: #333333;">Félicitations <b><?php echo $_REQUEST['name']; ?></b>,<br><br>
Votre compte a été créé avec succès<br><br>
cliquez sur ce lien pour vous connectez <a href="https://yestravaux.com/crm2/app/components/pages/auth_login.php">https://yestravaux.com/crm2/app/components/pages/auth_login.php</a>.<br><br>
<?php } else if($_REQUEST['message']=="initPASS"){?>
  <td bgcolor="#FFFFFF"  style="text-align: left; color: #333333;">Bonjour <b><?php echo $_REQUEST['name']; ?></b>,<br><br>
Pour réinitialiser votre mot de passe veuillez cliquez sur ce lien <a href="<?php echo $_REQUEST['url'];?>"><?php echo $_REQUEST['url'];?></a><br><br>
<?php } else if($_REQUEST['message']=="Invitations"){?>

  <td bgcolor="#FFFFFF"  style="text-align: left; color: #333333;">Bonjour,<br><br>
vous étez invité par <?php echo $_REQUEST['sender'];?> pour traitez ces compaigns<br>
<a href="<?php echo $_REQUEST['url'];?>" class="btn btn-danger text-center">Accepte Invitation</a>.<br><br>

  <?php }?>

CRM<br />
  Cordialement,<br />
  <br />
  Delphine Petit
  <br />
  Service Pro<br />
---
<br />
Tel : 09 74 76 56 80<br />
<br />
</td>
</tr>
<tr>
  <td>&nbsp;</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table style="font-size: 12px; font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif; border-collapse: collapse; color: #fff;" border="0" width="600" cellpadding="0" align="center" bgcolor="#551214">
  <tbody>
<tr>
<td bgcolor="#f8c505">&nbsp;</td>
</tr>
</tbody>
</table>

<center>
  <p style="font-size: 8px; font-family: 'Arial MS', Arial, Helvetica, sans-serif;"><a href="https://www.yestravaux.com/pro/manager/autoconnect.php?PK_PRO=[PK_PRO]&K_KEY=[K_KEY]&view=ticket">Désinscription</a> si vous ne souhaitez plus recevoir d'emails.</p></center>
<p>&nbsp;</p>
</body>
</html>