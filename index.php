<?php
$mysql_server = 'localhost';
$mysql_username = 'root';
$mysql_password = '';
$mysql_database = 'ejemplo';
$mysql_table = 'registro';
$success_page = './Matemáticas.html';
$error_message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form_name']) && $_POST['form_name'] == 'signupform')
{
   $newusername = $_POST['username'];
   $newemail = $_POST['email'];
   $newpassword = $_POST['password'];
   $confirmpassword = $_POST['confirmpassword'];
   $newfullname = $_POST['fullname'];
   $code = 'NA';
   if ($newpassword != $confirmpassword)
   {
      $error_message = 'Password and Confirm Password are not the same!';
   }
   else
   if (!preg_match("/^[A-Za-z0-9-_!@$]{1,50}$/", $newusername))
   {
      $error_message = 'Username is not valid, please check and try again!';
   }
   else
   if (!preg_match("/^[A-Za-z0-9-_!@$]{1,50}$/", $newpassword))
   {
      $error_message = 'Password is not valid, please check and try again!';
   }
   else
   if (!preg_match("/^[A-Za-z0-9-_!@$.' &]{1,50}$/", $newfullname))
   {
      $error_message = 'Fullname is not valid, please check and try again!';
   }
   else
   if (!preg_match("/^.+@.+\..+$/", $newemail))
   {
      $error_message = 'Email is not a valid email address. Please check and try again.';
   }
   if (empty($error_message))
   {
      $db = mysqli_connect($mysql_server, $mysql_username, $mysql_password);
      if (!$db)
      {
         die('Failed to connect to database server!<br>'.mysqli_error($db));
      }
      mysqli_select_db($db, $mysql_database) or die('Failed to select database<br>'.mysqli_error($db));
      mysqli_set_charset($db, 'utf8');
      $sql = "SELECT username FROM ".$mysql_table." WHERE username = '".$newusername."'";
      $result = mysqli_query($db, $sql);
      if ($data = mysqli_fetch_array($result))
      {
         $error_message = 'Username already used. Please select another username.';
      }
   }
   if (empty($error_message))
   {
      $crypt_pass = md5($newpassword);
      $newusername = mysqli_real_escape_string($db, $newusername);
      $newemail = mysqli_real_escape_string($db, $newemail);
      $newfullname = mysqli_real_escape_string($db, $newfullname);
      $sql = "INSERT `".$mysql_table."` (`username`, `password`, `fullname`, `email`, `active`, `code`, `role`) VALUES ('$newusername', '$crypt_pass', '$newfullname', '$newemail', 1, '$code', '')";
      $result = mysqli_query($db, $sql);
      mysqli_close($db);
      $subject = 'Your new account';
      $message = 'A new account has been setup.';
      $message .= "\r\nUsername: ";
      $message .= $newusername;
      $message .= "\r\nPassword: ";
      $message .= $newpassword;
      $message .= "\r\n";
      $header  = "From: webmaster@yourwebsite.com"."\r\n";
      $header .= "Reply-To: webmaster@yourwebsite.com"."\r\n";
      $header .= "MIME-Version: 1.0"."\r\n";
      $header .= "Content-Type: text/plain; charset=utf-8"."\r\n";
      $header .= "Content-Transfer-Encoding: 8bit"."\r\n";
      $header .= "X-Mailer: PHP v".phpversion();
      mail($newemail, $subject, $message, $header);
      header('Location: '.$success_page);
      exit;
   }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Página sin título</title>
<meta name="generator" content="WYSIWYG Web Builder 15 Trial Version - http://www.wysiwygwebbuilder.com">
<link href="Sin_titulo1.css" rel="stylesheet">
<link href="index.css" rel="stylesheet">
</head>
<body>
<div id="wb_Shape1" style="position:absolute;left:1px;top:0px;width:1311px;height:1018px;opacity:0.50;z-index:0;">
<img src="images/img0001.png" id="Shape1" alt="" style="width:1311px;height:1018px;"></div>
<a href="http://www.wysiwygwebbuilder.com" target="_blank"><img src="images/builtwithwwb15.png" alt="WYSIWYG Web Builder" style="position:absolute;left:606px;top:654px;margin: 0;border-width:0;z-index:250"></a>
<div id="wb_Image1" style="position:absolute;left:100px;top:0px;width:1100px;height:310px;z-index:2;">
<img src="images/pngtree-educational-institution-owl-flat-geometric-clouds-poster-background-image_124232.jpg" id="Image1" alt=""></div>
<div id="wb_Signup1" style="position:absolute;left:491px;top:108px;width:447px;height:546px;z-index:3;">
<form name="signupform" method="post" accept-charset="UTF-8" action="<?php echo basename(__FILE__); ?>" id="signupform">
<input type="hidden" name="form_name" value="signupform">
<table id="Signup1">
<tr>
   <td class="header">Usuario</td>
</tr>
<tr>
   <td class="label"><label for="fullname">Nombre Completo</label></td>
</tr>
<tr>
   <td class="row"><input class="input" name="fullname" type="text" id="fullname"></td>
</tr>
<tr>
   <td class="label"><label for="username">Nombre de Usuario</label></td>
</tr>
<tr>
   <td class="row"><input class="input" name="username" type="text" id="username"></td>
</tr>
<tr>
   <td class="label"><label for="password">Contraseña</label></td>
</tr>
<tr>
   <td class="row"><input class="input" name="password" type="password" id="password"></td>
</tr>
<tr>
   <td class="label"><label for="confirmpassword">Confirmar Contraseña</label></td>
</tr>
<tr>
   <td class="row"><input class="input" name="confirmpassword" type="password" id="confirmpassword"></td>
</tr>
<tr>
   <td class="label"><label for="email">Correo </label></td>
</tr>
<tr>
   <td class="row"><input class="input" name="email" type="text" id="email"></td>
</tr>
<tr>
   <td><?php echo $error_message; ?></td>
</tr>
<tr>
   <td style="text-align:center;vertical-align:bottom"><input class="button" type="submit" name="signup" value="Create User" id="signup"></td>
</tr>
</table>
</form>
</div>
</body>
</html>