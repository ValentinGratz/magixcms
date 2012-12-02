<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2012 magix-cms.com <support@magix-cms.com>
 #
 # OFFICIAL TEAM :
 #
 #   * Gerits Aurelien (Author - Developer) <aurelien@magix-cms.com> <contact@aurelien-gerits.be>
 #
 # Redistributions of files must retain the above copyright notice.
 # This program is free software: you can redistribute it and/or modify
 # it under the terms of the GNU General Public License as published by
 # the Free Software Foundation, either version 3 of the License, or
 # (at your option) any later version.
 #
 # This program is distributed in the hope that it will be useful,
 # but WITHOUT ANY WARRANTY; without even the implied warranty of
 # MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 # GNU General Public License for more details.

 # You should have received a copy of the GNU General Public License
 # along with this program.  If not, see <http://www.gnu.org/licenses/>.
 #
 # -- END LICENSE BLOCK -----------------------------------

 # DISCLAIMER

 # Do not edit or add to this file if you wish to upgrade MAGIX CMS to newer
 # versions in the future. If you wish to customize MAGIX CMS for your
 # needs please refer to http://www.magix-cms.com for more information.
 */
/**
 * MAGIX CMS
 * @category   Model 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2011 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.1
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be> | <gerits.aurelien@gmail.com>
 * @name blockdom
 * Model from DOM element dynamic
 */
class backend_model_blockDom{
	/**
	 * Construction du menu select pour la langue
	 */
	public static function select_language($cellbutton=false){
		if(backend_db_block_lang::s_data_lang() != null){
			$block = '<tr>
						<td class="label"><label for="idlang">Langue :</label></td>
					</tr>
					<tr>
						<td>';
			$block .= '<select id="idlang" name="idlang">';
			//$block .= '<option value="0">Défaut</option>';
			foreach(backend_db_block_lang::s_data_lang() as $slang){
				$block .= '<option value="'.$slang['idlang'].'">'.$slang['iso'].'</option>';
			}
			$block .='</select>';
			$block .= '</td>';
			if($cellbutton == true){
				$block .= '<td><div style="margin:5px;"><input type="submit" value="Envoyer" /></div></td>';
			}
			$block .= '</tr>';
			return $block;
		}
	}
	/**
	 * Construction du menu select pour la langue avec exclusion
	 */
	public static function select_other_lang($idlang){
		if(backend_db_block_lang::s_exclude_language_data($idlang) != null){
			$block = '<tr>
						<td class="label"><label for="idlang">Langue :</label></td>
					</tr>
					<tr>
						<td>';
			$block .= '<select id="idlang" name="idlang">';
			foreach(backend_db_block_lang::s_exclude_language_data($idlang) as $slang){
				$block .= '<option value="'.$slang['idlang'].'">'.$slang['iso'].'</option>';
			}
			$block .='</select>';
			$block .= '</td>';
			$block .= '</tr>';
			return $block;
		}
	}
	/**
	 * Construction du menu select des utilisateurs 
	 */
	public static function select_users(){
		if(backend_db_admin::adminDbMember()->view_list_members() != null){
			$block = '<tr>
						<td class="label"><label for="idadmin" class="inlinelabel">Utilisateurs :</label></td>
					</tr>
					<tr>
						<td>';
			$block .= '<select id="idadmin" name="idadmin">';
			$block .= '<option value="">Sélectionner un utilisateur</option>';
			foreach(backend_db_admin::adminDbMember()->view_list_members() as $m){
				$block .= '<option value="'.$m['idadmin'].'">'.$m['pseudo'].'</option>';
			}
			$block .='</select>';
			$block .= '</td>
							<td style="width:150px;" class="errorInput"></td>
					</tr>
					<tr>
						<td class="status"></td>
					</tr>';
		}
		return $block;
	}
}