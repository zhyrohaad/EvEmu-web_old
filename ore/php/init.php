<?php

require_once ('./php/functions.php');
require_once ('./php/config.php');
session_start();

/* get the domain name. */
$DOMAIN = $_SERVER[HTTP_HOST];
$SCRIPT = dirname($_SERVER[SCRIPT_NAME]);
$URL = "http://" . $DOMAIN . $SCRIPT;

/* Set the error handler. */
set_error_handler('errorHandler', E_WARNING);

/* Create a timestamp and database */
$DB = makeDB();
$TIMEMARK = date(U) - (getConfig("timeOffset") * 60 * 60);

/* Is this call made from within EvE? */
if (ereg("EVE-minibrowser", $_SERVER[HTTP_USER_AGENT])) {
	$IGB = TRUE;
	if ($_SERVER['HTTP_EVE_TRUSTED'] != 'yes') {
		// Request Trust
		header("eve.trustme:http://" . $DOMAIN . "/::This is " . $VERSION . ".");
		ob_flush();
		die();
	} else {
		$EVE_Charname = $_SERVER['HTTP_EVE_CHARNAME'];
	}
} else {
}

/* If we are this far, we have passed the checks. */
if ($_SESSION["initdone"] != true) {
	$_SESSION["initdone"] == true;
}

// Load the sitename.
$SITENAME = getConfig("sitename");

global $BLESSED;
if ($BLESSED) {
	$VERSION .= " [blessed]";
}

?>