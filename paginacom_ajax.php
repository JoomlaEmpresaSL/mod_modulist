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
define('_JEXEC', 1);
// JPATH_BASE should point to Joomla root directory
// if you app is placed into a subfolder in Joomla root, the path will look like dirname(__FILE__) . '/..'
define('JPATH_BASE', realpath(dirname(__FILE__).'/../..'));
define('DS', DIRECTORY_SEPARATOR);
require_once(JPATH_BASE.DS.'includes'.DS.'defines.php');
require_once(JPATH_BASE.DS.'includes'.DS.'framework.php');
$mainframe = JFactory::getApplication('site');
if(file_exists(JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php')) 
	require_once(JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');
jimport('joomla.environment.request');
$ajax = JRequest::getBool('ajax');
if(!$ajax) 
	die;
$elementos           = JRequest::getInt('elementos');
$elementos_pagina    = JRequest::getInt('elementos_pagina');
$elemento_comeco     = ((JRequest::getInt('pagina') ? JRequest::getInt('pagina') : 1) - 1) * $elementos_pagina;
$elementos_pagina    = ($elemento_comeco + $elementos_pagina) <= $elementos ? $elementos_pagina : ($elementos - $elemento_comeco);
$tipoElementos       = JRequest::getString('tipo');
$ordem               = JRequest::getString('ordem');
$catid               = JRequest::getString('catid');
$secid               = JRequest::getString('secid');
$mostrarTaboa        = JRequest::getInt('mostrar_taboa');
$mostrarSecom    = JRequest::getInt('mostrar_secoes');
$mostrarCategoria    = JRequest::getInt('mostrar_categorias');
$mostrarAutor    = JRequest::getInt('mostrar_autor');
$mostrarDataCriacom    = JRequest::getInt('mostrar_datacria');
$mostrarDataMudanca    = JRequest::getInt('mostrar_datamod');
$mostrarIcone        = JRequest::getInt('mostrar_icone');
$caracteresArtigo     = JRequest::getInt('car_artigo');
$caracteresSecom = JRequest::getInt('car_secom');
$caracteresCategoria = JRequest::getInt('car_categoria');
$caracteresAutor = JRequest::getInt('car_autor');
$caracteresDataCriacom = JRequest::getInt('car_datacria');
$caracteresDataMudanca = JRequest::getInt('car_datamod');
$lang                = &JFactory::getLanguage();
$extension           = 'mod_modulist';
$base_dir            = JPATH_BASE;
$language_tag        = JRequest::getString('idioma');
$lang->load($extension, $base_dir, $language_tag, true);
$catCondition = '';
if($catid) {
	$ids = explode(',', $catid);
	JArrayHelper::toInteger($ids);
	$catCondition .= ' AND (a.catid='.implode(' OR a.catid=', $ids).')';
}
if($secid) {
	$ids = explode(',', $secid);
	JArrayHelper::toInteger($ids);
	$catCondition .= ' AND (a.sectionid='.implode(' OR a.sectionid=', $ids).')';
}
if($tipoElementos == 'recentes') {
	switch($ordem) {
		case 'm_dsc':
		$ordering = 'a.modified DESC, a.created DESC';
		break;
		case 'c_dsc':
		default:
		$ordering = 'a.created DESC';
		break;
	}
}
elseif($tipoElementos == 'populares') {
	$ordering = 'a.hits DESC, a.created DESC';
}
else 
	$ordering        = 'a.created DESC';
$user             = &JFactory::getUser();
$usuarioConvidado = $user->guest;
$db               = &JFactory::getDBO();
$nullDate         = $db->getNullDate();
$date             = &JFactory::getDate();
$now              = $date->toMySQL();
$query = 'SELECT a.*, a.title as titulo, cat.*, sec.title as nomesec, u.name as autor,'.' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'.' CASE WHEN CHAR_LENGTH(cat.alias) THEN CONCAT_WS(":", cat.id, cat.alias) ELSE cat.id END as catslug'.' FROM #__content AS a'.' INNER JOIN #__categories AS cat ON cat.id = a.catid'.' INNER JOIN #__sections AS sec ON sec.id = a.sectionid'.' INNER JOIN #__users AS u ON u.id = a.created_by'.' WHERE a.state = 1'.' AND cat.published = 1 '.($usuarioConvidado ? ' AND cat.access = 0' : '').($catid || $secid ? $catCondition : '').' AND ( a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).' )'.' AND ( a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).' )'.' ORDER BY '.$ordering;
$db->setQuery($query, $elemento_comeco, $elementos_pagina);
$rows  = $db->loadObjectList();
$i     = 0;
$lists = array();
	foreach($rows as $row) {
		$lists[$i]->link = str_replace('modules/mod_modulist/', '', JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catslug, $row->sectionid)));
		$lists[$i]->text = htmlspecialchars($row->titulo);
		$lists[$i]->link_section = str_replace('modules/mod_modulist/', '', JRoute::_(ContentHelperRoute::getSectionRoute($row->sectionid)));
		$lists[$i]->section = htmlspecialchars($row->nomesec);
		$lists[$i]->link_category = str_replace('modules/mod_modulist/', '', JRoute::_(ContentHelperRoute::getCategoryRoute($row->catslug, $row->sectionid)));
		$lists[$i]->category = htmlspecialchars($row->title);
		$lists[$i]->creationdate = JHTML::_('date', $row->created, JText::_('DATE_FORMAT_LC4'));
		$lists[$i]->modificationdate = JHTML::_('date', $row->modified, JText::_('DATE_FORMAT_LC4'));
		$lists[$i]->autor = htmlspecialchars($row->autor);
		$i++;
	}
$listagem = $lists;
$rotaImagens = JURI::base();
?>
<?php if($mostrarTaboa) require(dirname(__FILE__).DS.'tmpl'.DS.'_taboa.php');
else require(dirname(__FILE__).DS.'tmpl'.DS.'_listagem.php'); ?>
