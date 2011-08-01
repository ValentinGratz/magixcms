<?php# -- BEGIN LICENSE BLOCK ----------------------------------## This file is part of Magix CMS.# Magix CMS, a CMS optimized for SEO# Copyright (C) 2010 - 2011  Gerits Aurelien <aurelien@magix-cms.com># This program is free software: you can redistribute it and/or modify# it under the terms of the GNU General Public License as published by# the Free Software Foundation, either version 3 of the License, or# (at your option) any later version.# # This program is distributed in the hope that it will be useful,# but WITHOUT ANY WARRANTY; without even the implied warranty of# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the# GNU General Public License for more details.# You should have received a copy of the GNU General Public License# along with this program.  If not, see <http://www.gnu.org/licenses/>.## -- END LICENSE BLOCK -----------------------------------
/** * MAGIX CMS * @category   extends  * @package    Smarty * @subpackage function * @copyright  MAGIX CMS Copyright (c) 2010 - 2011 Gerits Aurelien,  * http://www.magix-cms.com, http://www.magix-cjquery.com * @license    Dual licensed under the MIT or GPL Version 3 licenses. * @version    plugin version * @author Gérits Aurélien <aurelien@magix-cms.com> * */
/**
 * Smarty {widget_catalog_subcategory_display} function plugin
 *
 * Type:     function
 * Name:     widget_catalog_subcategory_display
 * Date:     
 * Purpose:  
 * Examples: {widget_catalog_subcategory_display tposition=bottom col="2"}
 * Output:   
 * @link http://www.magix-dev.be
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_catalog_subcategory_display($params, $template){	$title = $params['title']? "<p>" . $params['title'] . "</p>" : '';  	//Paramètres des classes CSS	if (isset($params['css_param'])) {		if(is_array($params['css_param'])){			$tabs = $params['css_param'];		}else{			trigger_error("css_param is not array");			return;		}	}else{		$tabs= array('class_container'=>'list-div w11-32 bg medium'				,'class_elem'=>'list-div-elem'				,'class_img'=>'img'			);	}	if(isset($_GET['idclc'])){  		$getcat = magixcjquery_filter_isVar::isPostNumeric($_GET['idclc']);	}  	$tposition = $params['tposition']? $params['tposition'] : 'top';  	$block = null;	// Nombre de colonnes	$last = $params['col']? $params['col'] : 0 ;	$i = 1;	$imgPath = new magixglobal_model_imagepath('catalog');  	if (frontend_db_block_catalog::s_sub_category_menu(frontend_model_template::current_Language(),$getcat) != null) {        $block .= '<div class="'.$tabs['class_container'].'">';      $block .= $title;    	foreach ( frontend_db_block_catalog::s_sub_category_menu(frontend_model_template::current_Language(),$getcat) as $cat ) {			if ($i == $last ) {				//$class= $class_b . 'last' . $class_e;				$last_elem = ' last';				$i = 1;			} else {				//$class= null;				$last_elem = null;				$i++;			}			$uri_subcategory = magixglobal_model_rewrite::filter_catalog_subcategory_url($cat['iso'],$cat['pathclibelle'],$cat['idclc'],$cat['pathslibelle'],$cat['idcls'],true);      		$block .= '<div class="'.$tabs['class_elem'].$last_elem.'">';	        if($tposition == 'top'){	        	$block .= '<p class="name"><a href="'.$uri_subcategory.'">'.magixcjquery_string_convert::ucFirst($cat['slibelle']).'</a></p>';	        }     		if($cat['img_s'] != null){            	$block .= '<a class="'.$tabs['class_img'].'" href="'.$uri_subcategory.'"><img src="'.$imgPath->filter_path_img('subcategory',$cat['img_s']).'" alt="'.$cat['slibelle'].'" /></a>';      		}else{            	$block .= '<a class="'.$tabs['class_img'].'" href="'.$uri_subcategory.'"><img src="/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/catalog/no-picture.png'.'" alt="'.$cat['slibelle'].'" /></a>';      		}
	      if($tposition == 'bottom'){	            $block .= '<p class="name"><a href="'.$uri_subcategory.'">'.magixcjquery_string_convert::ucFirst($cat['slibelle']).'</a></p>';	      }          	$block .= "</div>";    	}    $block .= "</div>";  }  return $block;
} 