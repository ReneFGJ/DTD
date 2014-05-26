<?php
require("db.php");
$frame = $dd[81];
$verb = lowercase($dd[80]);
echo date("d/m/Y H:i:s").' '.UpperCaseSql($verb);
print_r($dd);
if (strlen($verb)==0) { $verb = 'list'; }
/* Verbos comuns 
 * list
 * insert
 * remove 
 */
require("_class/_class_autores.php");
$au = new autores;

require($include."_class_form.php");
$form = new form;

$protocolo = $dd[10];

?>
<div id="rs">
	xTELA AJAXx - verbo <B><?php echo $verb;?></B>
</div>
<?php
switch ($verb)
	{
	case 'list':
		echo $au->listar();
		echo $form->ajax_button_new(page(),$protocolo,$frame);
		break;
	case 'new':
		$cp = $au->cp_01();
		$tela = $form->editar($cp,$au->tabela);
		echo $tela;		
		break;
	case 'edit':
		break;
	case 'remove':
		break;
	default:
		echo 'Verb not found';
		break;	
	}
?>
