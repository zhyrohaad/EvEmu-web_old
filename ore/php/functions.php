<?php
/*  functions here */

function debug($var, $die = false) {
	print (nl2br(print_r($var, true)) . "<br>");
	if ($die) {
		die();
	}
}

function breakPoint($var = false, $die = false) {
	// Load debug statements
	$debug = debug_backtrace();
	$file = $debug[0][file];
	$line = $debug[0][line];
	global $URL;
	// Var
	if (!$var) {
		$var = rand(111,999);
	}
	// Create a generic breakpoint (file logging)
	$fh = fopen("./debug.log", 'a');
	fwrite($fh, "Breakpoint: $file [$line] - Random:" . $var . "\n");
	fclose($fh);
	// Die if requested
	if ($die) {
		die();
	}
}

function getOreSettings($ORE = "") {
	// Quick, but clean :)
	global $DB;
	// Cache the ressource.
	if (!isset ($_SESSION[oretypes])) {
		$SETTINGS = $DB->getAssoc("SELECT * FROM config WHERE name LIKE '%Enabled'");
	} else {
		$SETTINGS = $_SESSION[oretypes];
	}
	// Return the full array or a single 0/1 statement for a single oretype.
	if ("$ORE" != "") {
		// Single ore type
		if ($SETTINGS[$ORE.Enabled]) {
			return (true);
		} else {
			return (false);
		}
	} else {
		// Entire array
		return ($SETTINGS);
	}
}

function makeNotice($body, $type = "notice", $title = "", $backlink = "index.php", $backlinkdesc = "[OK]") {
	global $IGB;
	global $MySelf;

	// Check for valid type
	switch ($type) {
		case ("notice") :
			$typeText = "Notice";
			$color = "#444455";
			$img = "ok.png";
			break;

		case ("warning") :
			$typeText = "Warning";
			$color = "#904000";
			$img = "warning.png";
			break;

		case ("error") :
			$typeText = "Error";
			$color = "#772222";
			$img = "error.png";
			break;

		default :
			// Yeah, we call ourselves!
			$BT = nl2br(print_r(debug_backtrace(), true));
			makeNotice("Internal Error: Wrong errortype defines in makeNotice.<br><br>" . $BT, "error");
			break;
		}
	// Use global variables.
	global $IGB;
	global $VERSION;
	global $TIMEMARK;
	global $TIDY_ENABLE;
	global $MySelf;
	// Do we have a title?
	if (empty ($title)) {
		$title = "$VERSION - Notice";
	}
	// Do we have a body?
	if (empty ($title)) {
		makeErrorPage("makeNotice called without body context.");
	}
	// Beautify the time.
	$STAMP = date("r", $TIMEMARK);
	// Assemble the raw html page.
	//	$HTML = $page;
	if ($IGB) {
		$HTML .= file_get_contents('./include/ingame/igb-notice.txt');
	} else {
		$HTML .= file_get_contents('./include/html/notice.txt');
	}
	//	$HTML .= $footer;
	// Replace placeholders with information.
	$HTML = str_replace("%%TITLE%%", "$title", $HTML);
	$HTML = str_replace("%%BODY%%", "$body", $HTML);
	$HTML = str_replace("%%WHAT%%", "$typeText", $HTML);
	$HTML = str_replace("%%TIME%%", "$STAMP", $HTML);
	$HTML = str_replace("%%COLOR%%", "$color", $HTML);
	$HTML = str_replace("%%IMG%%", "$img", $HTML);
	$HTML = str_replace("%%BACKLINK%%", "$backlink", $HTML);
	$HTML = str_replace("%%BACKLINKDESC%%", "$backlinkdesc", $HTML);
	if (is_object($MySelf) && $MySelf->isValid()) {
		$HTML = str_replace("%%USER%%", "Logged in as " . $MySelf->getUsername(), $HTML);
	} else {
		$HTML = str_replace("%%USER%%", "Not logged in.", $HTML);
	}
	// Spill it out
	$htmlobj = new html;
	$htmlobj->addBody($HTML);
	die($htmlobj->flush());
}

function changeOreValue() {
	// Import global Variables and the Database.
	global $DB;
	global $ORENAMES;
	global $DBORE;
	global $TIMEMARK;
	global $MySelf;

	// Lets set the userID(!)
	$userID = $MySelf

	// Insert the new ore values into the database.
	$DB->query("insert into orevalues (modifier, time) values (".$userID.",".$TIMEMARK.")");

	// Now loop through all possible oretypes.
	foreach ($DBORE as $ORE) {
		// But check that the submited information is kosher.
		if ((isset ($_POST[$ORE])) && (is_numeric($_POST[$ORE]))) {
			// Write the new, updated values.
			$DB->query("UPDATE orevalues SET " . $ORE . "Worth= '$_POST[$ORE]' WHERE time = '$TIMEMARK'");

			// Enable or disable the oretype.
			if ($_POST[$ORE.Enabled]) {
				$DB->query("UPDATE config SET value = '1' where name='" . $ORE . "Enabled' ");
			} else {
				$DB->query("UPDATE config SET value = '0' where name='" . $ORE . "Enabled' ");
			}
		}
	}

	// Let the user know.
	makeNotice("The payout values for ore have been changed.", "notice", "New data accepted.", "index.php?action=changeow", "[OK]");
}


function errorHandler($number, $string, $file, $line, $context) {

	if ($number != E_NOTICE && $number != E_WARNING) {
		global $VERSION;
		$error = "<table><tr><td>";
		$error .= "Number:</td><td>[$number]</tr></tr>";
		$error .= "<tr><td>String :</td><td> [$string]</tr></tr>";
		$error .= "<tr><td>File   :</td><td> [$file]</tr></tr>";
		$error .= "<tr><td>Line   :</td><td> [$line]</tr></tr>";
		//		$error .= "<tr><td>Context:</td><td>".nl2br(print_r($context))."</tr></tr></table>";

		$html = file_get_contents('./include/html/errorHandler.txt');
		$html = str_replace("%%ERROR%%", $error, $html);
		$html = str_replace("%%SITENAME%%", $VERSION, $html);

		print ($html);
		die();
	}

}

function humanTime($mode, $playdoo = false) {

	/*
	 * Mode is either toUnix or toHuman.
	 * toUnix converts the given array to an UNIX timestamp,.
	 * toHuman returns an array with split up time.
	 */

	switch ($mode) {

		case ("toUnix") :
			// To convert something back, we need an array.
			if (!is_array($playdoo)) {
				makeNotice("Internal Error: given argument is not an array in humanTime.", "error", "Internal Error");
			}

			// Check for validity.
			numericCheck($playdoo[day]);
			numericCheck($playdoo[month]);
			numericCheck($playdoo[year]);
			numericCheck($playdoo[hour]);
			numericCheck($playdoo[minute]);

			// Assemble the time.
			$humantime = $playdoo[day] . "." . $playdoo[month] . "." . $playdoo[year] . " " . $playdoo[hour] . ":" . $playdoo[minute];

			// Convert it.
			$timestamp = date("U", strtotime($humantime));

			// Check and return.
			if ($timestamp >= 0) {
				// Its greater of equal zero, so we were successful.
				return ($timestamp);
			} else {
				// Ugh, something did not go right. False, FALSE!
				return (false);
			}
			break;

		case ("toHuman") :

			// We need a VALID timestamp.
			numericCheck($playdoo, 0);

			// Assemble and return.
			return (array (
				"day" => date("d",
				$playdoo
			), "month" => date("m", $playdoo), "year" => date("Y", $playdoo), "hour" => date("H", $playdoo), "minute" => date("i", $playdoo)));
			break;
	}
}

?>
