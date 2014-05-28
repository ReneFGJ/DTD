<?php
$include = '../';
require("../db.php");
require($include.'sisdoc_debug.php');

require($include.'sisdoc_autor.php');

require_once('_class/_class_dtd_31.php');
$dtd = new dtd31;

$id = 12473;

require("_class/_class_artigos.php");
$wk = new artigos;

require("_class/_class_issue.php");
$is = new issue;

$wk->le($id);
$dtd->set_article($wk->line);
$jid = $wk->line['journal_id'];
$issue = $wk->line['article_issue'];

$is->le($issue);
$dtd->set_issue($is->line);

/* recupera dados da publicacao */
require("_class/_class_journals.php");
$jnl = new journals;
$jnl->le($jid);



/* Marca infomacoes sobre periódico */
$dtd->set_journals($jnl->line);


header ("Content-Type:text/xml");
echo $dtd->dtd();
?>