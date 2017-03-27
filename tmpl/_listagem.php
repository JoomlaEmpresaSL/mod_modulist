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
defined('_JEXEC') or die('Acesso restrito'); ?>

	<b><?php echo JText::_('MOD_ML_ARTIGO');?></b> <?php if($mostrarCategoria || $mostrarSecom) :?>(<?php endif;?><?php if($mostrarSecom) :?><b><?php echo JText::_('MOD_ML_SECOM');?></b><?php endif;?><?php if($mostrarCategoria && $mostrarSecom) :?> - <?php endif;?><?php if($mostrarCategoria) :?><b><?php echo JText::_('MOD_ML_CATEGORIA');?></b><?php endif;?><?php if($mostrarCategoria || $mostrarSecom) :?>)<?php endif;?>
	<ul>
<?php foreach($listagem as $item) :?>
		<li><a href="<?php echo $item->link;?>" title="<?php echo $item->text;?>"><?php echo((strlen($item->text) >= $caracteresArtigo) && $caracteresArtigo ? mb_substr($item->text, 0, $caracteresArtigo, 'UTF-8').'...' : $item->text);?></a><?php if($mostrarCategoria || $mostrarSecom) :?> (<?php endif;?><?php if($mostrarSecom) :?><a href="<?php echo $item->link_section;?>" title="<?php echo $item->section;?>"><?php echo((strlen($item->section) >= $caracteresSecom) && $caracteresSecom ? mb_substr($item->section, 0, $caracteresSecom, 'UTF-8').'...' : $item->section);?></a><?php endif;?><?php if($mostrarCategoria && $mostrarSecom) :?> - <?php endif;?><?php if($mostrarCategoria) :?><a href="<?php echo $item->link_category;?>" title="<?php echo $item->category;?>"><?php echo((strlen($item->category) >= $caracteresCategoria) && $caracteresCategoria ? mb_substr($item->category, 0, $caracteresCategoria, 'UTF-8').'...' : $item->category);?></a><?php endif;?><?php if($mostrarCategoria || $mostrarSecom) :?>)<?php endif;?><?php if($mostrarAutor) :?><?php echo ' '.JText::_('MOD_ML_BY').' <span title="'.$item->autor.'">'.((strlen($item->autor) >= $caracteresAutor) && $caracteresAutor ? mb_substr($item->autor, 0, $caracteresAutor, 'UTF-8').'...' : $item->autor).'</span>';?><?php endif;?><?php if($mostrarDataCriacom) :?><?php echo '. '.JText::_('MOD_ML_CRIADO').': <span title="'.$item->creationdate.'">'.((strlen($item->creationdate) >= $caracteresDataCriacom) && $caracteresDataCriacom ? mb_substr($item->creationdate, 0, $caracteresDataCriacom, 'UTF-8').'...' : $item->creationdate).'</span>';?><?php endif;?><?php if($mostrarDataMudanca) :?><?php echo '. '.JText::_('MOD_ML_MUDADO').': <span title="'.$item->modificationdate.'">'.((strlen($item->modificationdate) >= $caracteresDataMudanca) && $caracteresDataMudanca ? mb_substr($item->modifcationdate, 0, $caracteresDataMudanca, 'UTF-8').'...' : $item->modificationdate).'</span>';?><?php endif;?></li>
<?php endforeach;?>
</ul>

