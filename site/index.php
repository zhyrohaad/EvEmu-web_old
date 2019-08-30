<?php
include("ping.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="_your description goes here_" />
<meta name="keywords" content="_your,keywords,goes,here_" />
<meta name="author" content="" />
<title>EVE - Apocrypha | Home</title>
<style type="text/css">
<!--
body,td,th {
	color: #CCCCCC;
	font-family: Tahoma;
}
body {
	background-color: #000000;
}
.style3 {color: #FFFFFF}
.style6 {font-size: 9px}
-->
</style>
</head>

<body>
<table width="563" height="699" border="0" align="center">
  <tr>
    <td height="573" align="center" background="imgs/frameBG.jpg"><div id="createaccount"> <br />
        <br />
          <br />
          <br />
          <br />
        <br />
        <p class="style3">Simply fill out this form and your account is setup on our server</p>
    </div>

        <table border="0" align="center">
          <tr>
            <td><p align="center">
                <?php
error_reporting(E_ALL);
include_once 'db.php';


if (!isset($_POST['submit']))
{
	// show the registration form here
	?>
	
	<form action="index.php" method="post">
		<div align="center">Username<br />
		    <input name="username" type="text" />
		  <br />
		  Password<br />
		  <input name="password" type="password" />
		  <br />
		  <br />
		  <input name="submit" type="submit" value="Create Account" />
		      </div>
	</form>
	
	<div align="center">
	  <?php
}
else
{
	// process the form
	
	// clean the username and password
	$username = mysqli_real_escape_string($_POST['username']);
	$password = mysqli_real_escape_string($_POST['password']);
	
	// check for valid details
	$sql = mysqli_query("INSERT INTO `account` (`accountName`, `role`, `password`)
					   VALUES ('$username', 4294967231,PASSWORD('$password'))");
	
	if ($sql)
	{
		// success
		echo 'Done, Now connect your client to server address: 60.240.37.49<p></p><br>';
	}
	else
	{
		// failure
		echo 'Sorry, that username is taken! <a href="index.php">Back<p></p><br>';
	}	
}

?>
	  </div>
	  </div></td>
          </tr>
          <tr>
            <td><img src="<?php echo($img); ?>"/></td>
          </tr>
        </table>    </td>
  </tr>
  <tr>
    <td height="59" align="center"><p><a href="http://kvantum.wigner.bme.hu/~firefoxpdm/eve/client/EVE_3913a.exe">Download EVE-Online Red Moon Rising v3913a Client (551MB)<br />
        <br />
    </a><a href="howto.php">= Configure to Connect to Our Server =</a></p>
    <p><a href="GMcmd.php">= Game Master Command Lines (Test) =</a></p>
    <p><a href="gameplay.php">= Game Play and Info =</a></p>
    <p><a href="screenshots.php">= Screenshots =</a></p>
    <p><a href="../forum/index.php">= Forum =</a></p></td>
  </tr>
  <tr>
    <td height="59" align="center"><hr noshade="noshade" />
    <span class="style6">2008 :: AlphaTest Server </span></td>
  </tr>
</table>

<p>&nbsp;</p>
</body>
</html>

