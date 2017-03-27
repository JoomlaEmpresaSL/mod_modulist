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

<table><tbody>
	<tr>
		<td class="titulo_artigo"><b><?php echo JText::_('MOD_ML_ARTIGO');?></b></td>
		<?php if($mostrarSecom) :?>
		<td class="titulo_secom"><b><?php echo JText::_('MOD_ML_SECOM');?></b></td>
		<?php endif;?>
		<?php if($mostrarCategoria) :?>
		<td class="titulo_categoria"><b><?php echo JText::_('MOD_ML_CATEGORIA');?></b></td>
		<?php endif;?>
		<?php if($mostrarAutor) :?>
		<td class="titulo_autor"><b><?php echo JText::_('MOD_ML_AUTOR');?></b></td>
		<?php endif;?>
		<?php if($mostrarDataCriacom) :?>
		<td class="titulo_datacria"><b><?php echo JText::_('MOD_ML_CRIADO');?></b></td>
		<?php endif;?>
		<?php if($mostrarDataMudanca) :?>
		<td class="titulo_datamod"><b><?php echo JText::_('MOD_ML_MUDADO');?></b></td>
		<?php endif;?>
		<?php if($mostrarIcone) :?>
		<td class="titulo_icone"><b><?php echo JText::_('MOD_ML_INFO');?></b></td>
		<?php endif;?>
	</td></tr>
<?php foreach($listagem as $item) :?>
	<tr>
		<td class="cela_artigo"><div><a href="<?php echo $item->link;?>" title="<?php echo $item->text;?>"><?php echo((strlen($item->text) >= $caracteresArtigo) && $caracteresArtigo ? mb_substr($item->text, 0, $caracteresArtigo, 'UTF-8').'...' : $item->text);?></a></div></td>
		<?php if($mostrarSecom) :?>
		<td class="cela_secom"><div><a href="<?php echo $item->link_section;?>" title="<?php echo $item->section;?>"><?php echo((strlen($item->section) >= $caracteresSecom) && $caracteresSecom ? mb_substr($item->section, 0, $caracteresSecom, 'UTF-8').'...' : $item->section);?></a></div></td>
		<?php endif;?>
		<?php if($mostrarCategoria) :?>
		<td class="cela_categoria"><div><a href="<?php echo $item->link_category;?>" title="<?php echo $item->category;?>"><?php echo((strlen($item->category) >= $caracteresCategoria) && $caracteresCategoria ? mb_substr($item->category, 0, $caracteresCategoria, 'UTF-8').'...' : $item->category);?></a></div></td>
		<?php endif;?>
		<?php if($mostrarAutor) :?>
		<td class="cela_autor"><div title="<?php echo $item->autor; ?>"><?php echo((strlen($item->autor) >= $caracteresAutor) && $caracteresAutor ? mb_substr($item->autor, 0, $caracteresAutor, 'UTF-8').'...' : $item->autor);?></div></td>
		<?php endif;?>
		<?php if($mostrarDataCriacom) :?>
		<td class="cela_datacria"><div title="<?php echo $item->creationdate; ?>"><?php echo((strlen($item->creationdate) >= $caracteresDataCriacom) && $caracteresDataCriacom ? mb_substr($item->creationdate, 0, $caracteresDataCriacom, 'UTF-8').'...' : $item->creationdate);?></div></td>
		<?php endif;?>
		<?php if($mostrarDataMudanca) :?>
		<td class="cela_datamod"><div title="<?php echo $item->modificationdate; ?>"><?php echo((strlen($item->modificationdate) >= $caracteresDataMudanca) && $caracteresDataMudanca ? mb_substr($item->modificationdate, 0, $caracteresDataMudanca, 'UTF-8').'...' : $item->modificationdate);?></div></td>
		<?php endif;?>
		<?php if($mostrarIcone) :?>
		<td class="cela_icone"><div><a href="<?php echo $item->link;?>"><img src="<?php echo $rotaImagens; ?>imagens/info.png" width="15" height="15" alt="Info" title="<?php echo JText::_('MOD_ML_VERMAIS');?>"></a></div></td>
		<?php endif;?>
	</td></tr>
<?php endforeach;?>
</table>
