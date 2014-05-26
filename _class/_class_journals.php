<?php
class journals
	{
	var $tabela = 'journals';
	
	var $line;
	
	var $tipo;
	var $codigo;
	var $editor;
	var $email;
	var $path;
	var $jid;
	
		function cp_idiomas()
			{
				global $dd,$acao,$jid,$hd,$http;
				$jid = $hd->jid;
				$dd[0] = $jid;
				
				$cp = array();
				$nc = $nucleo.":".$nucleo;
				$opt = ' : ';
				$opt .= '&J:Revista Cientifica';
				$opt .= '&A:Anais de eventos';			
				
				array_push($cp,array('$H4','journal_id',$jid,True,False,''));

				$cap1 = 'Enlish <IMG SRC="'.$http.'pb/img/img_flag_en_US.png" height="40" width="60">';
				array_push($cp,array('$O 1:Sim&0:Não','jnl_idiona_en',$cap1,True,True,''));
				
				$cap1 = 'Português <IMG SRC="'.$http.'pb/img/img_flag_pt_BR.png" height="40" width="60">';
				array_push($cp,array('$O 1:Sim&0:Não','jnl_idiona_pt',$cap1,True,True,''));

				$cap1 = 'Spanish <IMG SRC="'.$http.'pb/img/img_flag_es.png" height="40" width="60">';
				array_push($cp,array('$O 1:Sim&0:Não','jnl_idiona_es',$cap1,True,True,''));

				$cap1 = 'Francês <IMG SRC="'.$http.'pb/img/img_flag_fr.png" height="40" width="60">';
				array_push($cp,array('$O 1:Sim&0:Não','jnl_idiona_fr',$cap1,True,True,''));

				return($cp);	
		}	
	
		function checa_diretorios()
			{
				global $hd;
				$sx = '';
				$dir = trim($_SERVER['DOCUMENT_ROOT']).'/reol';
				$dir .= '/public';
				$sx .= '<BR>'.$dir;
				if (!(is_dir($dir))) { mkdir($dir);  $sx .= ' <font color="blue">create!</font>';}

				$dir .= '/'.$hd->jid;
				$sx .= '<BR>'.$dir;
				if (!(is_dir($dir))) { mkdir($dir);  $sx .= ' <font color="blue">create!</font>';}

				$dira = $dir.'/capas';
				$sx .= '<BR>'.$dira;
				if (!(is_dir($dira))) { mkdir($dira);  $sx .= ' <font color="blue">create!</font>';}

				$dira = $dir.'/images';
				$sx .= '<BR>'.$dira;
				if (!(is_dir($dira))) { mkdir($dira);  $sx .= ' <font color="blue">create!</font>';}

				$dira = $dir.'/archive';
				$sx .= '<BR>'.$dira;
				if (!(is_dir($dira))) { mkdir($dira);  $sx .= ' <font color="blue">create!</font>';}
				
				return($sx);
			}
		function cp_parecer()
			{
				global $dd,$acao;
				$cp = array();
				$nc = $nucleo.":".$nucleo;
				$opt = ' : ';
				$opt .= '&J:Revista Cientifica';
				$opt .= '&A:Anais de eventos';
				
				array_push($cp,array('$H4','journal_id','journal_id',False,False,''));
				array_push($cp,array('$A4','','Parecer & Modelos',False,True,''));

				array_push($cp,array('$Q pm_codigo:pm_nome:select * from parecer_model  where pm_ativo = 1 order by pm_nome','jn_parecer','Modelo de parecer de avaliação',False,True,''));
				array_push($cp,array('$Q pm_codigo:pm_nome:select * from parecer_model  where pm_ativo = 1 order by pm_nome','jn_parecer','Modelo de parecer de reavaliação',False,True,''));
				
				return($cp);	
		}			
	
		function cp()
			{
				global $dd,$acao;
				$cp = array();
				$nc = $nucleo.":".$nucleo;
				$opt = ' : ';
				$opt .= '&J:Revista Cientifica';
				$opt .= '&A:Anais de eventos';
						
				array_push($cp,array('$H4','journal_id','journal_id',False,False,''));
				array_push($cp,array('$A4','','Dados pessoais',False,True,''));
				array_push($cp,array('$S200','jn_title','Título da publicação',True,True,''));
				array_push($cp,array('$S80','title','Título abreviado (para citação)',True,True,''));
				array_push($cp,array('$S150','editor','Nome do editor chefe',True,True,''));
				array_push($cp,array('$T50:5','description','Descrição da publicação',False,True,''));
				array_push($cp,array('$S30','path','Path',True,True,''));
				array_push($cp,array('$S150','jnl_editor','Editora/Publicador',True,True,''));
		
				array_push($cp,array('$T60:8','jnl_html_cab','cabecalho',False,True,''));
				array_push($cp,array('$T60:5','assinatura','Assinatura',True,True,''));
		
				array_push($cp,array('$[1-40]','seq','Seq',True,True,''));
				array_push($cp,array('$O 1:Sim&0:Não','enabled','Habilitado',True,True,''));
				array_push($cp,array('$Q layout_descricao:layout_cod:select * from layout where layout_ativo = '.chr(39).'S'.chr(39).' order by layout_descricao ','layout','Layout',True,True,''));
				array_push($cp,array('$S30','journal_issn','ISSN (rev. impressa)',False,True,''));

				array_push($cp,array('$S60','jn_id','ID',True,True,''));
				array_push($cp,array('$S100','jn_http','OAI-http',True,True,''));
				array_push($cp,array('$S100','jn_email','e-mail administrador',True,True,''));
			
				array_push($cp,array('$O S:Sim&N:Não','jn_send','Submissão on-line',True,True,''));
				array_push($cp,array('$O 0:Não&1:Sim','jn_send_suspense','Submissão on-line suspensa',False,True,''));
		
				array_push($cp,array('$O S:Sim&N:Não','jn_noticia','Notícias',False,True,''));
				array_push($cp,array('$O S:Sim&N:Não','jn_suplemento','Suplemento',False,True,''));
		////	//////////////////// Novos campos
				array_push($cp,array('$S15','jn_eissn','e-ISSN (rev. eletronico)',False,True,''));
				array_push($cp,array('$S20','jn_isbn','ISBN (livro)',False,True,''));
				array_push($cp,array('$S20','jnl_google','ID do Google Analytics',False,True,''));
				
				array_push($cp,array('$O '.$opt,'jnl_journals_tipo','Tipo',False,True,''));
				
				return($cp);	
		}	
	
	function mostra()
		{
			$sx = '<h1>'.$this->journal_name.'</h1>';
			$sx .='<h3>'.$this->line['jnl_issen'].'</h3>';
			return($sx);
		}
	
	function le($id)
		{
			$sql = "select * from ".$this->tabela."
					where journal_id = ".round($id);
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
				{
					$this->line = $line;
					$this->journal_name = trim($line['title']);
					$this->path = trim($line['path']);
					$this->jid = trim($line['journal_id']);
					$this->email = trim($line['jn_email']);
					$this->editor = trim($line['editor']);
					$this->codigo = trim($line['jnl_codigo']);
					$this->tipo = trim($line['jnl_journals_tipo']);
				}
		}
	function journal_resumo($issue=0)
		{
			global $jid;
			$sql = "select count(*) as total, title
						from articles 
						inner join sections on article_section = section_id 
						where articles.journal_id = ".round($jid)."
						and article_publicado <> 'N'
						group by article_section, title
						order by title
						";
			$rlt = db_query($sql);
			$tot = 0;
			$sx .= '<table class="tabela10" width="100%" border=0>';
			$sx .= '<TR>
					<TD align="left" colspan=10>
					<h2>Resumo dos trabalhos publicados</h2>';
			$sx .= '<TR>';					
			$tot = 0;
			$op = array(0,0,0,0,0,0,0,0,0,0,0,0);
			$sa = '';
			$sb = '';
			while ($line = db_read($rlt))
				{
					$tot = $tot + $line['total'];
					$sb .= '<TD align="center"><B>'.$line['total'].'</B>';
					$sa .= '<TD align="center">'.$line['title'];					
				}
			
			$sx .= '<TR align="center">'.$sa;
			$sx .= '<TR align="center" style="font-size: 30px;">'.$sb;
			$sx .= '</table>';
			if ($tot == 0) { $sx = ''; }
			return($sx);
		}
	function journal_sel($id)
		{
		global $hd;
		$sql = "select * from journals
				where journal_id = ".strzero($id,7);
		$rlt = db_query($sql);
		if ($line = db_read($rlt))
			{
			$_SESSION['journal_title'] = $line['jn_title'];
			$_SESSION['journal_id'] = $line['journal_id'];
			$_SESSION['journal_path'] = $line['path'];
			return(1);
			}
		return(0);	
		}
	function journal_usuario($jnl)
		{
		global $hd;
		$sql = "select * from usuario_journal 
			where ujn_usuario = '".strzero($hd->user_id,7)."' 
			and ujn_journal = '".strzero($jnl,7)."'	
			";
		$rlt = db_query($sql);
		if (!($line = db_read($rlt)))
			{
				$sql = "insert into usuario_journal
						( ujn_journal, ujn_usuario, ujn_views)
						values
						('".strzero($jnl,7)."','".strzero($hd->user_id,7)."',0)
						";
				$rlt = db_query($sql);
			} else {
				$xid = round($line['ujn_views']);
				if ($xid == 0)
					{
					$id = $line['id_ujn'];
					$sql = "update usuario_journal set ujn_views = ".$xid." where id_ujn = ".$id;
					$rlt = db_query($sql);
					}
			}
			return(1);
		}
	function journal_select($id)
		{
		global $hd;
		$sql = "select * from usuario_journal 
			where ujn_usuario = '".strzero($hd->user_id,7)."' 
			and ujn_journal = '".strzero($id,7)."'	
			";

		$rlt = db_query($sql);
		if ($line = db_read($rlt))
			{ $total = round($line['ujn_views']); }

		$sql = "update usuario_journal set ujn_views = ($total + 1)		
				where ujn_usuario = '".strzero($hd->user_id,7)."' 
				and ujn_journal = '".strzero($id,7)."'		
				";
		$rlt = db_query($sql);
		
		$sql = "select * from journals
				where journal_id = ".strzero($id,7);
		$rlt = db_query($sql);
		if ($line = db_read($rlt))
			{
			$_SESSION['journal_title'] = $line['jn_title'];
			$_SESSION['journal_id'] = $line['journal_id'];
			$_SESSION['journal_path'] = $line['path'];
			return(1);
			}
		return(0);
		}
	function journal_list()
		{
			global $hd;
			$tt2 = 'Publicações com uso moderado';
			$tt3 = 'Publicações com pouco uso';
			$sql = "select * from journals 
					left join usuario_journal on ujn_journal = jnl_codigo
					where (enabled = 1) and
					ujn_usuario = '".strzero($hd->user_id,7)."'
					order by ujn_views desc, title
			";
			$rlt = db_query($sql);
			$col = 99;
			$it = 0;
			$s .= '<table width="100%" class="tabela00" border=0>';
			while ($line = db_read($rlt))
			{
				$it++;
				$path = strtolower(trim($line['path']));
	
				if ($col >= 3)
				{
					$s .= '<TR valign="top">';
					$col = 0;
				}
				$img_arq = '../editora/img_edicao/capa_'.trim($path).'.png';
				$img_phi = $dir.$http_site.'editora/'.$img_arq;
				if (file_exists($img_arq))
					{ $img = $img_arq; } else { $img = '../editora/img/no_capa.jpg'; }
		
				/* Fonte */
				$font = 'font_03';
				if ($it > 6) { $font = 'font_02'; }
				if ($it > 20) { $font = 'font_01'; }
	
				/* Link */
				$link = strzero($line['journal_id'],7);
				$link = '<A HREF="publicacoes_sel.php?dd0='.$link.'&dd1='.trim($line['title']).'" 
						class="'.$font.'"
						>';
	
				/* Headers */
				if ($it==7) { $s .= '<TR><TD colspan=3><BR><h9>'.$tt2.'</h9><BR>'; }
				if ($it==21){ $s .= '<TR><TD colspan=3><BR><h8>'.$tt3.'</h8><BR>'; }
	
				if ($font == 'font_01')
				{
					$s .= '<TR>';
					$s .= '<TD align="left" colspan=3>';
					$s .= $link;
					$s .= '<style="font-size: 12px;">';
					$s .= chr(187).trim($line['title']).'</A>';
					$col = 5;
				}
		
				if ($font == 'font_02')
				{
					$s .= '<TR>';
					$s .= '<TD align="left" colspan=3>';
					$s .= $link;
					$s .= '<font style="font-size: 22px;">';
					$s .= chr(187).trim($line['title']).'</A>';
					$col = 5;
				}
				
				if ($font == 'font_03')
				{
					$s .= '<TD align="center" colspan=1 width="33%">';
					$s .= '<font style="font-size: 16px;">';
					$s .= trim($line['title']).'</A>';
					$s .= '<BR>';
					$s .= $link;
					$s .= '<img src="'.$img.'" height="148" alt="" border="0">';
					$s .= '<BR>';		

				}		
				$col++;	
			}			
			$s .= '</table>';
			return($s);
		}	
	}
?>
