<?php

$selected_fields = [
    'asset_no',
    'serial_number',

    'asset_type',
    'manufacturer',
    'model',

    'location',
    'room',
    'status',
    'clients',

    'network_name',
    'po_number',
    'notes',
];

$reset_fields = [
	'location',
	'room',
	'status',
	'clients',
	'notes'
];

$selects = [
    'status' => [
        'Ready to Deploy',
        'Deployed',
        'Virtual',
        'Surplus',
        'Repair Needed',
    ],
    'location' => [
        'Daughtry Elementary School' => [
            '201', '202', '203', '204', '205', '206', '207', '208', '209', '210', '211',
            '301', '302', '303', '304', '305', '306', '307', '308', '309', '310',
            '401', '402', '403', '404', '405', '406', '407', '408', '409',
            '501', '502', '503', '504', '505', '506', '507', '508', '509', '510',
            'Gym', 'Cafeteria', 'Media', 'Workroom', 'Front Office',
            '101', '105', '106', '107', '108', '109',
            '103.05', '103.07', '103.09', '103.12', '103.14', '103.15', '103.16'],
        'Jackson Elementary School' => [
            '100'
        ],
        'Stark Elementary School' => [
            '101'
        ],
        'Henderson Middle School' => [
            '102'
        ],
        'Jackson High School' => [
            '103'
        ],
        'Central Office' => [
            '104'
        ],
        'New Beginnings Academy' => [
            '105'
        ],
        'Bus Shop' => [
            '106'
        ],
    ],
];


////////////////////////////////////////////////////////////////////////////////
// function fetch_all_from_current
////////////////////////////////////////////////////////////////////////////////
function fetch_all_from_current($asset_no)
{
    global $selected_fields;
    /////////////////////////////////////
    // fetch from current assets database
    $check = new Cosmos([
        'table' => 'current_asset',
        'fields' => $selected_fields,
        'where' => [
            ['asset_no', '=', $asset_no],
        ],
    ]);

    return $check->selectAll();
}

////////////////////////////////////////////////////////////////////////////////
// function fetch_all_from_current
////////////////////////////////////////////////////////////////////////////////
function fetch_from_current($asset_no)
{
    global $selected_fields;
    /////////////////////////////////////
    // fetch from current assets database
    $check = new Cosmos([
        'table' => 'current_asset',
        'fields' => $selected_fields,
        'where' => [
            ['asset_no', '=', $asset_no],
        ],
    ]);

    return $check->select();
}

////////////////////////////////////////////////////////////////////////////////
// function fetch_all_from_reference
////////////////////////////////////////////////////////////////////////////////
function fetch_all_from_reference($asset_no)
{
    global $selected_fields;
    /////////////////////////////
    // fetch from reference database
    $ref_check = new Cosmos([
        'table' => 'reference',
        'fields' => $selected_fields,
//       'where' => [
//          ['asset_no', '=', $request['form']['search']],
        'orWhere' => [
            ['asset_no', '=', $asset_no],
            ['serial_number', '=', $asset_no],
            ['network_name', 'LIKE', '%'. $asset_no . '%']
        ],
    ]);

    return $ref_check->selectAll();
}

////////////////////////////////////////////////////////////////////////////////
// function fetch_all_from_reference
////////////////////////////////////////////////////////////////////////////////
function display_asset_form($asset)
{
    global $selected_fields;
    global $selects;

    foreach ($selected_fields as $fld)
    {
?>
    	<div class="display-results">
<?php
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
			<input type="text" id="<?=$fld?>" name="asset[<?=$fld?>]" value="<?=$asset[$fld]?>" style="width: 100%; height: 100%;" placeholder="--<?=$fld?>--">
<?php
		}
?>
		</div>
<?php
    }
}

////////////////////////////////////////////////////////////////////////////////
// function fetch_all_from_reference
////////////////////////////////////////////////////////////////////////////////
function display_db_results($results, $type)
{
    global $selected_fields;

    $ri = 0;
    foreach ($selected_fields as $fld)
    {
        ?>
	<div class="display-results text-center radio-toolbar">
		<input type="radio" name="radio_<?=$fld?>" id="<?=$type?>_radio_<?=$fld?>_<?=$ri?>" onchange="selectOption('<?=$fld?>', '<?=$results[$fld]?>')">
    	<label for="<?=$type?>_radio_<?=$fld?>_<?=$ri?>" class="clickable"><?=$results[$fld]?></label>
	</div>
<?php
    $ri++;
    }
}

////////////////////////////////////////////////////////////////////////////////
// function insert_into_current_assets
////////////////////////////////////////////////////////////////////////////////
function insert_into_current_assets($data)
{
    global $pdo;
    $errors = [];

    // $sql['query'] = "INSERT INTO assets VALUES (NULL,?,?,?,?)";
    $sql['query'] = 'INSERT INTO `current_asset` ';
    $sql['query'] .= '(' . implode(', ', array_keys($data)) . ') ';
    $ph = array_fill(0, count(array_keys($data)), '?');
    $sql['query'] .= 'VALUES (' . implode(', ', $ph) . ')' ;

    try
    {
        if (!$sql['sth'] = $pdo->prepare($sql['query']))
        {
            echo 'prepare fail';
        }
        elseif (!$sql['sth']->execute(array_values($data)))
        {
            echo 'execute fail';
        }
    }
    catch (PDOException $e)
    {
        if (isset($data['asset_no']) && !empty($data['asset_no']))
        {
            $errors[$data['asset_no']] = $e->getMessage();
        }
        else
        {
            reveal($e->getMessage());
        }

        // reveal($e->getMessage());
    }
}

////////////////////////////////////////////////////////////////////////////////
// function insert_into_current_assets
////////////////////////////////////////////////////////////////////////////////
function update_current_asset($asset)
{
    global $pdo;
    $errors = [];
    $sql_flds = [];
    $query = [];

    $fields = array_keys($asset);
    foreach ($fields as $key)
    {
        $sql_flds[] = $key . ' = ?' . ($key == end($fields) ? '' : ',');
    }

    $query[] = 'UPDATE `current_asset` ';
    $query[] = 'SET ' .implode(' ', $sql_flds);
    $query[] = 'WHERE `asset_no` = ?';

    $sql = [
        'query' => implode(' ', $query),
        'args' => array_values($asset),
    ];

    $sql['args'][] = $asset['asset_no'];

    try
    {
        if (!$sql['sth'] = $pdo->prepare($sql['query']))
        {
            echo 'prepare fail';
        }
        elseif (!$sql['sth']->execute(array_values($sql['args'])))
        {
            echo 'execute fail';
        }
    }
    catch (PDOException $e)
    {
        if (isset($asset['asset_no']) && !empty($asset['asset_no']))
        {
            $errors[$asset['asset_no']] = $e->getMessage();
        }
        else
        {
            reveal($e->getMessage());
        }

        // reveal($e->getMessage());
    }
}

////////////////////////////////////////////////////////////////////////////////
// function display_locations()
////////////////////////////////////////////////////////////////////////////////
function display_locations_field($location)
{
	global $selects;
    $selects['schools'] = array_keys($selects['location']);

?>
		<select name="asset[location]" style="width: 100%; height: 100%;">
            <option value="">--location--</option>
<?php
            foreach ($selects['schools'] as $school)
            {
?>
            <option value="<?=$school?>" <?=($school == $location  ? 'selected' : '')?>><?=$school?></option>
<?php
            }
?>
		</select>
<?php
}

////////////////////////////////////////////////////////////////////////////////
// function display_locations()
////////////////////////////////////////////////////////////////////////////////
function display_status_field($status)
{
	global $selects;
?>
		<select name="asset[status]" style="width: 100%; height: 100%;">
			<option value="">--status--</option>
<?php
    foreach ($selects['status'] as $stat)
    {
?>
        	<option value="<?=$stat?>" <?=($stat == $status ? 'selected' : '')?>> <?=$stat?></option>
<?php
    }
?>
		</select>
<?php
}

////////////////////////////////////////////////////////////////////////////////
// function display_form_table()
////////////////////////////////////////////////////////////////////////////////
function display_form_table($asset)
{
	global $selected_fields;
?>
	    	<table>
	    		<tr>
	    			<td></td>
<?php
    foreach ($selected_fields as $fld)
    {
		echo '<td>';
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
			<input type="text" id="<?=$fld?>" name="asset[<?=$fld?>]" value="<?=$asset[$fld]?>" style="width: 100%; height: 100%;" placeholder="<?=$fld?>">
<?php
		}
		echo '</td>';
	}
?>
				</tr>
			</table>
<?php
}
































