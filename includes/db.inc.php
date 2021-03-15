<?php
// echo 'db.inc.php <br />';
/* Connect to a MySQL database using driver invocation */

$host = '127.0.0.1';
$db   = 'inventory';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// $dsn = 'mysql:dbname=inventory;host=127.0.0.1';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try
{
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
    echo 'Connection failed: ' . $e->getMessage();
}


class Cosmos
{
    private $query;
    private $args = [];

    private $fields = ['*'];
    private $table = '';
    private $where = '';

    private $request;
    private $errors = [];

    // auto called when object is created
    function __construct($request)
    {
		if (isset($request['query']) && !empty($request['query']))
		{
			$this->query = $request['query'];
		}
		else
		{
		    if (isset($request['table']) && !empty($request['table']))
		    {
		        $this->table = $request['table'];
		    }

	        if (isset($request['fields']) && !empty($request['fields']))
	        {
	            $this->fields = $request['fields'];
	        }

	        if (isset($request['where']) && !empty($request['where']))
	        {
				$where_clause[] = 'WHERE';
				$count = 1;
				foreach ($request['where'] as $clause)
				{
				    $where_clause = array_merge($where_clause, ["`$clause[0]`", $clause[1], '?']);

					if ($clause[1] == 'LIKE')
					{
					    $this->args[] = "%{$clause[2]}%";
					}
					else
					{
					    $this->args[] = $clause[2];
					}

					if ($count != count($request['where']))
					{
						$where_clause[] = 'AND';
					}

					$count++;
				}
			}

			if (isset($request['orWhere']) && !empty($request['orWhere']))
	        {
				$where_clause[] = 'WHERE';
				$count = 1;
				foreach ($request['orWhere'] as $clause)
				{
					$where_clause = array_merge($where_clause, [$clause[0], $clause[1], '?']);
					$this->args[] = $clause[2];

					if ($count != count($request['orWhere']))
					{
						$where_clause[] = 'OR';
					}

					$count++;
				}
			}

			$this->where .= implode(' ', $where_clause);

		    if (isset($request['args']) && !empty($request['args']))
		    {
		        $this->args = $request['args'];
		    }
		}
    }

	function selectAll()
	{
		if (empty($this->query))
		{
			$this->query = 'SELECT ' . implode(', ', $this->fields) . ' FROM `' . $this->table . '` ' . $this->where;

		}

		return $this->fetchAll();;
	}

	function select()
	{
	    if (empty($this->query))
	    {
	        $this->query = 'SELECT ' . implode(', ', $this->fields) . ' FROM `' . $this->table . '` ' . $this->where;
	    }

	    return $this->fetch();;
	}

	function fetch()
	{
	    global $pdo;

	    try
	    {
	        if (!$sth = $pdo->prepare($this->query))
	        {
	            // TODO: custom message
	            $this->errors[] = 'prepare fail - (' . $this->query . ')';
	        }
	        elseif (!$sth->execute($this->args))
	        {
	            // TODO: custom message
	            $this->errors[] = 'args fail - [' . implode(',' , $this->args) . '] ';
	        }

	        $data = $sth->fetch(PDO::FETCH_ASSOC);

	        return $data;
	    }
	    catch (PDOException $e)
	    {
	        $this->errors[] = $e->getMessage();
	    }
	}

   	function fetchAll()
    {
        global $pdo;

        try
        {
            if (!$sth = $pdo->prepare($this->query))
            {
                // TODO: custom message
                $this->errors[] = 'prepare fail - (' . $this->query . ')';
            }
            elseif (!$sth->execute($this->args))
            {
                // TODO: custom message
                $this->errors[] = 'args fail - [' . implode(',' , $this->args) . '] ';
            }

            $data = $sth->fetchALL(PDO::FETCH_ASSOC);

            return $data;
        }
        catch (PDOException $e)
        {
            $this->errors[] = $e->getMessage();
        }
    }

    function get_all_parameters()
    {
        reveal([
            'query' => $this->query,
            'args' => $this->args,

			'table' => $this->table,
			'fields' => $this->fields,
			'where' => $this->where,

            'errors' => $this->errors,
        ]);
    }

	function execute()
	{
        global $pdo;

        try
        {
            if (!$sth = $pdo->prepare($this->query))
            {
                // TODO: custom message
                $this->errors[] = 'prepare fail - (' . $this->query . ')';
            }
            elseif (!$sth->execute($this->args))
            {
                // TODO: custom message
                $this->errors[] = 'args fail - [' . implode(',' , $this->args) . '] ';
            }

        }
        catch (PDOException $e)
        {
            $this->errors[] = $e->getMessage();
        }
	}























}