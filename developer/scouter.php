<?php
////////////////////////////////////////////////////////////////////////////////
// PREPARE
////////////////////////////////////////////////////////////////////////////////
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpdesk/includes/prepare.inc.php';


////////////////////////////////////////////////////////////////////////////////
// REQUEST-PROCESSING
////////////////////////////////////////////////////////////////////////////////
?>
<link href="<?=BASE_URL?>assets/vendor/bootstrap-4.5.3-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<?php

function recursive_display($data, $i = 0)
{
    $tabsize = 20;
    foreach ($data as $key => $value)
    {
        $i++;

        if (is_string($value))
        {
?>
		<span style="padding-left: <?=($tabsize * $i)?>px">'<?=$key?>'</span> => '<?=$value?>'<br />
<?php
        }
        elseif (is_array($value))
        {
?>
            <span style="padding-left: <?=($tabsize * $i)?>px">'<?=$key?>'</span><br />
<?php
            recursive_display($value, $i);
        }

        $i--;
    }
}

echo '<div class="container" style="font-size: 12px; border: 1px solid #fa6605;">';
recursive_display($_REQUEST);
echo '</div>';





















