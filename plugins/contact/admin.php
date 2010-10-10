<?php
/**
 * @category   Plugins 
 * @package    Magix CMS
 * @copyright  Copyright (c) 2010 - 2011 (http://www.logiciel-referencement-professionnel.com/)
 * @license    Proprietary software
 * @version    1.0 03-06-2010
 * Update      1.1 11-06-2010
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 * @name contact
 * @version 0.2
 *
 */
class plugins_contact_admin extends database_plugins_contact{
	/**
	 * 
	 * @var idadmin
	 */
	public $idadmin;
	/**
	 * 
	 * @var idlang
	 */
	public $idlang;
	/**
	 * Construct class
	 */
	public function __construct(){
		if(magixcjquery_filter_request::isPost('idadmin')){
			$this->idadmin = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['idadmin']);
		}
		if(magixcjquery_filter_request::isPost('idlang')){
			$this->idlang = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['idlang']);
		}
	}
	/**
	 * @access private
	 * load sql file
	 */
	private function load_sql_file(){
		return backend_controller_plugins::pluginDir().'sql'.DIRECTORY_SEPARATOR.'db.sql';
	}
	/**
	 * @access private
	 * Installation des tables mysql du plugin
	 */
	private function install_table(){
		if(parent::c_show_table() == 0){
			if(file_exists(self::load_sql_file())){
				if(magixglobal_model_db::create_new_sqltable(self::load_sql_file())){
					backend_controller_plugins::append_assign('refresh_plugins','<meta http-equiv="refresh" content="3";URL="'.backend_controller_plugins::pluginUrl().'">');
					$fetch = backend_controller_plugins::append_fetch('request/install.phtml');
					backend_controller_plugins::append_assign('install_db',$fetch);
				}
			}
		}else{
			magixcjquery_debug_magixfire::magixFireInfo('Les tables mysql sont installés', 'Statut des tables mysql du plugin');
			return true;
		}
	}
	/**
	 * @access private
	 * Liste les membres de l'administration
	 */
	private function list_member(){
		$m = '<table class="clear" style="width:60%">
					<thead>
						<tr>
							<th>ID</th>
							<th><span style="float:left;" class="ui-icon ui-icon-person"></span></th>
							<th><span class="magix-icon magix-icon-perms" style="float: left;"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-mail-closed"></span></th>
						</tr>
					</thead>
					<tbody>';
		foreach(backend_db_admin::adminDbMember()->view_list_members() as $list){
			switch($list['perms']){
				case 1:
					$perms = 'Seo Agency';
					break;
				case 2:
					$perms = 'Web Agency';
					break;
				case 3:
					$perms = 'User admin';
					break;
				case 4:
					$perms = 'User';
					break;
			}
			$m .='<tr class="line">';
			$m .='<td class="minimal">'.$list['idadmin'].'</td>';
			$m .='<td class="nowrap">'.$list['pseudo'].'</td>';
			$m .='<td class="nowrap">'.$perms.'</td>';
			$m .='<td class="maximal">'.$list['email'].'</td>';
			$m .='</tr>';
		}
		$m .= '</tbody></table>';
		return $m;
	}
	/**
	 * @access private
	 * Liste les membres pour le formulaire de contact
	 */
	private function list_member_contact(){
		$m = '<table class="clear" style="width:60%">
				<thead>
					<tr>
						<th>ID</th>
						<th><span style="float:left;" class="ui-icon ui-icon-flag"></span></th>
						<th><span style="float:left;" class="ui-icon ui-icon-person"></span></th>
						<th><span style="float:left;" class="ui-icon ui-icon-mail-closed"></span></th>
					</tr>
				</thead>
				<tbody>';
		$lang = '';
		foreach(parent::s_register_contact() as $list){
			switch($list['idlang']){
				case 0:
					$codelang = '<div class="ui-state-error" style="border:none;"><span style="float:left" class="ui-icon ui-icon-cancel"></span></div>';
				break;
				default: 
					$codelang = $list['codelang'];
				break;
			}
			if ($list['codelang'] != $lang) {
				//if ($lang != '') { $m .= "</tr>\n"; }
			       $m .= '<tr class="ui-widget-content"><td>&nbsp;</td><td>&nbsp;</td><td style="text-align:center;text-transform:uppercase;"><span style="font-weight:bold;">'.$list['codelang'].'</span></td><td>&nbsp;</td></tr>';
			}
			$lang = $list['codelang'];
			$m .='<tr class="line">';
			$m .='<td class="minimal">'.$list['idadmin'].'</td>';
			$m .='<td class="minimal">'.$codelang.'</td>';
			$m .='<td class="nowrap">'.$list['pseudo'].'</td>';
			$m .='<td class="maximal">'.$list['email'].'</td>';
			$m .='</tr>';
		}
		$m .= '</tbody></table>';
		return $m;
	}
	/**
	 * @access private
	 * Assign les listes
	 */
	private function display_list(){
		backend_controller_plugins::append_assign('list_member_admin',self::list_member());
		backend_controller_plugins::append_assign('list_member_contact',self::list_member_contact());
	}
	/**
	 * @access private
	 * Insertion d'un contact pour le formulaire
	 */
	private function insert_contact(){
		if(isset($this->idadmin)){
			if(empty($this->idadmin) AND empty($this->idlang)){
				backend_controller_plugins::append_display('request/empty.phtml');
			}else {
				parent::i_contact($this->idadmin,$this->idlang);
				backend_controller_plugins::append_display('request/success.phtml');
			}
		}
	}
	/**
	 * Fonction pour la création des urls dans le sitemap
	 * !!! createSitemap obligatoire pour l'ajout dans le sitemap
	 */
	public function createSitemap(){
		/*instance la classe*/
        $sitemap = new magixcjquery_xml_sitemap();
		   $sitemap->writeMakeNode(
				magixcjquery_html_helpersHtml::getUrl().'/magixmod/contact/',
				date('d-m-Y'),
				'always',
				0.7
		   );
	}
	/**
	 * Affiche les pages de l'administration du plugin
	 * @access public
	 */
	public function run(){
		if(isset($_GET['add'])){
			self::insert_contact();
		}else{
			//Installation des tables mysql
			if(self::install_table() == true){
				self::display_list();
				backend_controller_plugins::append_assign('selectlang',backend_model_blockDom::select_language());
				backend_controller_plugins::append_assign('selectusers',backend_model_blockDom::select_users());
			}
			// Retourne la page index.phtml
			backend_controller_plugins::append_display('index.phtml');
		}
	}
}
class database_plugins_contact{
	/**
	 * Vérifie si les tables du plugin sont installé
	 * @access protected
	 * return integer
	 */
	protected function c_show_table(){
		$table = 'mc_plugins_contact';
		return backend_db_plugins::layerPlugins()->showTable($table);
	}
	protected function s_register_contact(){
		$sql = 'SELECT c.idadmin,c.idlang,lang.codelang,m.pseudo,m.email FROM mc_plugins_contact c
		LEFT JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
		LEFT JOIN mc_admin_member as m ON ( c.idadmin = m.idadmin )
		ORDER BY lang.idlang';
		return backend_db_plugins::layerPlugins()->select($sql);
	}
	protected function i_contact($idadmin,$idlang){
		$sql = 'INSERT INTO mc_plugins_contact (idadmin,idlang) VALUE(:idadmin,:idlang)';
		backend_db_plugins::layerPlugins()->insert($sql,
		array(
			':idadmin'	=>	$idadmin,
			':idlang'	=>	$idlang
		));
	}
}