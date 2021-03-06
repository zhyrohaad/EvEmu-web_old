<?php

/* DB Config */
$mysqli_username = "eve";
$mysqli_password = "onlyme";
$mysqli_hostname = "localhost";
$mysqli_dbname = "ore";
$mysqli_protocol = "mysql";

$DSN = "$mysqli_protocol://$mysqli_username:$mysqli_password@$mysqli_hostname/$mysqli_dbname";

$ORENAMES = array (
		// Standard ore
	"Arkonor",
	"Crimson arkonor",
	"Prime arkonor",
	"Bistot",
	"Triclinic bistot",
	"Monoclinic bistot",
	"Crokite",
	"Sharp crokite",
	"Crystalline crokite",
	"Dark Ochre",
	"Onyx ochre",
	"Obsidian ochre",
	"Gneiss",
	"Iridescent gneiss",
	"Prismatic gneiss",
	"Hedbergite",
	"Glazed hedbergite",
	"Hemorphite",
	"Vitric hedbergite",
	"Vivid hemorphite",
	"Radiant hemorphite",
	"Jaspet",
	"Pure jaspet",
	"Pristine jaspet",
	"Kernite",
	"Luminous kernite",
	"Fiery kernite",
	"Mercoxit",
	"Magma mercoxit",
	"Vitreous mercoxit",
	"Omber",
	"Silvery omber",
	"Golden omber",
	"Bright Spodumain",
	"Spodumain",
	"Gleaming spodumain",
	"Plagioclase",
	"Azure plagioclase",
	"Rich plagioclase",
	"Pyroxeres",
	"Solid pyroxeres",
	"Viscous pyroxeres",
	"Scordite",
	"Condensed scordite",
	"Massive scordite",
	"Veldspar",
	"Concentrated veldspar",
	"Dense veldspar",

		// Ice
	"Blue ice",
	"Clear icicle",
	"Dark glitter",
	"Enriched clear icicle",
	"Gelidus",
	"Glacial mass",
	"Glare crust",
	"Krystallos",
	"Pristine white glaze",
	"Smooth glacial mass",
	"Thick blue ice",
	"White glaze"
);

foreach ($ORENAMES as $ore) {
	$dbfriendly = str_replace(" ", "", ucwords($ore));
	if (!empty ($ORENAME_STR)) {
		$ORENAME_STR .= ", " . $dbfriendly;
	} else {
		$ORENAME_STR = $dbfriendly;
	}
	$DBORE[$ore] = $dbfriendly;
}

?>
