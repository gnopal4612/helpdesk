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

////////////////////////////////////////////////////////////////////////////////
// REQUEST-PROCESSING
////////////////////////////////////////////////////////////////////////////////
if (isset($_REQUEST) && !empty($_REQUEST))
{
    // @TODO - set up cleanup
    $request = $_REQUEST;

	if (isset($request['form']['submit_action']) && !empty($request['form']['submit_action']))
	{
		if ($request['form']['submit_action'] == 'Submit')
		{
			if (isset($request['form']['search']) && !empty($request['form']['search']))
			{
				$_SESSION['list'][] = trim($request['form']['search']);
				$_SESSION['list'] = array_unique($_SESSION['list']);
			}

			if (!empty($request['asset']))
			{
				foreach ($request['asset'] as $fld => $a)
				{
					$asset[$fld] = trim($a);
				}
			}

			foreach ($_SESSION['list'] as $asset_no)
			{
				$_SESSION['asset'][$asset_no] = fetch_from_current($asset_no);
			}

		}
		elseif ($request['form']['submit_action'] == 'Clear')
		{
			$_SESSION['list'] = [];
		}
		elseif ($request['form']['submit_action'] == 'Import')
		{

		}
	}













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
	    <fieldset class="col-md-12">
            <legend>
            	<label>Search</label>
    		</legend>
			<div class="row">
				<div class="col-md-12"><?=implode('<br>', $message)?></div>
            	<div class="col-md-6">
            		<input type="text" name="form[search]" autofocus>
            		<input type="submit" name="form[submit_action]" value="Submit" >
            	</div>
            	<div class="col-md-6">
					<div class="display-results">
            			<input type="submit" name="form[submit_action]" value="Import" style="width: 100px; height: 100%;">
            			<input type="submit" name="form[submit_action]" value="Clear" style="width: 100px; height: 100%;">
        			</div>
    			</div>
            </div>
		</fieldset>
	</div>
<?php
if (isset($_SESSION['list']) && !empty($_SESSION['list']))
{
?>
	<div class="row">
	    <fieldset class="col-md-12">
            <legend>
            	<label>Scanned</label>
    		</legend>
<?php
	foreach ($_SESSION['list'] as $scan)
	{
?>
				<!-- <div class="scan-result"> -->
					<?=$scan;?>,
				<!-- </div> -->
<?php
	}
?>
		</fieldset>
	</div>
<?php
}
?>
	<div class="row">
<?php
if (!empty($request['form']['search']))
{
?>
		<fieldset class="col-md-12"  style="display: none;">
	    	<legend><label>Form</label></legend>
			<?php display_form_table($asset); ?>
		</fieldset>
<?php
}
?>
	</div>
	<div class="row">
<?php
if (isset($_SESSION['list']) && !empty($_SESSION['list']))
{
?>
		<fieldset class="col-md-12">
	    	<legend><label>Form</label></legend>
	    	<table>
	    		<tr>
	    			<td>
<?php
    foreach (['asset_no', 'serial_number'] as $fld)
    {
?>
						<div class="display-results">
							<input type="text" id="<?=$fld?>" name="asset[<?=$fld?>]" value="<?=$asset[$fld]?>" placeholder="<?=$fld?>"><br>
						</div>
<?php
	}
?>
					</td>
	    			<td>
<?php
    foreach (['model', 'manufacturer', 'asset_type'] as $fld)
    {
?>
						<div class="display-results">
							<input type="text" id="<?=$fld?>" name="asset[<?=$fld?>]" value="<?=$asset[$fld]?>" placeholder="<?=$fld?>"><br>
						</div>
<?php
	}
?>
					</td>

	    			<td>
<?php
    foreach (['location', 'room', 'status'] as $fld)
    {
    	echo '<div class="display-results">';
    	if ($fld == 'location')
		{
			display_locations_field($asset[$fld]);
		}
		elseif ($fld == 'status')
        {
			display_status_field($asset[$fld]);
        }
		else
		{
?>
			<input type="text" id="<?=$fld?>" name="asset[<?=$fld?>]" value="<?=$asset[$fld]?>" placeholder="<?=$fld?>"><br>
<?php
		}
		echo '</div>';
	}
?>
					</td>
	    			<td>
<?php
    foreach (['clients', 'network_name', 'po_number'] as $fld)
    {
?>
						<div class="display-results">
							<input type="text" id="<?=$fld?>" name="asset[<?=$fld?>]" value="<?=$asset[$fld]?>" placeholder="<?=$fld?>"><br>
						</div>
<?php
	}
?>
					</td>
					<td>
						<input type="text" id="<?=$fld?>" name="asset[<?=$fld?>]" value="<?=$asset[$fld]?>" placeholder="<?=$fld?>"><br>

					</td>
				</tr>
			</table>
		</fieldset>
<?php
}
?>
	</div>
<?php
if (isset($_SESSION['list']) && !empty($_SESSION['list']))
{
?>
	<div clas="row">
		<fieldset class="col-md-12">
	    	<legend><label>Import</label></legend>
	    	<table>
	    		<tr>

		   			<td>
	    				<input type="checkbox" name="" value="asset_no">
	    			</td>


				</tr>
			</table>
		</fieldset>
	</div>

<?php
}
?>
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

