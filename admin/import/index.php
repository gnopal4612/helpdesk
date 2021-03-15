<?php
////////////////////////////////////////////////////////////////////////////////
// PREPARE
////////////////////////////////////////////////////////////////////////////////
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpdesk/includes/prepare.inc.php';
require_once 'model.inc.php';
require_once 'import_csv.inc.php';


$html = [
    'title' => 'Admin/Import/Index',
    'breadcrumb' => ''
];

////////////////////////////////////////////////////////////////////////////////
// PRE-PROCESSING
////////////////////////////////////////////////////////////////////////////////

$existing_tables = fetch_existing_tables();

////////////////////////////////////////////////////////////////////////////////
// REQUEST-PROCESSING
////////////////////////////////////////////////////////////////////////////////
if (isset($_REQUEST) && !empty($_REQUEST))
{
    // @TODO - set up cleanup
    $request = $_REQUEST;

    if (isset($request['remove_table']) && !empty($request['remove_table']))
    {
        remove_table($request['remove_table']);
    }

    if (isset($request['submit_action']) && !empty($request['submit_action']))
    {
        if ($request['submit_action'] === 'Submit CSV')
        {
            $upload = new Import_CSV($request['filename']);

            /////////////////////////////////
            // create new table based on post
            $query = new Cosmos([
                'query' => create_table_query($upload->get_sanitized_headers(), $request['table_name']),
            ]);

            $query->execute();

            /////////////////////////////////
            // create backup db of same fields
            if ($request['table_name'] == 'reference')
            {
                $backup = new Cosmos([
                    'query' => create_table_query($upload->get_sanitized_headers(), 'assets'),
                ]);

                $backup->execute();
            }

            /////////////////////////////////
            // insert data into db
            // TODO - convert this to something else
            insert_asset($upload->get_sanitized_data(), $request['table_name']);

        } // end if (request[submit action])
    }
}

////////////////////////////////////////////////////////////////////////////////
// OUTPUT
////////////////////////////////////////////////////////////////////////////////

require_once ADMIN_HTML_HEADER;

////////////////////////////////////////////////////////////////////////////////

?>

<div class="">
    <form action="<?=$_SERVER['SCRIPT_NAME']?>" method="post">
<?php
if (!empty($existing_tables))
{
?>
        <fieldset>
            <legend><label>Existing Table</label></legend>
            <table>
            	<tr>
            		<th>Table</th>
            		<th>View</th>
            		<th>Drop</th>
            		<th>Duplicate</th>
            	</tr>
<?php
    foreach ($existing_tables as $table)
    {
?>
                <tr>
                    <td><?=$table?></td>
                    <td><a href="http://localhost:8080/helpdesk/search/index.php?tb=<?=$table?>" target="_blank">(view)</a></td>
                    <td><input type="submit" name="remove_table" value="<?=$table?>"></td>
                    <td><a href="http://localhost:8080/helpdesk/crud/duplicate-table.php?dpe=<?=$table?>">(dupe)</a></td>
                </tr>
<?php
    }
?>
            </table>
        </fieldset><br />
<?php
}
?>
        <fieldset>
            <legend><label>Import</label></legend>
            <table>
                <tr>
                    <td>
                        <input name="table_name" value="<?=isset($request['table_name']) && !empty($request['table_name']) ? $request['table_name'] : ''?>" placeholder="tablename">
                    </td>
                    <td><input type="file" name="filename"></td>
                    <td><input type="submit" name="submit_action" value="Submit CSV"></td>
                </tr>
            </table>
        </fieldset>
    </form>
</div>




























<?php
////////////////////////////////////////////////////////////////////////////////
// END OUTPUT
////////////////////////////////////////////////////////////////////////////////
require_once ADMIN_HTML_FOOTER;
////////////////////////////////////////////////////////////////////////////////
?>
