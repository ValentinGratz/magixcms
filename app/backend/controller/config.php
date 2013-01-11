<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2013 magix-cms.com <support@magix-cms.com>
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
 * @category   Controller 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.2
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name config
 *
 */
class backend_controller_config extends backend_db_config{
	/**
	 * @access public
	 * @var string
	 */
	public $lang;
	/**
	 * @access public
	 * @var string
	 */
	public $cms;
	/**
	 * @access public
	 * @var string
	 */
	public $news;
	/**
	 * @access public
	 * @var string
	 */
	public $catalog;
    /**
     *
     * Configure l'éditeur HTML
     * @var string
     */
    public $manager_setting,$content_css;
	/**
	 * @access public
	 * @var string
	 */
	public $metasrewrite,$plugins;
    public $action,$tab;
    public $id_size_img,$config_size_attr,$width,$height,$img_resizing;
	/**
	 * function construct
	 */
	function __construct(){
        //Config
		if(magixcjquery_filter_request::isPost('lang')){
			$this->lang = magixcjquery_filter_isVar::isPostNumeric($_POST['lang']);
		}
		if(magixcjquery_filter_request::isPost('cms')){
			$this->cms = magixcjquery_filter_isVar::isPostNumeric($_POST['cms']);
		}
		if(magixcjquery_filter_request::isPost('news')){
			$this->news = magixcjquery_filter_isVar::isPostNumeric($_POST['news']);
		}
		if(magixcjquery_filter_request::isPost('catalog')){
			$this->catalog = magixcjquery_filter_isVar::isPostNumeric($_POST['catalog']);
		}
		if(magixcjquery_filter_request::isPost('metasrewrite')){
			$this->metasrewrite = magixcjquery_filter_isVar::isPostNumeric($_POST['metasrewrite']);
		}
		if(magixcjquery_filter_request::isPost('plugins')){
			$this->plugins = magixcjquery_filter_isVar::isPostNumeric($_POST['plugins']);
		}
        if(magixcjquery_filter_request::isGet('action')){
            $this->action = magixcjquery_form_helpersforms::inputClean($_GET['action']);
        }
        if(magixcjquery_filter_request::isGet('tab')){
            $this->tab = magixcjquery_form_helpersforms::inputClean($_GET['tab']);
        }
        //manager setting
        if(magixcjquery_filter_request::isPost('manager_setting')){
            $this->manager_setting = magixcjquery_form_helpersforms::inputClean($_POST['manager_setting']);
        }
        if(magixcjquery_filter_request::isPost('content_css')){
            $this->content_css = magixcjquery_form_helpersforms::inputClean($_POST['content_css']);
        }
        if(magixcjquery_filter_request::isPost('width') AND magixcjquery_filter_request::isPost('height')){
            $this->width = magixcjquery_filter_isVar::isPostNumeric($_POST['width']);
            $this->height = magixcjquery_filter_isVar::isPostNumeric($_POST['height']);
        }
        if(magixcjquery_filter_request::isPost('img_resizing')){
            $this->img_resizing = magixcjquery_form_helpersforms::inputClean($_POST['img_resizing']);
        }
        if(magixcjquery_filter_request::isPost('id_size_img')){
            $this->id_size_img = magixcjquery_filter_isVar::isPostNumeric($_POST['id_size_img']);
        }
	}

    /**
     * @param $create
     * @return array
     */
    private function load_data_config($create){
        $data = parent::s_data_config();
        /*$assign_exclude = array(
            'lesson_level','lesson_days','lesson_category','lesson_teachers'
        );*/
        foreach($data as $key){
            $id[]=$key['attr_name'];
            $status[]=$key['status'];
        }
        return array_combine($id,$status);
    }

    /**
     * @return array
     */
    private function load_lang_config(){
        $data = backend_db_block_lang::s_data_lang();
        foreach($data as $key){
            //$create->assign($key['idlang'],$key['iso']);
            $id[]=$key['idlang'];
            $iso[]=$key['iso'];
        }
        return array_combine($id,$iso);
    }

    /**
     * @param $create
     */
    private function load_data_setting($create){
        $data = parent::s_data_setting();
        $assign_exclude = array(
            'theme','webmaster','analytics','magix_version'
        );
        foreach($data as $key){
            /*$iso = $val;*/
            if( !(array_search($key['setting_id'],$assign_exclude) ) ){
                $create->assign($key['setting_id'],$key['setting_value']);
            }
        }
    }
	/**
	 * @access private
	 * function load limited_cms_number
	 * @intégrer
	 */
	/*private function load_limited_cms_number(){
		$config = backend_model_setting::tabs_load_config('cms');
		backend_controller_template::assign('idconfigcms',$config['idconfig']);
		backend_controller_template::assign('max_record',$config['max_record']);
	}*/
	/**
	 * Charge les données concernant l'éditeur wysiwyg
	 */
	/*private function load_wysiwyg_config_editor(){
		if(file_exists(magixglobal_model_system::base_path().'framework/js/tiny_mce/plugins/filemanager/')){
			$Init_Filemanager = 1;
		}else{
			$Init_Filemanager = 0;
		}
		$config = backend_model_setting::tabs_uniq_setting('editor');
		backend_controller_template::assign('editor',$config['setting_label']);
		backend_controller_template::assign('tinymce_filemanager',$Init_Filemanager);
		backend_controller_template::assign('manager_setting',$config['setting_value']);
	}*/
    /**
     * @access private
     */
    private function update_config(){
        if(isset($this->lang)){
            parent::u_config_states($this->lang,'lang');
        }
        if(isset($this->cms)){
            parent::u_config_states($this->cms,'cms');
        }
        if(isset($this->news)){
            parent::u_config_states($this->news,'news');
        }
        if(isset($this->catalog)){
            parent::u_config_states($this->catalog,'catalog');
        }
        if(isset($this->metasrewrite)){
            parent::u_config_states($this->metasrewrite,'metasrewrite');
        }
        if(isset($this->plugins)){
            parent::u_config_states($this->plugins,'plugins');
        }
    }
	/**
	 * @access public
	 * @static
	 * load global attribute configuration
	 */
	public static function load_attribute_config(){
        $create = new backend_controller_template();
        /*$config = parent::s_setting_id('editor');
        $create->assign('manager_setting',$config['setting_value']);
        $create->assign('array_lang',self::load_lang_config());*/
        self::load_data_setting($create);
        $create->assign('array_lang',self::load_lang_config());
	}

    /**
     * Chargement du manager d'images et de fichiers pour tinyMCE
     * @param $create
     */
    private function load_editor_data($create){
        $config = parent::s_setting_id('editor');
        $array_manager = array(
            "openFilemanager"=>"openFilemanager(intégré)",
            "imagemanager"=>"imagemanager(payant)",
            "filemanager"=>"filemanager(payant)"
        );
        /**
         * Création du menu select pour la sélection du gestionnaire de fichiers
         */
        $select = backend_model_forms::select_static_row(
            $array_manager,
            array(
                'attr_name'=>'manager_setting',
                'attr_id'=>'manager_setting',
                'class'=>'',
                'attr_multiple'=>false,
                'default_value'=>$config['setting_value'],
                'empty_value'=>'Selectionner le manager',
                'upper_case'=>false
            )
        );
        $create->assign('select_manager',$select);
    }

    /**
     * Mise à jour du gestionnaire de fichiers pour tinymce
     * @param $create
     */
    private function update_manager_setting($create){
        if(isset($this->manager_setting)){
            parent::u_setting_value('editor',$this->manager_setting);
            $create->display('config/request/success_update.phtml');
        }
    }
    private function update_content_css($create){
        if(isset($this->content_css)){
            if(empty($this->content_css)){
                $content_css = null;
            }else{
                $content_css = $this->content_css;
            }
            parent::u_setting_value('content_css',$content_css);
            $create->display('config/request/success_update.phtml');
        }
    }
    /**
     * @param $type
     * @return mixed
     */
    private function img_size_type($type){
        //Tableau des variables à rechercher
        $search = array('small','medium','large');
        $replace = array('Mini','Moyen','Grand');
        return str_replace($search ,$replace,$type);
    }

    /**
     * @param $attr_name
     * @return array
     */
    private function load_img_forms($attr_name){
        $tab_img = array();
        $tab_img[] = array();
        $i = 0;
        foreach(parent::s_attribute_img_size_config($attr_name) as $row){
            $tab_img[$i]['id_size_img'] = $row['id_size_img'];
            $tab_img[$i]['attr_name'] = $row['attr_name'];
            $tab_img[$i]['config_size_attr'] = $row['config_size_attr'];
            $tab_img[$i]['type'] = $row['type'];
            $tab_img[$i]['width'] = $row['width'];
            $tab_img[$i]['height'] = $row['height'];
            $tab_img[$i]['img_resizing'] = $row['img_resizing'];
            $tab_img[$i]['img_size_type'] = $this->img_size_type($row['type']);
            $i++;
        }
        return $tab_img;
    }

    /**
     * Mise à jour de la configuration de taille des images
     * @param $create
     */
    private function update_imagesize($create){
        if(isset($this->id_size_img)){
            parent::u_size_img_config(
                $this->width,
                $this->height,
                $this->img_resizing,
                $this->id_size_img
            );
            $create->display('config/request/success_update.phtml');
        }
    }
	/**
	 * @access public
	 * 
	 * Execution de la configuration
	 */
	public function run(){
		$header= new magixglobal_model_header();
        $create = new backend_controller_template();
        if(isset($this->tab)){
            if($this->tab == 'editor'){
                if(isset($this->action)){
                    if($this->action == 'edit'){
                        if(isset($this->manager_setting)){
                            $this->update_manager_setting($create);
                        }elseif(isset($this->content_css)){
                            $this->update_content_css($create);
                        }
                    }
                }else{
                    $this->load_editor_data($create);
                    $create->display('config/editor.phtml');
                }
            }elseif($this->tab == 'imagesize'){
                if(isset($this->action)){
                    if($this->action == 'edit'){
                        $this->update_imagesize($create);
                    }
                }else{
                    $create->assign('imgsize_news',$this->load_img_forms('news'));
                    $create->assign('imgsize_catalog',$this->load_img_forms('catalog'));
                    $create->display('config/imagesize.phtml');
                }
            }
        }else{
            if(isset($this->action)){
                if($this->action == 'edit'){
                    $this->update_config();
                    $create->display('config/request/success_update.phtml');
                }
            }else{
                $create->assign('array_radio_config',$this->load_data_config($create));
                $create->display('config/index.phtml');
            }
        }
	}
}