<?php
/**
 * @category   Admin Index
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-10-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
/**
 * Charge toutes les Classes de l'application
 */
require($_SERVER['DOCUMENT_ROOT'].'/app/backend/autoload.php');
$loaderFilename = $_SERVER['DOCUMENT_ROOT'].'/lib/loaderIniclass.php';
if (!file_exists($loaderFilename)) {
	print "<p>Loader is not found<br />Contact Webmestre: aurelien@web-solution-way.be</p>";
	exit;
}else{
	require $loaderFilename;
}
/**
 * Autoload Frontend
 */
backend_Autoloader::register();
$members = new backend_controller_admin();
$members->securePage();
$members->closeSession();
if(magixcjquery_filter_request::isSession('useradmin')){
	if(magixcjquery_filter_request::isGet('dashboard')){
		backend_controller_config::load_attribute_config();
		if(magixcjquery_filter_request::isGet('home')){
			$home = new backend_controller_home();
			if(magixcjquery_filter_request::isGet('edit')){
				$home->edit();
			}elseif(magixcjquery_filter_request::isGet('delhome')){
				$home->del_home();
			}else{
				$home->display();
			}
		}elseif(magixcjquery_filter_request::isGet('config')){
			$config = new backend_controller_config();
			if(magixcjquery_filter_request::isGet('metasrewrite')){
				if(magixcjquery_filter_request::isGet('edit')){
					$config->display_seo_edit();
				}else{
					$config->display_seo();
				}
			}else{
				$config->display();
			}
		}elseif(magixcjquery_filter_request::isGet('user')){
			$user = new backend_controller_user();
			if(magixcjquery_filter_request::isGet('post')){
				$user->post();
			}elseif(magixcjquery_filter_request::isGet('deluser')){
				$user->delete_user();
			}elseif(magixcjquery_filter_request::isGet('edit')){
				$user->display_edit();
			}else{
				$user->display();
			}
		}elseif(magixcjquery_filter_request::isGet('lang')){
			$ini = new backend_controller_lang();
			if(magixcjquery_filter_request::isGet('edit')){
				$ini->edit();
			}if(magixcjquery_filter_request::isGet('dellang')){
				$ini->delete_lang_record();
			}else{
				$ini->display();
			}
		}elseif(magixcjquery_filter_request::isGet('news')){
			$news = new backend_controller_news();
			if(magixcjquery_filter_request::isGet('edit')){
				$news->edit();
			}elseif(magixcjquery_filter_request::isGet('rewrite')){
				if(magixcjquery_filter_request::isGet('getrewrite')){
					$news->edit_rewrite();
				}elseif(magixcjquery_filter_request::isGet('drmetas')){
					$news->del_rewrite_metas();
				}else{
					$news->rewrite_display();
				}
			}elseif(magixcjquery_filter_request::isGet('addnews')){
				$news->display_addnews();
			}elseif(magixcjquery_filter_request::isGet('delnews')){
				$news->del_news();
			}else{
				$news->display_news();
			}
		}elseif(magixcjquery_filter_request::isGet('cms')){
			$ini = new backend_controller_cms();
			if(magixcjquery_filter_request::isGet('add')){
				if(magixcjquery_filter_request::isGet('post')){
					$ini->insert_new_page();
					$ini->display_page();
				}else{
					$ini->display_page();
				}
			}elseif(magixcjquery_filter_request::isGet('getcms')){
				if(magixcjquery_filter_request::isGet('post')){
					$ini->update_page();
					$ini->display_edit_page();
				}else{
					$ini->display_edit_page();
				}
			}elseif(magixcjquery_filter_request::isGet('navigation')){
				$ini->display_navigation();
			}elseif(magixcjquery_filter_request::isGet('delpage')){
				$ini->delete_page_cms();
			}elseif(magixcjquery_filter_request::isGet('category')){
				if(magixcjquery_filter_request::isGet('post')){
					$ini->insertion_category();
				}else{
					$ini->display_category();
				}
			}elseif(magixcjquery_filter_request::isGet('ucategory')){
				$ini->edit_category_cms();
			}elseif(magixcjquery_filter_request::isGet('dcmscat')){
				$ini->delete_category_cms();
			}
			else{
				$ini->display_view();
			}
		}elseif(magixcjquery_filter_request::isGet('catalog')){
			$catalog = new backend_controller_catalog();
			if(magixcjquery_filter_request::isGet('category')){
				if(magixcjquery_filter_request::isGet('delc')){
					$catalog->delete_catalog_category();
				}elseif(magixcjquery_filter_request::isGet('dels')){
					$catalog->delete_catalog_subcategory();
				}elseif(magixcjquery_filter_request::isGet('post')){
					$catalog->post_category();
				}else{
					$catalog->display_category();
				}
			}elseif(magixcjquery_filter_request::isGet('upcat')){
					$catalog->display_edit_category();
			}elseif(magixcjquery_filter_request::isGet('upsubcat')){
					$catalog->display_edit_subcategory();
			}elseif(magixcjquery_filter_request::isGet('product')){
				if(magixcjquery_filter_request::isGet('addproduct')){
					$catalog->insert_new_product();
					$catalog->display_product();
				}elseif(magixcjquery_filter_request::isGet('editproduct')){
					if(magixcjquery_filter_request::isGet('updateproduct')){
						$catalog->update_specific_product();
						$catalog->display_edit_product();
					}else{
						$catalog->display_edit_product();
					}
				}elseif(magixcjquery_filter_request::isGet('moveproduct')){
					if(magixcjquery_filter_request::isGet('postmoveproduct')){
						$catalog->move_specific_product();
					}else{
						$catalog->display_move_product();
					}
				}elseif(magixcjquery_filter_request::isGet('copyproduct')){
					if(magixcjquery_filter_request::isGet('postcopyproduct')){
						$catalog->copy_product();
					}else{
						$catalog->display_copy_product();
					}
				}elseif(magixcjquery_filter_request::isGet('getimg')){
					if(magixcjquery_filter_request::isGet('postimgproduct')){
						$catalog->insert_image_product();
					}elseif(magixcjquery_filter_request::isGet('postimggalery')){
						$catalog->insert_image_galery();
					}elseif(magixcjquery_filter_request::isGet('delmicro')){
						$catalog->delete_image_microgalery();
					}else{
						$catalog->display_product_image();
					}
				}elseif(magixcjquery_filter_request::isGet('delproduct')){
					$catalog->delete_catalog_product();
				}else{
					$catalog->display_product();
				}
			}elseif(magixcjquery_filter_request::isGet('order')){
				$catalog->executeOrderCategory();
				$catalog->executeOrderSubCategory();
			}elseif(magixcjquery_filter_request::isGet('json')){
				$catalog->get_select_json_construct();
			}else{
				$catalog->display();
			}
		}elseif(magixcjquery_filter_request::isGet('forms')){
			$ini = new backend_controller_formsconstruct();
			if(magixcjquery_filter_request::isGet('addforms')){
				
			}elseif(magixcjquery_filter_request::isGet('editforms')){
				
			}elseif(magixcjquery_filter_request::isGet('getforms')){
				$ini->display_forms_input();
			}elseif(magixcjquery_filter_request::isGet('delinput')){
				$ini->delete_input();
			}
			else{
				$ini->display_index();
			}
		}elseif(magixcjquery_filter_request::isGet('templates')){
			$tpl = new backend_controller_templates();
			if(magixcjquery_filter_request::isGet('post')){
				$tpl->send_post_template();
			}else{
				$tpl->view_tpl_screen();
			}
		}elseif(magixcjquery_filter_request::isGet('plugin')){
			$plugin = new backend_controller_plugins();
			$plugin->display_plugins();
		}elseif(magixcjquery_filter_request::isGet('googletools')){
			$googletools = new backend_controller_googletools();
			if(magixcjquery_filter_request::isGet('pgdata')){
				$googletools->post_gdata();
			}else{
				$googletools->display_gdata();
			}
		}elseif(magixcjquery_filter_request::isGet('sitemap')){
			$sitemap = new backend_controller_sitemap();
			if(magixcjquery_filter_request::isGet('createxml')){
				$sitemap->exec();
			}elseif(magixcjquery_filter_request::isGet('googleping')){
				$sitemap->execPing();
			}else{
				$sitemap->display();
			}
		}else{
			$ini = new backend_controller_dashboard();
			$ini->display();
		}
	}else{
		if (!headers_sent()) {
			header('location: '.magixcjquery_html_helpersHtml::getUrl().'/admin/dashboard/');
			exit();
		}
	}
}
?>