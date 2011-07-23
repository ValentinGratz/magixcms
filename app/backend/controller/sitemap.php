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
 * @category   Controller 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    5.1
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name sitemap
 *
 */
class backend_controller_sitemap extends backend_db_sitemap{
	/**
	 * Constante PATHPLUGINS
	 * Défini le chemin vers le dossier des plugins
	 * @var string
	 */
	const PATHPLUGINS = 'plugins';
	/**
	 * Creation du fichier xml index (get)
	 * @var void
	 **/
	public $create_xml_index;
	/**
	 * Creation du fichier xml url (get)
	 * @var void
	 **/
	public $create_xml_url;
	/**
	 * Creation du fichier xml images (get)
	 * @var void
	 **/
	public $create_xml_images;
	/**
	 * Ping Google (get)
	 * @var void
	 **/
	public $googleping,$compressionping;
	/**
	 * @access public
	 * Constructor
	 */
	public function  __construct(){
		if(magixcjquery_filter_request::isPost('create_xml_index')) {
			$this->create_xml_index = magixcjquery_form_helpersforms::inputClean($_POST['create_xml_index']);
		}
		if(magixcjquery_filter_request::isPost('create_xml_url')) {
			$this->create_xml_url = magixcjquery_form_helpersforms::inputClean($_POST['create_xml_url']);
		}
		if(magixcjquery_filter_request::isPost('create_xml_images')) {
			$this->create_xml_images = magixcjquery_form_helpersforms::inputClean($_POST['create_xml_images']);
		}
		if(magixcjquery_filter_request::isPost('googleping')) {
			$this->googleping = magixcjquery_form_helpersforms::inputClean($_POST['googleping']);
		}
		if(magixcjquery_filter_request::isPost('compressionping')) {
			$this->compressionping = magixcjquery_form_helpersforms::inputClean($_POST['compressionping']);
		}
	}
	//SITEMAP
	private function lastmod_dateFormat(){
		$dateformat = new magixglobal_model_dateformat();
		return $dateformat->date_w3c();
	}
	/**
	 * Retourne le dossier racine de l'installation de magix cms pour l'écriture du fichier XML
	 * @access private
	 **/
	private function dir_XML_FILE(){
	//		$system = new magixglobal_model_system();
		try {
			return magixglobal_model_system::base_path().DIRECTORY_SEPARATOR;
		}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
	}
	/**
	 * @access private
	 * Ouverture du fichier XML pour ecriture de l'entête
	 **/
	private function createXMLFile(){
		try{
			/*instance la classe*/
	        $sitemap = new magixcjquery_xml_sitemap();
			/*Crée le fichier xml s'il n'existe pas*/
	        $sitemap->createXML($this->dir_XML_FILE(),'sitemap-url.xml');
			/*Ouvre le fichier xml s'il existe*/
	        $sitemap->openFile($this->dir_XML_FILE(),'sitemap-url.xml');
			/*indente les lignes (optionnel)*/
	        $sitemap->indentXML(true);
			/*Ecrit la DTD ainsi que l'entête complète suivi de l'encodage souhaité*/
	    	$sitemap->headSitemap("UTF-8");
	        /*Ecrit les éléments*/
	    	$sitemap->writeMakeNode(
	    		magixcjquery_html_helpersHtml::getUrl(),
	    		$this->lastmod_dateFormat(),
	    		'always',
	    		0.8
	    	);
		}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
	}
	/**
	 * @access private
	 * Ouverture du fichier XML pour ecriture de l'entête
	 **/
	private function createXMLImgFile(){
		try{
			/*instance la classe*/
	        $sitemap = new magixcjquery_xml_sitemap();
			/*Crée le fichier xml s'il n'existe pas*/
	        $sitemap->createXML($this->dir_XML_FILE(),'sitemap-images.xml');
			/*Ouvre le fichier xml s'il existe*/
	        $sitemap->openFile($this->dir_XML_FILE(),'sitemap-images.xml');
			/*indente les lignes (optionnel)*/
	        $sitemap->indentXML(true);
			/*Ecrit la DTD ainsi que l'entête complète suivi de l'encodage souhaité*/
	    	$sitemap->headSitemapImage("UTF-8");
	        /*Ecrit les éléments*/
	    	//$sitemap->writeMakeNode(magixcjquery_html_helpersHtml::getUrl(),date('d-m-Y'),'always',0.8);
		}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
	}
	/**
	 * @access private
	 * Création du fichier sitemap.xml ainsi que l'entête sitemapindex 
	 */
	private function createXMLIndexFile(){
		try{
			/*instance la classe*/
	        $sitemap = new magixcjquery_xml_sitemap();
			/*Crée le fichier xml s'il n'existe pas*/
	        $sitemap->createXML($this->dir_XML_FILE(),'sitemap.xml');
			/*Ouvre le fichier xml s'il existe*/
	        $sitemap->openFile($this->dir_XML_FILE(),'sitemap.xml');
			/*indente les lignes (optionnel)*/
	        $sitemap->indentXML(true);
			/*Ecrit la DTD ainsi que l'entête complète suivi de l'encodage souhaité*/
	    	$sitemap->headSitemapIndex("UTF-8");
		}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
	}
	/**
	 * @access private
	 * Ecriture dans le sitemapindex 
	 */
	private function writeIndex(){
		/*instance la classe*/
        $sitemap = new magixcjquery_xml_sitemap();
        $sitemap->writeMakeNodeIndex(
        	magixcjquery_html_helpersHtml::getUrl().'/sitemap-url.xml',
        	$this->lastmod_dateFormat()
        );
        ///magixcjquery_debug_magixfire::magixFireLog(magixcjquery_html_helpersHtml::getUrl().'/sitemap-url.xml');
        $config = backend_model_setting::tabs_load_config('catalog');
		if($config['status'] == 1){
        	$sitemap->writeMakeNodeIndex(
        		magixcjquery_html_helpersHtml::getUrl().'/sitemap-images.xml',
        		$this->lastmod_dateFormat()
        	);
		}
	}
	/**
	 * @access private
	 * Si les NEWS sont activé, on inscrit les URLs dans le sitemap
	 */
	private function writeNews(){
		/*instance la classe*/
        $sitemap = new magixcjquery_xml_sitemap();
        $config = backend_model_setting::tabs_load_config('news');
		if($config['status'] == 1){
			/**
			 * La racine des news par langue
			 */
			foreach(parent::s_root_news_sitemap() as $data){
	        	 $sitemap->writeMakeNode(
	        	 	magixcjquery_html_helpersHtml::getUrl().magixglobal_model_rewrite::filter_news_root_url($data['iso'],true),
		        	$this->lastmod_dateFormat(),
		        	'always',
		        	0.7
	        	 );
	        }
	        /**
	         * Les news par langue
	         */
	        foreach(parent::s_news_sitemap() as $data){
	        	$curl = new magixglobal_model_dateformat($data['date_register']);
	        	 $sitemap->writeMakeNode(
	        	 	 magixcjquery_html_helpersHtml::getUrl().magixglobal_model_rewrite::filter_news_url($data['iso'],$curl->date_europeen_format(),$data['n_uri'],$data['keynews'],true),
		        	 $this->lastmod_dateFormat(),
		        	 'always',
		        	 0.8
	        	 );
	        }
		}
	}
	/**
	 * Si le CMS est activé, on inscrit les URLs dans le sitemap
	 * @access private
	 */
	private function writeCms(){
		/*instance la classe*/
        $sitemap = new magixcjquery_xml_sitemap();
        $config = backend_model_setting::tabs_load_config('cms');
		if($config['status'] == 1){
	        foreach(parent::s_cms_sitemap() as $data){
	        	/*if($data['date_register'] == '0000-00-00 00:00:00'){
	        		$date_page = date('d-m-Y');
	        	}else{
	        		$date_page = $data['date_register'];
	        	}*/
	        	if($data['idcat_p'] != 0 AND $data['uri_category'] != null){
					$uricms = magixglobal_model_rewrite::filter_cms_url(
						$data['iso'], 
						$data['idcat_p'], 
						$data['uri_category'], 
						$data['idpage'], 
						$data['uri_page'],
						true
					);
				}else{
					$uricms = magixglobal_model_rewrite::filter_cms_url(
						$data['iso'], 
						null, 
						null, 
						$data['idpage'], 
						$data['uri_page'],
						true
					);
				}
		       	$sitemap->writeMakeNode(
				    magixcjquery_html_helpersHtml::getUrl().$uricms,
				    $this->lastmod_dateFormat(),
				    'always',
				     0.9
		        );
	        }
		}
	}
	/**
	 * Si le catalogue est activé, on inscrit les URLs dans le sitemap
	 * @access private
	 */
	private function writeCatalog(){
		/*instance la classe*/
        $sitemap = new magixcjquery_xml_sitemap();
        $config = backend_model_setting::tabs_load_config('catalog');
		if($config['status'] == 1){
			foreach(parent::s_catalog_category_sitemap() as $data){
		       	$sitemap->writeMakeNode(
			       	 magixcjquery_html_helpersHtml::getUrl().magixglobal_model_rewrite::filter_catalog_category_url(
						$data['iso'], 
						$data['pathclibelle'], 
						$data['idclc'], 
						true
					),
					$this->lastmod_dateFormat(),
				    'always',
				     0.8
		        );
	        }
		foreach(parent::s_catalog_subcategory_sitemap() as $data){
		       	$sitemap->writeMakeNode(
			       	  magixcjquery_html_helpersHtml::getUrl().magixglobal_model_rewrite::filter_catalog_subcategory_url(
						$data['iso'], 
						$data['pathclibelle'], 
						$data['idclc'],
						$data['pathslibelle'], 
						$data['idcls'], 
						true
					),
					$this->lastmod_dateFormat(),
				    'always',
				     0.8
		        );
	        }
	        foreach(parent::s_catalog_sitemap() as $data){
	        	$uri = magixglobal_model_rewrite::filter_catalog_product_url(
	        		$data['iso'], 
	        		$data['pathclibelle'], 
	        		$data['idclc'],
	        		$data['pathslibelle'], 
	        		$data['idcls'], 
	        		$data['urlcatalog'], 
	        		$data['idproduct'],
	        		true
	        	);
		       	$sitemap->writeMakeNode(
		       		magixcjquery_html_helpersHtml::getUrl().$uri,
			       	$this->lastmod_dateFormat(),
				    'always',
				     0.9
		        );
	        }
		}
	}
	/**
	 * @access private
	 * Ecrit les urls des images du catalogue (Google Image sitemap)
	 */
	private function writeImagesCatalog(){
		/*instance la classe*/
        $sitemap = new magixcjquery_xml_sitemap();
		/**
		 * Les images des catégories du catalogue sur la racine de celui-ci
		 */
		foreach(parent::count_catalog_category_sitemap_by_lang() as $data){
			if($data['catimg'] != 0){
				$sitemap->writeMakeNodeImage(
					magixcjquery_html_helpersHtml::getUrl().magixglobal_model_rewrite::filter_catalog_root_url($data['iso'],true),
					'img_c',
					magixcjquery_html_helpersHtml::getUrl().'/upload/catalogimg/category/',
					parent::s_catalog_category_images_by_lang($data['idlang'])
				);
			}
		}
		/**
		 * Les images des sous catégories du catalogue de chaque catégorie
		 **/
		foreach(parent::s_catalog_category_sitemap() as $data){
			$count = parent::count_catalog_subcategory_sitemap($data['idclc']);
			if($count['subcatimg'] != 0){
				$uri_cat = magixglobal_model_rewrite::filter_catalog_category_url($data['iso'],$data['pathclibelle'],$data['idclc'],true);
				$sitemap->writeMakeNodeImage(
					magixcjquery_html_helpersHtml::getUrl().$uri_cat,
					'img_s',
					magixcjquery_html_helpersHtml::getUrl().'/upload/catalogimg/subcategory/',
					parent::s_catalog_subcategory_images_by_lang($data['idclc'])
				);
			}
		}
		/**
		 * Les images des produits du catalogue
		 */
		foreach(parent::s_catalog_product_images() as $data){
			$uri = magixglobal_model_rewrite::filter_catalog_product_url(
        		$data['iso'], 
        		$data['pathclibelle'], 
        		$data['idclc'],
        		$data['pathslibelle'], 
        		$data['idcls'], 
        		$data['urlcatalog'], 
        		$data['idproduct'],
        		true
	        );
			$sitemap->writeMakeNodeImage(
				magixcjquery_html_helpersHtml::getUrl().$uri,
				$data['imgcatalog'],
				magixcjquery_html_helpersHtml::getUrl().'/upload/catalogimg/product/'
			);
		}
	}
	/**
	 * execute ou instance la class du plugin
	 * @param void $className
	 */
	private function get_call_class($module){
		try{
			$class =  new $module;
			if($class instanceof $module){
				return $class;
			}else{
				throw new Exception('not instantiate the class: '.$module);
			}
		}catch(Exception $e) {
			magixglobal_model_system::magixlog("Error plugins execute", $e);
		}
	}
	/**
	 * Récupération des options pour la génération
	 * @param string $module
	 */
	private function ini_options_mod($module){
		if(method_exists($this->get_call_class($module),'sitemap_rewrite_options')){
			/* Appelle la  fonction utilisateur sitemap_rewrite_options contenue dans le module */
			$call_options = call_user_func(
				array($this->get_call_class($module),'sitemap_rewrite_options')
			);
			if(is_array($call_options)){
				return $call_options;
			}else{
				throw new Exception('ini_options_mod '.$module.' is not array');
			}
		}/*else{
			throw new Exception('Method "sitemap_rewrite_options" does not exist');
		}*/
	}
	/**
	 * @access private
	 * return void
	 */
	private function directory_plugins(){
		return $this->dir_XML_FILE().self::PATHPLUGINS.DIRECTORY_SEPARATOR;
	}
	/**
	 * 
	 * Création/Ecriture dans le fichier sitemap correspondant
	 * @param string $lang
	 * @param string $module
	 */
	private function loadConfigPlugins($class){
		$options_mod = $this->ini_options_mod($class);
		// Génération de l'index
		switch($options_mod['index']){
			case 0:
				null;
			break;
			case 1:
				/*call_user_func_array(
					array($this->get_call_class($class),'sitemap_uri_index'), 
					array($name)
				);*/
				call_user_func(array($this->get_call_class($class),'sitemap_uri_index'));
			break;
		}
		// Génération du niveau 1
		switch($options_mod['level1']){
			case 0:
				null;
			break;
			case 1:
				/*call_user_func_array(
					array($this->get_call_class($class),'sitemap_uri_category'), 
					array($name)
				);*/
				call_user_func(array($this->get_call_class($class),'sitemap_uri_category'));
			break;
		}
		// Génération du niveau 2
		switch($options_mod['level2']){
			case 0:
				null;
			break;
			case 1:
				/*call_user_func_array(
					array($this->get_call_class($class),'sitemap_uri_subcategory'), 
					array($name)
				);*/
				call_user_func(array($this->get_call_class($class),'sitemap_uri_subcategory'));
			break;
		}
		// Génération du dernier niveau
		switch($options_mod['records']){
			case 0:
				null;
			break;
			case 1:
				/*call_user_func_array(
					array($this->get_call_class($class),'sitemap_uri_record'), 
					array($name)
				);*/
				call_user_func(array($this->get_call_class($class),'sitemap_uri_record'));
			break;
		}
	}
	/**
	 * Scanne les plugins et vérifie si la fonction createSitemap 
	 * exist afin de l'intégrer dans le sitemap
	 * @access private
	 */
	private function writeplugin(){
		try{
			plugins_Autoloader::register();
			/**
			 * Si le dossier est accessible en lecture
			 */
			if(!is_readable($this->directory_plugins())){
				throw new exception('Error in writeplugin: Plugin is not minimal permission');
			}
			$makefiles = new magixcjquery_files_makefiles();
			$dir = $makefiles->scanRecursiveDir($this->directory_plugins());
			if($dir != null){
				foreach($dir as $d){
					if(file_exists($this->directory_plugins().$d.DIRECTORY_SEPARATOR.'admin.php')){
						$pluginPath = $this->directory_plugins().$d;
						if($makefiles->scanDir($pluginPath) != null){
							if(class_exists('plugins_'.$d.'_admin')){
								/*$create = self::get_call_class('plugins_'.$d.'_admin');
								//Si la méthode existe on execute la fonction createSitemap du plugin
								if(method_exists($create,'createSitemap')){
									$create->createSitemap();
								}*/
								$this->loadConfigPlugins('plugins_'.$d.'_admin');
							}
						}
					}
				}
			}
		}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
	}
	/**
	 * Fin de l'écriture du XML + fermeture balise
	 */
	private function endXMLWriter(){
		/*instance la classe*/
        $sitemap = new magixcjquery_xml_sitemap();
		/*Termine les noeuds*/
        $sitemap->endWrite();
	}
	/**
	 * Construction des plugins enregistré dans l'autoload et qui comporte un sitemap
	 */
	private function register_plugins(){
		$register = null;
		/**
		 * Appel les plugins enregistré dans l'autoload
		 */
		plugins_Autoloader::register();
		/**
		 * Si le dossier est accessible en lecture
		 */
		if(!is_readable($this->directory_plugins())){
			throw new exception('Error in register plugin: Plugin is not minimal permission');
		}
		/**
		 * Appel de la classe makeFiles dans magixcjquery
		 * @var void
		 */
		$makefiles = new magixcjquery_files_makefiles();
		/**
		 * scanne les dossiers du dossier plugins
		 * @var array()
		 */
		$dir = $makefiles->scanRecursiveDir($this->directory_plugins());
		if($dir != null){
			foreach($dir as $d){
				/**
				 * Si le fichier exist on continue
				 */
				if(file_exists($this->directory_plugins().$d.DIRECTORY_SEPARATOR.'admin.php')){
					/**
					 * Retourne le dossier ou chemin vers le dossier du plugin
					 * @var string
					 */
					$pluginPath = $this->directory_plugins().$d;
					if($makefiles->scanDir($pluginPath) != null){
						//Si la classe exist on recherche la fonction createSitemap
						if(class_exists('plugins_'.$d.'_admin')){
							$create = $this->get_call_class('plugins_'.$d.'_admin');
							//Si la méthode existe on ajoute le plugin dans le sitemap
							if(method_exists($create,'createSitemap')){
								$register .= '<tr class="line">
								<td class="maximal">'.magixcjquery_string_convert::ucFirst($d).'</td>
								<td class="nowrap"><span style="float:left;" class="ui-icon ui-icon-calculator"></span></td>
								<td class="nowrap"><span style="float:left;" class="ui-icon ui-icon-check"></span></td>
							</tr>';
							}
						}
					}
				}
			}
		}
		return $register;
	}
	/**
	 * Affiche la page d'administration des sitemaps
	 */
	private function display(){
		$statnews = parent::s_count_news_max();
		$statcms = parent::s_count_cms_max();
		$statcatalog = backend_db_catalog::adminDbCatalog()->s_count_catalog_max();
		$confignews = backend_model_setting::tabs_load_config('news');
		/**
		 * Statistique des news
		 * @var $statnews void
		 */
		if($confignews['status'] == 1){
			backend_controller_template::assign('statnews',$statnews['total']);
		}
		/**
		 * Statistique du CMS
		 * @var $statcms void
		 */
		$configcms = backend_model_setting::tabs_load_config('cms');
		if($configcms['status'] == 1){
			backend_controller_template::assign('statcms',$statcms['total']);
		}
		/**
		 * Statistique du catalogue
		 * @var $statcatalog void
		 */
		$configcatalog = backend_model_setting::tabs_load_config('catalog');
		if($configcatalog['status'] == 1){
			backend_controller_template::assign('statcatalog',$statcatalog['total']);
		}
		backend_controller_template::assign('statplugins',$this->register_plugins());
		backend_controller_template::display('sitemap/index.phtml');
	}
	/**
	 * Compression GZ du fichier XML
	 */
	private function execute_compression(){
		$sitemap = new magixcjquery_xml_sitemap();
		/*Compression GZ souhaitée*/
        $sitemap->setGZCompressionLevel(9);
		/*Création du fichier GZ à partir de l'XML*/
        $sitemap->createGZ($this->dir_XML_FILE(),'sitemap.xml.gz','sitemap.xml');
	}
	/**
	 * Pinguer Google
	 */
	private function execPing(){
		$sitemap = new magixcjquery_xml_sitemap();
		backend_controller_template::assign('sitemap','sitemap.xml');
		$sitemap->sendSitemapGoogle(substr(magixcjquery_html_helpersHtml::getUrl(),7),'sitemap.xml');
		backend_controller_template::display('sitemap/request/ping.phtml');
	}
	/**
	 * Compression GZ + ping Google
	 */
	private function execCompressionPing(){
		$sitemap = new magixcjquery_xml_sitemap();
		if(!extension_loaded('zlib')) {
			backend_controller_template::assign('sitemap','sitemap.xml');
			$sitemap->sendSitemapGoogle(substr(magixcjquery_html_helpersHtml::getUrl(),7),'sitemap.xml');
		}else{
			$this->execute_compression();
			backend_controller_template::assign('sitemap','sitemap.xml.gz');
			$sitemap->sendSitemapGoogle(substr(magixcjquery_html_helpersHtml::getUrl(),7),'sitemap.xml.gz');
		}
		backend_controller_template::display('sitemap/request/ping.phtml');
	}
	/**
	 * @access private
	 * Execution de la création du fichier index
	 */
	private function execIndex(){
		$this->createXMLIndexFile();
		$this->writeIndex();
		$this->endXMLWriter();
		backend_controller_template::display('sitemap/request/success.phtml');
	}
	/**
	 * @access private
	 * Execute l'écriture dans le fichier XML
	 */
	private function exec(){
			$this->createXMLFile();
			$this->writeNews();
			$this->writeCms();
			$this->writeCatalog();
			$this->writeplugin();
			$this->endXMLWriter();
			backend_controller_template::display('sitemap/request/success.phtml');
	}
	/**
	 * @access private
	 * Execution de la création du sitemap des images
	 */
	private function execImages(){
		$config = backend_model_setting::tabs_load_config('catalog');
		if($config['status'] == 1){
			$this->createXMLImgFile();
			$this->writeImagesCatalog();
			$this->endXMLWriter();
			backend_controller_template::display('sitemap/request/success.phtml');
		}else{
			backend_controller_template::display('sitemap/request/noimages.phtml');
		}
	}
	/**
	 * Execute le module dans l'administration
	 * @access public
	 */
	public function run(){
		if($this->create_xml_index){
			$this->execIndex();
		}elseif($this->create_xml_url){
			$this->exec();
		}elseif($this->create_xml_images){
			$this->execImages();
		}elseif($this->googleping){
			$this->execPing();
		}elseif($this->compressionping){
			$this->execCompressionPing();
		}else{
			$this->display();
		}
	}
}