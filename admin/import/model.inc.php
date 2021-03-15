<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpdesk/includes/prepare.inc.php';



////////////////////////////////////////////////////////////////////////////////
// FUNCTION fetch_existing_tables()
////////////////////////////////////////////////////////////////////////////////
function fetch_existing_tables()
{
    $db = new Cosmos([
        'query' => 'SHOW TABLES FROM inventory',
    ]);
    $existing_tables = [];

    $et = $db->selectAll();

    foreach ($et as $val)
    {
        $existing_tables[] = $val['Tables_in_inventory'];
    }

    return $existing_tables;
}

////////////////////////////////////////////////////////////////////////////////
// FUNCTION remove_table()
////////////////////////////////////////////////////////////////////////////////
function remove_table($table)
{
    $drop = new Cosmos([
        'query' => "DROP TABLE `{$table}`",
        'args' => [],
    ]);

    $drop->execute();

//     $drop->get_all_parameters();
}

////////////////////////////////////////////////////////////////////////////////
// FUNCTION create_table()
////////////////////////////////////////////////////////////////////////////////
function create_table_query($list, $table_name = '')
{
    global $pdo;
    global $sw_fields;
    global $sw_mapping;

    $sql['query'] = 'CREATE TABLE IF NOT EXISTS `' . $table_name . '` (
					id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, ';

    foreach ($list as $field)
    {
        if (strpos($field, 'note') !== false)
        {
            $sql['query'] .= '`' . $field . '` TEXT DEFAULT NULL'  . (end($list) == $field ? '' : ',');
        }
        else
        {
            $sql['query'] .= '`' . $field . '` VARCHAR(255) DEFAULT NULL'  . (end($list) == $field ? '' : ',');
        }
    }

    $sql['query'] .= ')';

    return $sql['query'];
}


////////////////////////////////////////////////////////////////////////////////
// FUNCTION insert_assets()
////////////////////////////////////////////////////////////////////////////////
function insert_asset($data, $table_name = '')
{
    global $pdo;
    $sql_error = [];

    // $sql['query'] = "INSERT INTO assets VALUES (NULL,?,?,?,?)";
    $sql['query'] = 'INSERT INTO `' . $table_name . '` ';
    $sql['query'] .= '(' . implode(', ', array_keys($data[0])) . ') ';
    $ph = array_fill(0, count(array_keys($data[0])), '?');
    $sql['query'] .= 'VALUES (' . implode(', ', $ph) . ')' ;

    $errors = [];
    foreach ($data as $i => $csv_item)
    {
        // reveal($csv_item);
        // attempt to edit note fields
        foreach (array_keys($csv_item) as $field)
        {
            if (strpos($field, 'note') == false)
            {
                $n = str_replace('.', ' ', $csv_item[$field]);
                $csv_item[$field] = $n;
            }
        }

        try
        {
            if (!$sql['sth'] = $pdo->prepare($sql['query']))
            {
                echo 'prepare fail';
            }
            elseif (!$sql['sth']->execute(array_values($csv_item)))
            {
                echo 'execute fail';
            }
        }
        catch (PDOException $e)
        {
            if (isset($csv_item['asset_no']) && !empty($csv_item['asset_no']))
            {
                $errors[$csv_item['asset_no']] = $e->getMessage();
            }
            else
            {
                reveal($e->getMessage());
            }
        }
    }
}