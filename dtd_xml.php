<?php
require("db.php");
require('_class/_class_dtd_31.php');
$dtd = new dtd;

header ("Content-Type:text/xml");
echo $dtd->dtd();
?>