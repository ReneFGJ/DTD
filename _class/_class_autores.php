<?php
class autores
	{
		var $tabela = 'articles_authors';
		
		function listar()
			{
				$sql = "select * from ".$this->tabela." where 1=1 ";
				$rlt = db_query($sql);
				$sx = '<table width="100%" class="tabela00">';
				$sx .= '<TR><TD>Tit.<TD>Nome<TD>e-mail<TD>Instituição';
				while ($line = db_read($rlt))
					{
						$sx .= '<TR>';
						$sx .= '<TD>';
						$sx .= 'Nome';
					}
				$sx .= '</table>';
				return($sx);
			}
		function cp()
			{
				$cp = array();
				array_push($cp,array('$H8','id_qa','',False,True));
				array_push($cp,array('$S100','qa_nome','Nome',False,True));
				array_push($cp,array('$AJAX ajax_dtd_autor.php:0000005','','Autores',False,True));
				return($cp);
			}
		function cp_01()
			{
				$cp = array();
				array_push($cp,array('$H8','id_qa','',False,True));
				array_push($cp,array('$S100','qa_nome','Nome',False,True));
				return($cp);
			}
		function db_prefix()
			{
				$sql = "select * from apoio_titulacao order by ap_tit_titulo";
				$rlt = db_query($sql);
				$op = '';
				while ($line = db_read($rlt))
					{
						if (strlen($op) > 0) { $op .= '&'; }
						$op .= trim($line['ap_tit_codigo']).':'.$line['ap_tit_titulo'];
					}
				return($op);
			}
		
		function structure()
			{
				$sql = "drop table articles_authors";
				//$rlt = db_query($sql);
				
				$sql = '
					CREATE TABLE articles_authors
					( 
					id_qa serial NOT NULL, 
					qa_nome char(100), 
					qa_nome_asc char(100), 
					qa_lattes char(100), 
					qa_titulo char(3), 
					qa_email char(100), 
					qa_protocolo char(7), 
					qa_update int4 DEFAULT 0, 
					qa_cpf char(20), 
					qa_instituicao char(7), 
					qa_telefone char(40), 
					qa_mini text, 
					qa_pais char(20), 
					qa_estado char(20), 
					qa_cidade char(40), 
					qa_ajax_cidade char(7), 
					qa_ordem char(3), 
					qa_instituicao_alt char(100) 
					);';
				$rlt = db_query($sql);
			}
	}
?>
