<?php
class dtd31
	{
	var $journal_name = 'Revista Fisioterapia e Movimento';
	var $journal_name_abrev = 'Rev. Fisio. Mov.';
	var $issn = '1950-9089';
	var $issn_e = '1980-5918';
	var $publisher = 'Pontif�cia Universidade Cat�lica do Paraná';
	
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
	var $count_page = 0;		
	
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
			$sx = troca($sx,'[back]',$this->dtd_back());
			
			//$sx = utf8_encode($sx);
			return($sx);
		}
		
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
		
	function dtd_ref_book()
		{
			$sx = '
			<ref id="B01">
        		<label>2</label>
        		<mixed-citation>Referência conforme aparece no artigo</mixed-citation>
      			<element-citation publication-type="book">
         			<name>
	                	<surname>Sobrenome</surname>
	              		<given-names>Nome</given-names>
         			</name>
          			<source>Nome do Livro</source>
          			<edition>edição (inserir informação ed. ou th. e etc conforme no pdf)</edition>
          			<publisher-loc>Lugar de publicação do livro (cidade, estado, país e etc)</publisher-loc>
          			<publisher-name>Nome da editora/Casa publicadora</publisher-name>
         			<year>Ano de publicação da obra</year>
	    			<size units="page">quantidade total de páginas do livro</size>
    			</element-citation>
			</ref>			
			';
			return($sx);
		}
		
	function dtd_ref_journal()
		{
			$sx = '
 				<ref id="B00">
         			<label>1</label>
         			<mixed-citation>Referência conforme aparece no artigo</mixed-citation>
    	 				<element-citation publication-type="journal">
	            		<person-group person-group-type="author">
               				<name>
                      		<surname>Sobrenome</surname>
	                      		<given-names>Nome</given-names>
               				</name>
               				<name>
                      			<surname>Sobrenome</surname>
                      			<given-names>Nome</given-names>
	               			</name>
             			</person-group>
            			<article-title xml:lang="en">Título do artigo</article-title>
            			<source>Nome do Periódico</source>
                		<month>Mês</month>
                		<year>ano</year>
                		<volume>volume</volume>
               			<issue>número</issue>
                		<fpage>página inicial</fpage>
                		<lpage>página final</lpage>
   						<article-id pub-id-type="pmid">somente números</article-id>
   						<article-id pub-id-type="pcmid">somente números</article-id>
   						<article-id pub-id-type="doi">somente números</article-id>
   						<article-id pub-id-type="pii">somente números</article-id>
  						<elocation-id>representa um número de página eletrônica</elocation-id>
    				</element-citation>
			</ref>
			';
			return($sx);			
		}
	function dtd_agradecimento()
		{
			$sx = '
			<ack>
			    <title>Agradecimentos</title>
       			<p>Texto de agradecimentos, pode ou não conter dados de financiamento</p>
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
			'en'=>'ingl�s',
			'fr'=>'franc�s',
			'pt'=>'portugu�s',
			'es'=>'espanhol',
			'ge'=>'alem�o',
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