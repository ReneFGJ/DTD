<?php
class dtd31
	{
	var $journal_name = 'Revista Fisioterapia e Movimento';
	var $journal_name_abrev = 'Rev. Fisio. Mov.';
	var $issn = '1950-9089';
	var $issn_e = '1980-5918';
	var $publisher = 'PontifÌcia Universidade CatÛlica do Paran√°';
	
	var $titulo = 'Titulo';
	var $titulo_alt = 'Titulo alternativo';
	
	var $idioma = 'pt';
	var $idioma_alt = 'en';
	
	var $volume = '27';
	var $numero = '1';
	var $artigo = 'a01';
	
	var $pagi = '1';
	var $pagf = '11';
	
	var $data_pub = 20140105;
	var $data_recebido = 20140105;
	var $data_aceito = 20140105;
	
	var $resumo = '';
	var $resuno_alt = '';
	
	var $texto = array();
	
	var $palavra_chave = array();
	var $palavra_chave_alt = array();
	
	/* Contadores */
	var $count_table = 0;
	var $count_ref = 0;
	var $count_fig = 0;
	var $count_equation = 0;
<<<<<<< HEAD
	var $count_page = 0;	
	
	var $dtd_back = '';	
=======
	var $count_page = 0;		
>>>>>>> 954cb7ff989d77e986f88039d34946ac9948fd5b
	
	var $doi = '10.1590/1950-9089-v27n1a01';
	
	function encode($sx)
		{
			$sx = troca($sx,'<','&lt;');
			$sx = troca($sx,'>','&gt;');
			$sx = troca($sx,' & ',' &amp; ');
			$sx = utf8_encode($sx);
			return($sx);
		}
	function issn($issn)
		{
			$issn = substr($issn,0,9);
			$issn = troca($issn,'-','');
			$issn = troca($issn,' ','');
			if (strlen($issn) == 8)
				{
					$issn = substr($issn,0,4).'-'.substr($issn,4,4);
				} else {
					$issn = '';
				}
			return($issn);
		}
	
	function dtd()
		{
			$sx = $this->dtd_article();
			/* Front */
			$sx = troca($sx,'[front]',$this->dtd_front());
			$sx = troca($sx,'[body]',$this->dtd_body());
			$sx = troca($sx,'[back]',$this->dtd_back);
			
			//$sx = utf8_encode($sx);
			return($sx);
		}
		
<<<<<<< HEAD
	function set_refs($rf)
		{
			$sx = '';
			for ($r=0;$r < count($rf);$r++)
				{
					$tipo = $rf[$r]['ac_tipo_obra'];

					switch ($tipo)
						{
						case 'A':
							$sx .= $this->dtd_ref_journal($rf[$r]);
							break;
						case 'L':
							$sx .= $this->dtd_ref_book($rf[$r]);
							break;
						default:
							break;
						}
				}
			$this->count_ref = count($rf);
			$this->dtd_back = '<back>'.$sx.'</back>';
			
		}
=======
>>>>>>> 954cb7ff989d77e986f88039d34946ac9948fd5b
	function set_article($line)
		{
			$titulo = trim($line['article_title']); $subtitulo = '';
			
			if (strpos($titulo,':') > 0)
				{
					$pos = strpos($titulo,':');
					$subtitulo = substr($titulo,($pos+1),strlen($titulo));
					$titulo = substr($titulo,0,($pos)); 
				}
				
			$this->titulo = $this->encode($titulo);
			$this->subtitulo = $this->encode($subtitulo);
			
			$this->titulo_alt = $this->encode(trim($line['article_2_title']));
			
			$this->resumo = $this->encode(trim($line['article_abstract']));
			$this->resumo_alt = $this->encode(trim($line['article_2_abstract']));
			
			$this->keyword = $this->encode(trim($line['article_keywords']));
			$this->keyword_alt = $this->encode(trim($line['article_2_keywords']));			
			
			
			$this->idioma = $this->encode(trim($line['article_idioma']));
			$this->idioma_alt = $this->encode(trim($line['article_2_idioma']));
			
			$this->doi = $this->encode(trim($line['article_doi']));
			$this->autores = trim($line['article_author']);			
			
			$this->data_recebido = $line['article_dt_envio'];
			$this->data_aceito = $line['article_dt_aceite'];
			
			$page = trim($line['article_pages']);
			$page = troca($page,' ','-');

			if (strpos($page,'-') > 0)
				{
					$pos = strpos($page,'-');
					$this->pagi = substr($page,0,$pos);
					$this->pagf = substr($page,$pos+1,strlen($page));
					$this->count_page = ($this->pagf - $this->pagi + 1);
				} else {
					$this->pagi = $page;
					$this->pagf = '';
					$this->count_page = 1;
				}
		}
	function set_issue($line)
		{
			$this->volume = trim($line['issue_volume']);
			$this->numero = trim($line['issue_number']);
			$this->data_pub = $line['issue_dt_publica'];
			//$this->data_pub = $line['article_dt_aceite'];
		}
	function set_journals($line)
		{
			$this->journal_name = $this->encode(trim($line['jn_title']));
			$this->journal_name_abrev = $this->encode(trim($line['title']));
			$this->issn = $this->issn(trim($line['journal_issn']));
			$this->issn_e = $this->issn(trim($line['jn_eissn']));
			$this->publisher = $this->encode(trim($line['jnl_editor']));
		}
		
	function autor_meta($sx, $meta)
		{
			$meta = trim($meta);	
			$pos = strpos(' '.$sx,$meta);
			if ($pos > 0)
				{
					$sx = substr($sx,$pos+strlen($meta)-1,strlen($sx));
					$sx = substr($sx,0,strpos($sx,'['));
				} else {
					$sx = '';
				}
			return($sx);
		}
	function remove_marks($txt)
		{
			$txt = ' '.$txt;
			while (strpos($txt,'['))
				{
					$pos = strpos($txt,'[');
					if ($pos > 0)
						{
							$p1 = substr($txt,0,$pos);
							$p2 = substr($txt,$pos,strlen($txt));
							$p2 = substr($p2,strpos($p2,']')+1,strlen($txt));
							$txt = $p1.' '.$p2;
						}
				}
			return($txt);
		}
		
	function dtd_autores()
		{
			$autor = $this->autores;
			$autor = troca($autor,chr(13),'#');
			$aut = splitx('#',$autor.'#');

			$aff = '';
			
			$sx = '<contrib-group>';
			for ($r=0;$r < count($aut);$r++)
				{
				$atc = $aut[$r];
				if (strpos($atc,';') > 0)
					{
						$at = trim(substr($atc,0,strpos($atc,';')));
						$ats = substr($atc,strpos($atc,';')+1,1024);
					} else {
						$at = $atc;
						$ats = '';
					}
					
					
				$att = nbr_autor($at,7);
				$att2 = nbr_autor($att,1);

				$pos = strpos($att2,',');

				$surname = trim(substr($att2,0,$pos));
				$name = trim(substr($att2,$pos+1,strlen($att2)));
				$sufixo = $this->autor_meta($ats,'[suf]');
				$prefixo = $this->autor_meta($ats,'[pre]');
				$instituicao = $this->autor_meta($ats,'[org]');
				$departamento = $this->autor_meta($ats,'[dep]');
				$cidade = $this->autor_meta($ats,'[city]');
				$estado = $this->autor_meta($ats,'[state]');
				$pais = $this->autor_meta($ats,'[country]');
				$biografia = $this->remove_marks($ats);
				$email = $this->autor_meta($ats,'[email]');
				
				$corresp = 'yes';
				if ($r > 0) { $corresp = 'no'; }	
				$sx .= '
				<contrib contrib-type="author" corresp="'.$corresp.'">
	   				<name>
  						<surname>'.$surname.'</surname>
  						<given-names>'.$name.'</given-names>
  						<prefix>'.$prefixo.'</prefix>
  						<suffix>'.$sufixo.'</suffix>
					</name>
    				<xref ref-type="aff" rid="aff'.($r+1).'">['.($r+1).']</xref>			
				</contrib>
				';	
				$aff .= '
					<aff id="aff'.($r+1).'">
					<label>'.($r+1).'</label>
					<institution content-type="orgdiv2">'.$departamento.'</institution>
					<institution content-type="orgname">'.$instituicao.'</institution>
						<addr-line>
							<named-content content-type="city">'.$cidade.'</named-content>
							<named-content content-type="state">'.$estado.'</named-content>
						</addr-line>
						<country>'.$pais.'</country>
						<institution content-type="original">'.$biografia.'
						<named-content content-type="email">'.$email.'</named-content>
					</institution>
					</aff>				
				';
				}
			$sx .= '</contrib-group>';
			$sx .= $aff;
			$this->aff = $aff;
			return($sx);
		}
		
	function dtd_pub_date()
		{
			$sx = '
			<pub-date pub-type="epub-ppub">
            	<day>'.substr($this->data_pub,6,2).'</day>
            	<month>'.substr($this->data_pub,4,2).'</month>
            	<year>'.substr($this->data_pub,0,4).'</year>
    		</pub-date>
    		<volume>'.$this->volume.'</volume>
			<issue>'.$this->numero.'</issue>
			<fpage>'.$this->pagi.'</fpage>
			<lpage>'.$this->pagf.'</lpage>
			<history>
			<pub-date pub-type="received">
            	<day>'.substr($this->data_recebido,6,2).'</day>
            	<month>'.substr($this->data_recebido,4,2).'</month>
            	<year>'.substr($this->data_recebido,0,4).'</year>
    		</pub-date>
			<pub-date pub-type="accepted">
            	<day>'.substr($this->data_aceito,6,2).'</day>
            	<month>'.substr($this->data_aceito,4,2).'</month>
            	<year>'.substr($this->data_aceito,0,4).'</year>
    		</pub-date>    		
			</history>
			';
			return($sx);
			
		}
	
	function dtd_license()
		{
			$sx = '
				<permissions>
					<license xlink:href="http://creativecommons.org/licenses/by-nc/3.0/" license-type="open-access">
					<license-p>This is an Open Access article distributed under the terms of the Creative Commons Attribution Non-Commercial License, which permits unrestricted non-commercial use, distribution, and reproduction in any medium, provided the original work is properly cited.</license-p>
				</license>
				</permissions>			
			';
			return($sx);
		}
		
	function dtd_article_meta()
		{
			/* DOI */
			$sx = '<article-meta>';
			if (strlen($this->doi) > 0)
				{
					$sx .= '<article-id pub-id-type="doi">'.$this->doi.'</article-id>'.chr(13).chr(10);
				}

			$sx .= '
			<article-categories>
    			<subj-group subj-group-type="heading">
    				<subject>Original Article</subject>
    			</subj-group>
			</article-categories>
			<title-group>		
    			<article-title xml:lang="'.$this->idioma.'">'.$this->titulo.'</article-title>
        		<subtitle>'.$this->subtitulo.'</subtitle>
				<trans-title-group xml:lang="'.$this->idioma_alt.'">
      				<trans-title>'.$this->titulo_alt.'</trans-title>
    			</trans-title-group>
 			</title-group>			
			';
			
			$sx .= $this->dtd_autores();
			$sx .= $this->dtd_pub_date();
			$sx .= $this->dtd_license();
			$sx .= $this->dtd_abstract();
			$sx .= $this->dtd_counts();
			$sx .= '</article-meta>';
			return($sx);
		}
		
	function dtd_abstract()
		{
			$sx .= '
				<abstract xml:lang="'.$this->idioma.'">
        			<p>'.$this->resumo.'</p>
     			</abstract>
				<trans-abstract xml:lang="'.$this->idioma_alt.'">
        			<p>'.$this->resumo_alt.'</p>
     			</trans-abstract>
     			
				<kwd-group xml:lang="'.$this->idioma.'">
				';
				for ($r=0;$r < count($this->palavra_chave);$r++)
					{
						$sx .= '<kwd>'.$this->palavra_chave[$r].'</kwd>';
					}
         		$sx .= '
				</kwd-group>
				
				<trans-kwd-group xml:lang="'.$this->idioma.'">
				';
				for ($r=0;$r < count($this->palavra_chave_alt);$r++)
					{
						$sx .= '<kwd>'.$this->palavra_chave_alt[$r].'</kwd>';
					}
         		$sx .= '
				</trans-kwd-group>			
			';
			return($sx);
		}

	function dtd_body()
		{
			$sx = '
			<body>
			<sec sec-type="intro">
     			<title>Introduction</title>
     			<p>xxxxxxxxxxxxxxxxxx</p>
  				<p>xxxxxxxxxxxxxxxxxx</p>
			</sec>
			</body>
			';
			return($sx);
			
		}
		
	function dtd_marked($protocolo)
		{
			$sql = "select * from ".$this->tabela." where ac_protocolo = '$protocolo' order by ac_ord ";
			$rlt = db_query($sql);
			while ($line = db_read($rlt))
				{
				}
		}
		

	function dtd_back()
		{
			$sx = '
			<back>
			'.$this->dtd_agradecimento();
			
			
			
			$sx .= $this->dtd_ref_journal();
			$sx .= $this->dtd_ref_book();
			
  			$sx .= '</back>';
			return($sx);
		}
		
	function dtd_ref_book($ref)
		{
			$rf = $ref['ac_dtd'];
			$obra = trim($ref['ac_tipo_obra']);
			$tipo_autor = trim($ref['ac_tipo']);
			
			
			$nref = $this->encode(trim($ref['ac_ref']));
			$no = $this->encode($this->recupera($rf,'no'));
			$autores = $this->recupera_autor_pessoal($rf);
			/* Journal */
			$journal = $this->recupera($rf,'pubname');
			if (substr($journal,0,1) == '.')
				{
					$journal = trim(substr($journal,1,strlen($journal)));
				}
			/* Issue e Volume */
			$issue = $this->recupera($rf,'issueno');
			$vol = $this->recupera($rf,'volid');
			
			/* Pages */
			$page = $this->recupera($rf,'page');
			$pagi = ''; $pagf = '';	
			$edicao = $this->recupera($rf,'edition');
			if (strlen($edicao)=='0') { $edicao = '1'; }
			$cidade = $this->recupera($rf,'city');
			$estado = $this->recupera($rf,'state');
			$pais = $this->recupera($rf,'coutry');
			$local = $cidade;
			if (strlen($estado) > 0) { $local .= '-'.$estado; }
			if (strlen($pais) > 0) { $local .= ', '.$pais; }
			
			/* Pages */
			$page = $this->recupera($rf,'page');
			$pagi = ''; $pagf = '';
			if (strlen($page) > 0)
				{
					if (strpos($page,'-') > 0)
						{
							$pagi = substr($page,0,strpos($page,'-'));
							$pagf = substr($page,strpos($page,'-')+1,20);
						} else {
							$pagi = $page;
							$pagf = '';							
						}
				}
			
			/* Recupera ano */
			$ano = $this->recupera_ano($rf);
			/* Idioma */
			$idioma = $this->recupera_idioma($rf);
			$rf = troca($rf,' language="pt"','');
			$rf = troca($rf,' language="en"','');
			$rf = troca($rf,' language="fr"','');
			$rf = troca($rf,' language="es"','');
			$titulo = $this->encode($this->recupera($rf,'title'));
			$titulo_s = $this->encode($this->recupera($rf,'subtitle'));
			if (strlen($titulo_s) > 0)
				{ $titulo = trim($titulo.': '.$titulo_s); }				
			
				
			$sx = '
			<ref id="B'.strzero($no,3).'">
        		<label>'.$no.'</label>
        		<mixed-citation>'.$nref.'</mixed-citation>
      			<element-citation publication-type="book">';
				
			if ($tipo_autor=='A')
				{
				$sx .= '<person-group person-group-type="author">'.chr(13).chr(10);
				for ($r=0;$r < count($autores);$r++) {
					$sx .= '
               				<name>
                      		<surname>'.$autores[$r][0].'</surname>
	                      		<given-names>'.$autores[$r][1].'</given-names>
               				</name>'.chr(13).chr(10);
					}
				$sx .= '</person-group>';
				} else {
					echo 'ERRO TIPO DE AUTOR - LIVRO';
					echo '<BR>'.$nref;
					exit;
				}
			$sx .= '
          			<source>'.$titulo.'</source>
          			<edition>'.$edicao.'</edition>
          			<publisher-loc>'.$local.'</publisher-loc>
          			<publisher-name>'.$journal.'</publisher-name>
         			<year>'.$ano.'</year>
	    			<size units="page">'.$page.'</size>
    			</element-citation>
			</ref>			
			';
			return($sx);
		}
	function recupera($ref,$op)
		{

			$op = '['.trim($op).']';
			$pos = strpos(' '.$ref,$op);

			if ($pos > 0)
				{
					$vlr = substr($ref,$pos+strlen($op)-1,1024);
					$pos = strpos($vlr,'[');
					$vlr = substr($vlr,0,$pos);
					return($vlr);
					exit;
				}
			return('');
		}
	function recupera_autor_pessoal($ref)
		{
			$ref = troca($ref,'[oauthor role="nd"]',';#');
			$ref = troca($ref,'[/oauthor]',';');
			$ref = troca($ref,'[surname]','');
			$ref = troca($ref,'[/surname]','');
			$ref = troca($ref,'[fname]','#');
			$ref = troca($ref,'[/fname]','');
			
			$au = splitx(';',$ref);
			$aurs = array();
			for ($r=0;$r < count($au);$r++)
				{
					$nm = trim($au[$r]);
					if (substr($nm,0,1) == '#')
						{
						$tt = split('#',substr($nm,1,strlen($nm)));
						array_push($aurs,$tt);
						}
				}
			return($aurs);
		}
		
	function recupera_idioma($ref)
		{
			if (strpos($ref,'"en"') > 0) { return('en'); }
			if (strpos($ref,'"pt"') > 0) { return('pt'); }
			if (strpos($ref,'"fr"') > 0) { return('fr'); }
			if (strpos($ref,'"es"') > 0) { return('es'); }
			return('??');
		}
	function recupera_ano($ref)
		{
			$pos = strpos($ref,'[/date]');
			$ano = substr($ref,$pos-4,4);
			return($ano);
		}
	function recupera_doi($ref)
		{
			$pos = (strpos($ref,'doi:')+4);
			if ($pos > 10)
				{
				$doi = trim(substr($ref,$pos,200)).' ';
				$doi = trim(substr($doi,0,strpos($doi,' ')));
				
				if (strpos($doi,'['))
					{ $doi = trim(substr($doi,0,strpos($doi,'['))); }
				
				$pto = substr($doi,strlen($doi)-1,1);
				if ($pto=='.')
					{ $doi = substr($doi,0,strlen($doi)-1); }
				}
			return($doi);
		}	
			
	function dtd_ref_journal($ref=array())
		{
			$rf = $ref['ac_dtd'];
			$obra = trim($ref['ac_tipo_obra']);
			$tipo_autor = trim($ref['ac_tipo']);			
			
			$nref = $this->encode(trim($ref['ac_ref']));
			$no = $this->encode($this->recupera($rf,'no'));
			
			/* SEM NO */
			if (round($no) == 0)
				{
					echo 'ERRO';
					echo $nref;
					exit;
				}
			$doi = $this->recupera_doi($rf);
			$autores = $this->recupera_autor_pessoal($rf);
			/* Journal */
			$journal = $this->recupera($rf,'stitle');
			if (substr($journal,0,1) == '.')
				{
					$journal = trim(substr($journal,1,strlen($journal)));
				}
			/* Issue e Volume */
			$issue = $this->recupera($rf,'issueno');
			$vol = $this->recupera($rf,'volid');
			
			/* Pages */
			$page = $this->recupera($rf,'page');
			$pagi = ''; $pagf = '';
			if (strlen($page) > 0)
				{
					if (strpos($page,'-') > 0)
						{
							$pagi = substr($page,0,strpos($page,'-'));
							$pagf = substr($page,strpos($page,'-')+1,20);
						} else {
							$pagi = $page;
							$pagf = '';							
						}
				}
			
			/* Recupera ano */
			$ano = $this->recupera_ano($rf);
			/* Idioma */
			$idioma = $this->recupera_idioma($rf);
			$rf = troca($rf,' language="pt"','');
			$rf = troca($rf,' language="en"','');
			$rf = troca($rf,' language="fr"','');
			$rf = troca($rf,' language="es"','');
			$titulo = $this->encode($this->recupera($rf,'title'));
			$titulo_s = $this->encode($this->recupera($rf,'subtitle'));
			if (strlen($titulo_s) > 0)
				{ $titulo = trim($titulo.': '.$titulo_s); }
			
			$sx = '
 				<ref id="B'.strzero($no,3).'">
         			<label>'.$no.'</label>
         			<mixed-citation>'.$nref.'</mixed-citation>
    	 				<element-citation publication-type="journal">'.chr(13).chr(10);
			if ($tipo_autor=='A')
				{
				$sx .= '<person-group person-group-type="author">'.chr(13).chr(10);
				for ($r=0;$r < count($autores);$r++) {
					$sx .= '
               				<name>
                      		<surname>'.$autores[$r][0].'</surname>
	                      		<given-names>'.$autores[$r][1].'</given-names>
               				</name>'.chr(13).chr(10);
					}
				$sx .= '</person-group>';
				} else {
					echo 'ERRO TIPO DE AUTOR - ARTIGO';
					echo '<BR>'.$nref;
					exit;
				}
			$sx .= '
            			<article-title xml:lang="'.$idioma.'">'.$titulo.'</article-title>
            			<source>'.$journal.'</source>';
			//$sx .= '<month>M√™s</month>';
			$sx .= '
                		<year>'.$ano.'</year>
                		<volume>'.$vol.'</volume>
               			<issue>'.$issue.'</issue>
                		<fpage>'.$pagi.'</fpage>
                		<lpage>'.$pagf.'</lpage>
                	';
			/*
			$sx .= '<article-id pub-id-type="pmid">somente n√∫meros</article-id>'.chr(13).chr(10);
   			$sx .= '<article-id pub-id-type="pcmid">somente n√∫meros</article-id>'.chr(13).chr(10);
			 */
			if (strlen($doi) > 0)
				{ $sx .= '<article-id pub-id-type="doi">'.$doi.'</article-id>'.chr(13).chr(10); }
			/*
   			$sx .= '<article-id pub-id-type="pii">somente n√∫meros</article-id>'.chr(13).chr(10);
  			$sx .= '<elocation-id>representa um n√∫mero de p√°gina eletr√¥nica</elocation-id>'.chr(13).chr(10);
    		
			 * */
			$sx .= '</element-citation>';
			$sx .= '</ref>';
			return($sx);			
		}
	function dtd_agradecimento()
		{
			$sx = '
			<ack>
			    <title>Agradecimentos</title>
       			<p>Texto de agradecimentos, pode ou n√£o conter dados de financiamento</p>
  			</ack>			
			';
			return($sx);
		}

	function dtd_keywords($key)
		{
			$key = troca($key,'.',';');
			$keys = splitx(';',$key.';');
			print_r($keys);
		}

	function dtd_counts()
		{
			$sx = '
 			<counts>
         		<table-count count="'.$this->count_table.'"/>
         		<ref-count count="'.$this->count_ref.'"/>
         		<fig-count count="'.$this->count_fig.'"/>
         		<equation-count count="'.$this->count_equation.'"/>
         		<page-count count="'.$this->count_page.'"/>
			</counts>
			';
			return($sx);			
		}
	function dtd_front()
		{
			$sx = '
			<front>
			[journal_meta]
			[article_meta]
			</front>
			';
			
			$sx = troca($sx,'[journal_meta]',$this->dtd_journal_meta());
			$sx = troca($sx,'[article_meta]',$this->dtd_article_meta());
			//$sx = troca($sx,'[article_meta]',$this->dtd_article());
			
			return($sx);
		}

	function dtd_journal_meta()
		{
			$eissn = ''; 
			if (strlen($this->issn_e) > 0) { $eissn = '<issn pub-type="epub">'.$this->issn_e.'</issn>'; }
			$sx = '
			<journal-meta>
				<journal-id journal-id-type="publisher-id">'.$this->journal_name.'</journal-id>
				<journal-title-group>
					<journal-title>'.$this->journal_name.'</journal-title>
					<abbrev-journal-title abbrev-type="publisher">'.$this->journal_name_abrev.'</abbrev-journal-title>
				</journal-title-group>	
				<issn pub-type="ppub">'.$this->issn.'</issn>
				'.$eissn.'
				<publisher>
       				<publisher-name>'.$this->publisher.'</publisher-name>
				</publisher>				
			</journal-meta>
			';
			return($sx);
		}
	
	function dtd_article()
		{
			$sx = '';
			$sx .= '<?xml version="1.0" encoding="utf-8"?>'.chr(13).chr(10);
			$sx .= '<!DOCTYPE article PUBLIC "-//NLM//DTD Journal Publishing DTD v3.0 20080202//EN" "journalpublishing3.dtd">'.chr(13).chr(10);
			
			$sx .= '<article xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:mml="http://www.w3.org/1998/Math/MathML" dtd-version="3.0" article-type="research-article" xml:lang="en">
  			[front]
  			[body]
  			[back]
  			</article>'.chr(13).chr(10);			
			return($sx);
		}
	
	/* Data Base */	
	
	function db_idioma()
		{
			$db = array(
			'en'=>'inglÍs',
			'fr'=>'francÍs',
			'pt'=>'portuguÍs',
			'es'=>'espanhol',
			'ge'=>'alem„o',
			'af'=>'africaner'			
			);
			return($db);
		}
	function db_alphabet_of_title()
		{
			$db = array(
			'A'=>'Basic Roman',
			'B'=>'Extensive Roman',
			'C'=>'Cirillic',
			'D'=>'Japanese',
			'E'=>'Chinese',
			'K'=>'Korean',
			'O'=>'Another alphabet'
			);
			return($db);
		}
	function db_acquisition_priority()
		{
			$db = array(
			'1'=>'Indispensable',
			'2'=>'Dispensable because exists in the Country',
			'3'=>'Dispensable because exists in the Region');
			return($db);
		}	
	}
?>