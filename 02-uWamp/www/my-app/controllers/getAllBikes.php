<?php

include '../models/dao.php';

$dbObj = new Database();

$result = $dbObj->GetAllBikes();

foreach($result as $key=>$value)
{
    echo "<h1>".$value['bikFoundLocation']."</h1>";
}

?>