<?php
/*
Plugin Name: SDS Tournaments
Plugin URI:
description:
Version: 1.0
Author:
Author URI:
License:
*/
define('SDS_TEXTDOMAIN','sds-tournaments');
include ('includes/sds_tournaments.php');
include ('includes/shortcodes.php');
$sds_tournaments = new sdsTournaments();
