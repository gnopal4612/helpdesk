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

$message = [];
$asset = array_combine($selected_fields, array_fill(0, count($selected_fields), ''));
$current = $reference = [];


////////////////////////////////////////////////////////////////////////////////
// REQUEST-PROCESSING
////////////////////////////////////////////////////////////////////////////////
if (isset($_REQUEST) && !empty($_REQUEST))
{
    // @TODO - set up cleanup
    $request = $_REQUEST;

	if (isset($request['asset']) && !empty($request['asset']))
	{
		foreach ($request['asset'] as $fld => $value)
		{
			$tmp_request[$fld] = trim($value);
		}
		$request['asset'] = $tmp_request;
	}

    if (isset($request['form']['submit_action']) && !empty($request['form']['submit_action']))
    {
        if ($request['form']['submit_action'] == 'Submit')
        {
        	if (!empty($request['form']['search']))
			{
	            if (empty($current = fetch_all_from_current($request['form']['search'])))
	            {
	                $message[] = 'Current is empty.';
	            }

	            if (empty($reference = fetch_all_from_reference($request['form']['search'])))
	            {
	                $message[] = 'Reference is empty.';
	            }
			}
        }
		elseif ($request['form']['submit_action'] == 'Insert')
		{
			insert_into_current_assets($request['asset']);
		}
		elseif ($request['form']['submit_action'] == 'Update')
		{
			update_current_asset($request['asset']);
		}
    }



////////////////////////////////////////////////////////////////////////////////
// DATA-PROCESSING
////////////////////////////////////////////////////////////////////////////////
    if (!empty($current))
    {
        $asset = $current[0]; // take first value


	}
    elseif (empty($current) && !empty($reference))
    {
        $asset = $reference[0]; // take first value
        foreach ($selected_fields as $fld)
		{
			$asset[$fld] = '';
			if (!in_array($fld, $reset_fields))
			{
				$asset[$fld] = $reference[0][$fld];
			}
		}
    }

	$scouter['asset'] = $asset;


}

////////////////////////////////////////////////////////////////////////////////
// OUTPUT
////////////////////////////////////////////////////////////////////////////////
require_once ADMIN_HTML_HEADER;
////////////////////////////////////////////////////////////////////////////////
?>
<style>
    .container {padding: 0px;} /* get rid fo padding from bootstrap temporarily */
</style>
<script src="scan.js"></script>

<form action="<?=$_SERVER['SCRIPT_NAME']?>" method="post" class="container">
	<div class="row">
	    <fieldset class="col-md-12">
            <legend>
            	<label>Search</label>
    		</legend>
			<div class="row">
				<div class="col-md-12"><?=implode('<br>', $message)?></div>
            	<div class="col-md-10">
            		<input type="text" name="form[search]" autofocus>
            		<input type="submit" name="form[submit_action]" value="Submit" >
            	</div>
            	<div class="col-md-2">
<?php
if (!empty($reference) && empty($current)) {
?>
					<div class="display-results">
            			<input type="submit" name="form[submit_action]" value="Insert" style="width: 100%; height: 100%;">
        			</div>
<?php
}
if (!empty($current)) {
?>
					<div class="display-results">
            			<input type="submit" name="form[submit_action]" value="Update" style="width: 100%; height: 100%;">
        			</div>
<?php
}
?>
            	</div>
            </div>
		</fieldset>
	</div>
	<div class="row">
<?php
if (!empty($request['form']['search']))
{
?>
		<fieldset class="col-md-3">
	    	<legend><label>Form</label></legend>
			<?php display_asset_form($asset); ?>
		</fieldset>
<?php
}
if (!empty($current))
{
?>
	    <fieldset class="col-md-3">
        	<legend><label>Current</label></legend>
			<?php display_db_results($current[0], 'current');?>
		</fieldset>
<?php
}
if (!empty($reference))
{
?>
	    <fieldset class="col-md-3">
        	<legend><label>Reference</label></legend>
			<?php display_db_results($reference[0], 'reference');?>
		</fieldset>
<?php
}
?>
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
    	"<?=BASE_URL . "/developer/scouter.php?" . $url?>",
    	"MsgWindow",
    	 "width=500,height=500");
</script>
<?php
require_once ADMIN_HTML_FOOTER;
////////////////////////////////////////////////////////////////////////////////

