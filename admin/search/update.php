<?php
////////////////////////////////////////////////////////////////////////////////
// PREPARE
////////////////////////////////////////////////////////////////////////////////
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpdesk/includes/prepare.inc.php';
require_once 'model.inc.php';

// Report all PHP errors
// ini_set('error_reporting', false);

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
    $request = $_REQUEST;














}

////////////////////////////////////////////////////////////////////////////////
// OUTPUT
////////////////////////////////////////////////////////////////////////////////
require_once ADMIN_HTML_HEADER;
////////////////////////////////////////////////////////////////////////////////
?>
<style>
    .container {padding: 0px;}
</style>
<script src="scan.js"></script>

<form action="<?=$_SERVER['SCRIPT_NAME']?>" method="post" class="container">
	<div class="row">
	    <fieldset class="col-md-8">
            <legend>
            	<label>Search</label>
    		</legend>

		</fieldset>
	</div>









</form>


<?php
////////////////////////////////////////////////////////////////////////////////
// END OUTPUT
////////////////////////////////////////////////////////////////////////////////
$scouter_params = [
    'request',
    '_SESSION',
    'current',
    'reference',
    'recommended'
];

foreach ($scouter_params as $p)
{
    if (isset($$p))
    {
        $scouter[$p] = $$p;
    }
}
$url = http_build_query($scouter);

?>
<script>
    window.open(
    	"http://localhost:8080/helpdesk/developer/scouter.php?<?=$url?>",
    	"MsgWindow",
    	 "width=500,height=500");
</script>
<?php
require_once ADMIN_HTML_FOOTER;
////////////////////////////////////////////////////////////////////////////////

