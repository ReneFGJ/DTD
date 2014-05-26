<?php
require("cab.php");

require($include.'_class_form.php');
$form = new form;

require("_class/_class_autores.php");
$au = new autores;

$cp = $au->cp();

$tela = $form->editar($cp,$au->tabela);
echo $tela;
?>
