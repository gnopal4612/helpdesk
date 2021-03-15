<?php
////////////////////////////////////////////////////////////////////////////////
// PREPARE
////////////////////////////////////////////////////////////////////////////////
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpdesk/includes/prepare.inc.php';

$html = [
    'title' => '',
    'breadcrumb' => ''
];

// TODO - add error handling
$errors = [];

////////////////////////////////////////////////////////////////////////////////
// REQUEST-PROCESSING
////////////////////////////////////////////////////////////////////////////////
if (isset($_REQUEST) && !empty($_REQUEST))
{
    // @TODO - set up cleanup
    $data = $_REQUEST;

    if (isset($request['submit_action']) && !empty($request['submit_action']))
    {

    }
}

////////////////////////////////////////////////////////////////////////////////
// DATA-PROCESSING
////////////////////////////////////////////////////////////////////////////////

// $check = new Cosmos([
//     'table' => '21.02.02_helpdesk',
//     'fields' => $sw_fields,
//     'where' => [
//         ['asset_no', '=', $request['scanned_serial']],
//     ],
// ]);

$check = new Cosmos([
    'query' => 'SELECT * FROM `reference`'
]);

$results = $check->selectAll();



$group = [];
$tmp = [];
foreach ($results as $i => $asset)
{
    foreach ($asset as $fld => $val)
    {
    	if (!empty($val))
		{
        	$tmp[$fld][] = trim($val);
		}
	}
}


foreach ($tmp as $fld => $values)
{
    $group[$fld] = array_unique($values);
}



// reveal($group);

////////////////////////////////////////////////////////////////////////////////
// OUTPUT
////////////////////////////////////////////////////////////////////////////////
require_once ADMIN_HTML_HEADER;
////////////////////////////////////////////////////////////////////////////////
?>
<style>
.light-blue
{
    color: #26abff;
}
form {
    width: 1100px;

}
fieldset {
    border: 1px solid #26abff;
    border-radius: 5px;
    padding: 10px;
    margin-bottom: 10px;
    overflow: auto;
}

table {
    overflow: auto;
    vertical-align: top;
}

.scroll-box {
    width: 100%;
    overflow-x: scroll;
}

table th {
    color: #26abff;
}

th, td {
    border: 1px solid #ccc;
    padding: 3px 5px;
    height: 100%;
    vertical-align: top;

}
input[type=text] {
    width: 100px;
}

.custom-th,
legend {
    color: green;
    font-size: 12px;
    font-weight: 700;
    width: 100px;
}

.custom-th {
    border: 2px solid green;
    text-align: center;
}

.clickable {
    display: block;
    border: 1px solid #a9a9a9;
    border-radius: 5px;
    padding: 5px;
    text-align: center;
    vertical-align: middle;
    background-color: #d3d3d3;
}

.hide {
/*     display: none; */
}

.radio-toolbar input[type="radio"]:focus + label {
    border: 2px dashed #444;
}

.radio-toolbar label {
    display: inline-block;
    background-color: #ddd;
    font-family: sans-serif, Arial;
    font-size: 14px;
    border: 2px solid #444;
    border-radius: 4px;
}

.radio-toolbar input[type="radio"] {
  opacity: 0;
  position: fixed;
  width: 0;
}

.radio-toolbar input[type="radio"]:checked + label {
    background-color:#bfb;
    border-color: #4c4;
}

table label {
    min-height: 100%;
}
</style>

<fieldset>
    <legend> Report </legend>
	<table>

<?php
foreach ($group as $fld => $values)
{
?>
	<tr><td><?=$fld?></td><td><?=count($values)?></td></tr>
<?php
}
?>
</table>
</fieldset>

<fieldset>
    <legend> Asset Type </legend>
<?php
    echo '[ <br/>';
    foreach($group['asset_type'] as $v)
    {
?>
   		'<?=$v?>',<br />

<?php
    }
?>

</fieldset>

<fieldset>
    <legend> Manufacturer </legend>
<?php
    echo '[ <br/>';
    foreach($group['manufacturer'] as $v)
    {
?>
   		'<?=$v?>',<br />

<?php
    }
?>

</fieldset>

<fieldset>
    <legend> Model </legend>
<?php
    echo '[ <br/>';
    foreach($group['model'] as $v)
    {
?>
   		'<?=$v?>',<br />

<?php
    }
?>

</fieldset>




<?php
////////////////////////////////////////////////////////////////////////////////
// END OUTPUT
////////////////////////////////////////////////////////////////////////////////
require_once ADMIN_HTML_FOOTER;
////////////////////////////////////////////////////////////////////////////////
?>
