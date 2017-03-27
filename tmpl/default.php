<?php
/*
 *      ModuList module
 *      @package ModuList module
 *      @author José António Cidre Bardelás
 *      @copyright Copyright (C) 2011 José António Cidre Bardelás and Joomla Empresa. All rights reserved
 *      @license GNU/GPL v3 or later
 *      
 *      Contact us at info@joomlaempresa.com (http://www.joomlaempresa.es)
 *      
 *      This file is part of ModuList module.
 *      
 *          ModuList module is free software: you can redistribute it and/or modify
 *          it under the terms of the GNU General Public License as published by
 *          the Free Software Foundation, either version 3 of the License, or
 *          (at your option) any later version.
 *      
 *          ModuList module is distributed in the hope that it will be useful,
 *          but WITHOUT ANY WARRANTY; without even the implied warranty of
 *          MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *          GNU General Public License for more details.
 *      
 *          You should have received a copy of the GNU General Public License
 *          along with ModuList module.  If not, see <http://www.gnu.org/licenses/>.
 */
defined('_JEXEC') or die('Acesso restrito');
$estilo = '';
$doc = &JFactory::getDocument();
if($mostrarTaboa) {
	$estilo .= <<<REMATE
#ModuList$idModulo table{margin:$alinhaTaboa;border:0;border-collapse:separate !important;border-spacing:1px !important;background-color:$corTaboaFondo;$amploTaboa}
#ModuList$idModulo table tr td.titulo_artigo{color:$corCabecalhoTexto;background-color:$corCabecalhoFondo;padding-left:14px;text-align:left;$amploCelaArtigo}
#ModuList$idModulo table tr td.titulo_secom{color:$corCabecalhoTexto;background-color:$corCabecalhoFondo;text-align:center;$amploCelaSecom}
#ModuList$idModulo table tr td.titulo_categoria{color:$corCabecalhoTexto;background-color:$corCabecalhoFondo;text-align:center;$amploCelaCategoria}
#ModuList$idModulo table tr td.titulo_autor{color:$corCabecalhoTexto;background-color:$corCabecalhoFondo;text-align:center;$amploCelaAutor}
#ModuList$idModulo table tr td.titulo_datacria{color:$corCabecalhoTexto;background-color:$corCabecalhoFondo;text-align:center;$amploCelaDataCriacom}
#ModuList$idModulo table tr td.titulo_datamod{color:$corCabecalhoTexto;background-color:$corCabecalhoFondo;text-align:center;$amploCelaDataMudanca}
#ModuList$idModulo table tr td.titulo_icone{color:$corCabecalhoTexto;background-color:$corCabecalhoFondo;text-align:center;$amploCelaIcone}
#ModuList$idModulo table tr td.cela_artigo{background-color:$corCelasFondo;padding:2px 2px 2px 8px;text-align:left;}
#ModuList$idModulo table tr td.cela_artigo div{display: inline-block;white-space: nowrap;overflow: hidden;height:18px;text-align:left;$amploCelaArtigo}
#ModuList$idModulo table tr td.cela_secom{background-color:$corCelasFondo;padding:2px 2px 2px 2px;text-align:center;}
#ModuList$idModulo table tr td.cela_secom div{display: inline-block;white-space: nowrap;overflow: hidden;height:18px;text-align:center;$amploCelaSecom}
#ModuList$idModulo table tr td.cela_categoria{background-color:$corCelasFondo;padding:2px 2px 2px 2px;text-align:center;}
#ModuList$idModulo table tr td.cela_categoria div{display: inline-block;white-space: nowrap;overflow: hidden;height:18px;text-align:center;$amploCelaCategoria}
#ModuList$idModulo table tr td.cela_autor{background-color:$corCelasFondo;padding:2px 2px 2px 2px;text-align:center;}
#ModuList$idModulo table tr td.cela_autor div{display: inline-block;white-space: nowrap;overflow: hidden;height:18px;text-align:center;$amploCelaAutor}
#ModuList$idModulo table tr td.cela_datacria{background-color:$corCelasFondo;padding:2px 2px 2px 2px;text-align:center;}
#ModuList$idModulo table tr td.cela_datacria div{display: inline-block;white-space: nowrap;overflow: hidden;height:18px;text-align:center;$amploCelaDataCriacom}
#ModuList$idModulo table tr td.cela_datamod{background-color:$corCelasFondo;padding:2px 2px 2px 2px;text-align:center;}
#ModuList$idModulo table tr td.cela_datamod div{display: inline-block;white-space: nowrap;overflow: hidden;height:18px;text-align:center;$amploCelaDataMudanca}
#ModuList$idModulo table tr td.cela_icone{background-color:$corCelasFondo;padding:2px 2px 2px 2px;text-align:center;}
#ModuList$idModulo table tr td.cela_icone div{display: inline-block;height:18px;white-space: nowrap;overflow: hidden;text-align:center;$amploCelaIcone}
#ModuList$idModulo table a,a:visited{color:$corCelasTexto;text-decoration:none;}
#ModuList$idModulo table a:hover{color:$corCelasTextoPairado;text-decoration:none;}
REMATE;
}
$estilo .= <<<REMATE
#ModuListSlider$idModulo {float: left; background: transparent url(${urlBase}modules/mod_modulist/imagens/linha.png) repeat-x right top;height: 16px;width: $amploRolagem;margin: 0 10px 0 5px}
#ModuListSlider$idModulo .knob {background: transparent url(${urlBase}modules/mod_modulist/imagens/carraboujo.png) no-repeat right top;width: 16px;height: 16px;}
#ModuListNavegacom$idModulo {display: block;}
#ModuListPaginacom$idModulo {margin: 5px;}
REMATE;
$doc->addStyleDeclaration($estilo);
if($ajax) {
	$idioma         = &JFactory::getLanguage();
	$etiquetaIdioma = $idioma->getTag();
	$tradPagina     = JText::_('MOD_ML_PAGINA');
	$tradDe         = JText::_('MOD_ML_DE');
	$endereco       = $urlBase.'modules'.DS.'mod_modulist'.DS.'paginacom_ajax.php?ajax=true'.'&tipo='.$tipoElementos.'&elementos='.$elementos.'&elementos_pagina='.$elementosPagina.'&ordem='.$ordem.'&catid='.$catid.'&secid='.$secid.'&mostrar_secoes='.$mostrarSecom.'&mostrar_categorias='.$mostrarCategoria.'&mostrar_autor='.$mostrarAutor.'&mostrar_datacria='.$mostrarDataCriacom.'&mostrar_datamod='.$mostrarDataMudanca.'&mostrar_icone='.$mostrarIcone.'&mostrar_taboa='.$mostrarTaboa.'&car_secom='.$caracteresSecom.'&car_categoria='.$caracteresCategoria.'&car_artigo='.$caracteresArtigo.'&car_autor='.$caracteresAutor.'&car_datacria='.$caracteresDataCriacom.'&car_datamod='.$caracteresDataMudanca.'&idioma='.$etiquetaIdioma;
	$script = <<<REMATE
	window.addEvent('domready', function(){
		var ModuListSlider$idModulo = $("ModuListSlider$idModulo");
		new Slider(ModuListSlider$idModulo, ModuListSlider$idModulo.getElement('.knob'), {
			steps: $totalPaginas,
			snap: true,
			wheel: true,
			initialStep: 1,
			offset: 2,
			range: [1, $totalPaginas],
			onChange: function(valor){
				if (valor) $('ModuListPaginacom$idModulo').setHTML('$tradPagina '+valor+' $tradDe $totalPaginas');
			},
			onComplete: function(valor){
				if (valor) url = "$endereco"+"&pagina="+valor;
			pedidoAjax();
			}
		});
REMATE;
	if($fundido) {
		$script .= <<<REMATE
			function pedidoAjax() {
				$('ModuList$idModulo').effect('opacity',{duration:$tempoFundido, fps:50, onComplete: atualizaContedor}).start(1,0);
			};

			function atualizaContedor() {
				new Ajax(url, {update: $('ModuList$idModulo'), onComplete: fundidoContedor}).request();
			}

			function fundidoContedor() {
				$('ModuList$idModulo').effect('opacity',{duration:$tempoFundido, fps:50}).start(0,1);
			}
REMATE;
	}
	else {
		$script .= <<<REMATE
			var desliza$idModulo = new Fx.Slide('ModuList$idModulo', {mode: '$modoSlide', duration: $tempoFundido, transition: Fx.Transitions.$tipoSlide});
			function pedidoAjax() {
				desliza$idModulo.slideOut().chain(function(){atualizaContedor();});
			};

			function atualizaContedor() {
				new Ajax(url, {update: $('ModuList$idModulo'), onComplete: deslizaContedor}).request();
			}

			function deslizaContedor() {
				desliza$idModulo.slideIn();
			}
REMATE;
	}
	$script .= <<<REMATE
	});
REMATE;
	$doc->addScriptDeclaration($script);
}
?>
<?php if($ajax) :?>
<div id="ModuListNavegacom<?php echo $idModulo;?>">
<div id="ModuListSlider<?php echo $idModulo;?>" class="ModuListSlider<?php echo $idModulo;?>">
  <div class="knob"></div>
</div>
<div id="ModuListPaginacom<?php echo $idModulo;?>"><?php echo $tradPagina.' 1 '.$tradDe.' '.$totalPaginas;?></div>
</div>
<?php endif;?>
<?php if($descricom) 
	echo $descricom;?>
<div id="ModuList<?php echo $idModulo;?>">
<?php if($mostrarTaboa) require(dirname(__FILE__).DS.'_taboa.php');
else require(dirname(__FILE__).DS.'_listagem.php'); ?>
</div>
