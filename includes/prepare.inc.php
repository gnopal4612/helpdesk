<?php

define("DOCUMENT_ROOT", $_SERVER['DOCUMENT_ROOT'] . '/helpdesk/');

$SITE_REQUIRES = [
    'definitions',
    'session',
//     'variables',
    'db',

//     'validation',
//     'functions',
//     'import_csv',
//     'render',
];

foreach ($SITE_REQUIRES AS $include)
{
    require_once DOCUMENT_ROOT . "/includes/{$include}.inc.php";
}


require_once DOCUMENT_ROOT . '/developer/functions.inc.php';
require_once DOCUMENT_ROOT . '/includes/error_handling.inc.php';


unset($SITE_REQUIRES);
/*
require_once DOCUMENT_ROOT . '/includes/definitions.inc.php';
require_once DOCUMENT_ROOT . '/includes/session.inc.php';
require_once DOCUMENT_ROOT . '/includes/variables.inc.php';


require_once DOCUMENT_ROOT . '/includes/db.inc.php';
require_once DOCUMENT_ROOT . '/includes/validation.inc.php';
// require_once DOCUMENT_ROOT . '/includes/functions.inc.php';
require_once DOCUMENT_ROOT . '/includes/import_csv.inc.php';
// require_once DOCUMENT_ROOT . '/includes/render.inc.php';


require_once DOCUMENT_ROOT . '/developer/functions.inc.php';
// require_once DOCUMENT_ROOT . '/developer/dev_variables.inc.php';




// side effect: change ini settings
// ini_set('error_reporting', E_ALL);

 *
 *
 */