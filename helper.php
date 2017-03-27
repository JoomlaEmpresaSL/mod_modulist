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
if(file_exists(JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php')) 
	require_once(JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');

class modModuList {

	function getList(&$params) {
		$db = &JFactory::getDBO();
		$elementos = (int) $params->get('elementos', 5);
		$elementos_pagina = (int) $params->get('elementos_pagina', 5);
		$catid = trim($params->get('catid'));
		$secid = trim($params->get('secid'));
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
		$user = &JFactory::getUser();
		$usuarioConvidado = $user->guest;
		$nullDate = $db->getNullDate();
		$date = &JFactory::getDate();
		$now = $date->toMySQL();
		// Ordering
		if($params->get('tipo_elementos') == 'recentes') {
			switch($params->get('ordering')) {
				case 'm_dsc':
				$ordering = 'a.modified DESC, a.created DESC';
				break;
				case 'c_dsc':
				default:
				$ordering = 'a.created DESC';
				break;
			}
		}
		elseif($params->get('tipo_elementos') == 'populares') {
			$ordering = 'a.hits DESC, a.created DESC';
		}
		else 
			$ordering = 'a.created DESC';
		$query = 'SELECT a.*, a.title as titulo, cat.*, sec.title as nomesec, u.name as autor,'.' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'.' CASE WHEN CHAR_LENGTH(cat.alias) THEN CONCAT_WS(":", cat.id, cat.alias) ELSE cat.id END as catslug'.' FROM #__content AS a'.' INNER JOIN #__categories AS cat ON cat.id = a.catid'.' INNER JOIN #__sections AS sec ON sec.id = a.sectionid'.' INNER JOIN #__users AS u ON u.id = a.created_by'.' WHERE a.state = 1'.' AND cat.published = 1 '.($usuarioConvidado ? ' AND cat.access = 0' : '').($catid || $secid ? $catCondition : '').' AND ( a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).' )'.' AND ( a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).' )'.' ORDER BY '.$ordering;
		$db->setQuery($query);
		$db->query();
		$totalResultados = $db->getNumRows();
		if($params->get('tipo_elementos') == 'aleatorios') 
			$db->setQuery($query);
		else 
			$db->setQuery($query, 0, $elementos_pagina);
		$rows = $db->loadObjectList();
		$i = 0;
		$lists = array();
		// Trying to get rid of Joomla Category Route Error with SEF links enabled
		$app =& JFactory::getApplication();
		$sef = $app->getCfg('sef');
		foreach($rows as $row) {
			$lists[$i]->link = JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catslug, $row->sectionid));
			$lists[$i]->text = htmlspecialchars($row->titulo);
			$lists[$i]->link_section = JRoute::_(ContentHelperRoute::getSectionRoute($row->sectionid));
			$lists[$i]->section = htmlspecialchars($row->nomesec);
			// Trying to get rid of Joomla Category Route Error with SEF links enabled
			// This is a weird solution but seems to work
			if(!$sef)$lists[$i]->link_category = JRoute::_(ContentHelperRoute::getCategoryRoute($row->catslug, $row->sectionid));
			else $lists[$i]->link_category = str_replace('/section/', '/category/', JRoute::_(ContentHelperRoute::getSectionRoute($row->catid)));
			$lists[$i]->category = htmlspecialchars($row->title);
			$lists[$i]->creationdate = JHTML::_('date', $row->created, JText::_('DATE_FORMAT_LC4'));
			$lists[$i]->modificationdate = JHTML::_('date', $row->modified, JText::_('DATE_FORMAT_LC4'));
			$lists[$i]->autor = htmlspecialchars($row->autor);
			$i++;
		}
		if($params->get('tipo_elementos') == 'aleatorios') {
			shuffle($lists);
			$lists = array_slice($lists, 0, $elementos);
		}
		return array($lists, $totalResultados);
	}
}
