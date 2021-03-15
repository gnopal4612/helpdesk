<?php

class Import_CSV
{
	private $filename;
	private $raw_headers;
	private $sanitized_headers;

	private $raw_data;
	private $sanitized_data;

	// pre-made field check for mapping
	public $sw_mapping = [
	    'asset_no' => 'asset_no',
	    'serial_number' => 'serial_number',

	    'asset_type' => 'asset_type',
	    'manufacturer' => 'manufacturer',
	    'model' => 'model',

	    'location' => 'location',
	    'room' => 'room',
	    'client_user_names_semicolon_delimited' => 'clients',
	    'status' => 'status',

	    'ip_address' => 'ip_address',
	    'network_name' => 'network_name',
	    'mac_address' => 'mac_address',

	    'purchase_date' => 'purchase_date',
	    'po_number' => 'po_number',
	    'vendor' => 'vendor',
	    'warranty_type' => 'warranty_type',
	    'cost' => 'cost',

	    'notes' => 'notes',

	    'audit_date' => 'audit_date',
	    'service_contract_yn' => 'service_contract_yn',
	    'contract_expiration_date' => 'contract_expiration_date',
	    'billing_rate_name' => 'billing_rate_name',

	    'warranty_type' => 'warranty_type',
	    'child_asset_yn' => 'child_asset',
	    'related_asset_sync_keys' => 'rask',
	    'multi_install_yn_child_assets_only' => 'multi_install',
	    'install_count_child_assets_only' => 'install_count',
	    'reservable_yn' => 'reservable_yn',
	    'discovery_sync_id' => 'discovery_sync_id',

	    'delete_yn' => 'sw_delete',
	    'note___field_required_for_new_records' => 'note2'
	];

	// auto called when object is created
	function __construct($filename)
	{
	    $this->filename = $filename;
	    $this->process_csv();
	}

	function process_csv()
	{
	    $tmpfile = fopen($_SERVER['DOCUMENT_ROOT'] . '/helpdesk/assets/content/' . $this->filename, "r");

	    $i = 0;
	    while ($line = fgetcsv($tmpfile))
	    {
	        if ($i == 0)
	        {
	            // headers
	            $this->raw_headers = $line;
	            $this->set_headers($line);
	        }
	        else
	        {
	            $this->raw_data[] = $line;
	        }
	        $i++;
	    }

	    $this->set_data();

	    fclose($tmpfile);
	}


////////////////////////////////////////////////////////////////////////////////
// SETTERS
////////////////////////////////////////////////////////////////////////////////

	function set_headers($headers)
	{
	    $nheaders = [];
	    foreach ($headers as $h)
	    {
	        $nh = $this->clean($h);
	        // 			$nheaders[] = $nh;

	        if (in_array($nh, array_keys($this->sw_mapping)))
	        {
	            $nheaders[] = $this->sw_mapping[$nh];
	        }
	        else
	        {
	            $nheaders[] = $nh;
	        }
	    };

	    $this->sanitized_headers = $nheaders;

	}

	function set_data()
	{
	    $i = 1;
	    foreach ($this->raw_data as $k => $d)
	    {
	        $this->sanitized_data[$i - 1] = array_combine($this->sanitized_headers, $d);
	        $i++;
	    }

	}

////////////////////////////////////////////////////////////////////////////////
// GETTERS
////////////////////////////////////////////////////////////////////////////////

	function get_raw_headers()
	{
	    return $this->raw_headers;
	}

	function get_sanitized_headers()
	{
	    return $this->sanitized_headers;
	}

	function get_sanitized_data()
	{
	    return $this->sanitized_data;
	}

////////////////////////////////////////////////////////////////////////////////
// MISC
////////////////////////////////////////////////////////////////////////////////

	// TODO - move this to validation.inc
	function clean($string)
	{
	    $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.
	    $string = str_replace('-', '_', $string);
	    return preg_replace('/[^A-Za-z0-9\_]/', '', strtolower($string)); // Removes special chars.
	}
}