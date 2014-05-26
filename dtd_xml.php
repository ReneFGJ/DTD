<?php
require("db.php");
require('_class/_class_dtd_31.php');
$dtd = new dtd;

$id = 2;

require("../Reol2/_class/_class_works.php");
$wk = new works;
$wk->le($id);

$jid = 2;

/* recupera dados da publicacao */
require("_class/_class_journals.php");
$jnl = new journals;
$jnl->le($jid);



/* Marca infomacoes sobre periódico */
$dtd->set_journals($jnl->line);


header ("Content-Type:text/xml");
echo $dtd->dtd();
?>