<?php
////////////////////////////////////////////////////////////////////////////////
// PREPARE
////////////////////////////////////////////////////////////////////////////////
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpdesk/includes/prepare.inc.php';

$html = [
    'title' => '',
    'breadcrumb' => ''
];


////////////////////////////////////////////////////////////////////////////////
// REQUEST-PROCESSING
////////////////////////////////////////////////////////////////////////////////
if (isset($_REQUEST) && !empty($_REQUEST))
{
    // @TODO - set up cleanup
    $data = $_REQUEST;



}
////////////////////////////////////////////////////////////////////////////////
// DATA-PROCESSING
////////////////////////////////////////////////////////////////////////////////
















////////////////////////////////////////////////////////////////////////////////
// OUTPUT
////////////////////////////////////////////////////////////////////////////////

require_once ADMIN_HTML_HEADER;

////////////////////////////////////////////////////////////////////////////////
?>

<div class="">
    <ul>
        <li>
            <a class="nav-link" href="/helpdesk/admin/upload/index.php">Step 1: Upload helpdesk CSV Reference</a>
        </li>
        <li>
            <a class="nav-link" href="/helpdesk/admin/scan/index.php">
                Step 2: Scan
            </a>
        </li>
    </ul>
</div>




















<?php
////////////////////////////////////////////////////////////////////////////////
// END OUTPUT
////////////////////////////////////////////////////////////////////////////////
require_once ADMIN_HTML_FOOTER;
////////////////////////////////////////////////////////////////////////////////
?>
