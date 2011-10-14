<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of Magix CMS.
# Magix CMS, a CMS optimized for SEO
# Copyright (C) 2010 - 2011  Gerits Aurelien <aurelien@magix-cms.com>
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
/**
 * MAGIX CMS
 * @category   DB 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.6
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name rewritemetas
 *
 */
class backend_db_rewritemetas{
/**
     * selectionne la métas suivant la catégorie, la langue et le type (title ou description)
     * @param $codelang (langue)
     * @param $attribute (module ex: rewritenews = 5)
     * @param $idmetas (1 ou 2) (title ou description)
     */
	protected function s_rewrite_meta($attribute=null){
		if($attribute != null){
			$id = 'WHERE r.attribute = '.$attribute;
		}else{
			$id = null;
		}
		$sql = 'SELECT r.idrewrite,r.idmetas,lang.iso,r.strrewrite,r.level,r.attribute 
		FROM mc_metas_rewrite as r
		LEFT JOIN mc_lang AS lang ON(r.idlang = lang.idlang)
		'.$id.'
		ORDER BY lang.iso';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * selectionne les données suivant la langue
	 * @param $idlang
	 */
	protected function s_rewrite_v_lang($attribute,$idlang,$idmetas,$level){
		$sql ='SELECT idrewrite
				FROM mc_metas_rewrite AS r
				WHERE r.attribute =:attribute AND r.idmetas =:idmetas AND r.level =:level AND r.idlang =:idlang';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
		':attribute'=>	$attribute,	
		':idlang' 	=>	$idlang,
		':idmetas'	=>	$idmetas,
		':level'	=>	$level
		));
	}
	/**
	 * selectionne les données suivant la langue
	 * @param $idlang
	 */
	protected function s_rewrite_for_edit($idrewrite){
		$sql ='SELECT lang.idlang,lang.iso,r.attribute,r.idrewrite,r.strrewrite,r.idmetas,r.level
				FROM mc_metas_rewrite AS r
				LEFT JOIN mc_lang AS lang ON(r.idlang = lang.idlang)
				WHERE r.idrewrite =:idrewrite';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':idrewrite'	=>	$idrewrite
		));
	}
	/**
	 * insertion d'une réecriture des métas
	 * @param $attribute
	 * @param $idlang
	 * @param $strrewrite
	 * @param $idmetas
	 * @param $level
	 */
	protected function i_rewrite_metas($attribute,$idlang,$strrewrite,$idmetas,$level){
    	$sql = 'INSERT INTO mc_metas_rewrite (attribute,idlang,strrewrite,idmetas,level) 
				VALUE(:attribute,:idlang,:strrewrite,:idmetas,:level)';
		magixglobal_model_db::layerDB()->insert($sql,
		array(
			':attribute'		=>	$attribute,
			':idlang'			=>	$idlang,
			':strrewrite'		=>	$strrewrite,
			':idmetas'			=>	$idmetas,
			':level'			=>	$level
		));
    }
    /**
     * mise à jour de la métas
     * @param $attribute
     * @param $idlang
     * @param $strrewrite
     * @param $idmetas
     * @param $level
     * @param $idrewrite
     */
	protected function u_rewrite_metas($attribute,$idlang,$strrewrite,$idmetas,$level,$idrewrite){
    	$sql = 'UPDATE mc_metas_rewrite 
    	SET attribute = :attribute,
    	idlang  = :idlang,
    	strrewrite = :strrewrite,
    	idmetas = :idmetas,
    	level = :level
    	WHERE idrewrite = :idrewrite';
		magixglobal_model_db::layerDB()->update($sql,
		array(
			':attribute'		=>	$attribute,
			':idlang'			=>	$idlang,
			':strrewrite'		=>	$strrewrite,
			':idmetas'			=>	$idmetas,
			':level'			=>	$level,
			':idrewrite'		=>	$idrewrite
		));
    }
    /**
     * supprime une réecriture des métas
     * @param $delconfig
     */
	protected function d_rewrite_metas($delconfig){
		$sql = 'DELETE FROM mc_metas_rewrite WHERE idrewrite = :delconfig';
			magixglobal_model_db::layerDB()->delete($sql,
			array(
				':delconfig'	=>	$delconfig
		)); 
	}
}