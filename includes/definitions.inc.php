<?php
// echo $_SERVER['SCRIPT_NAME'] . '<br />';
if ($_SERVER['SERVER_PORT'] == '8080')
{
    define("BASE_URL", "http://localhost:8080/helpdesk/");
}
else
{
    define("BASE_URL", "http://localhost/helpdesk/");
}

////////////////////////////
// PATHS TO SERVER SIDE
define('PUBLIC_HTML_HEADER', DOCUMENT_ROOT . '/includes/header.inc.php');
define('PUBLIC_HTML_FOOTER', DOCUMENT_ROOT . '/includes/footer.inc.php');

define('ADMIN_HTML_HEADER', DOCUMENT_ROOT . '/includes/header.inc.php');
define('ADMIN_HTML_FOOTER', DOCUMENT_ROOT . '/includes/footer.inc.php');




