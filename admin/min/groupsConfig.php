<?php
/**
 * Groups configuration for default Minify implementation
 * @package Minify
 */

/** 
 * You may wish to use the Minify URI Builder app to suggest
 * changes. http://yourdomain/min/builder/
 *
 * See http://code.google.com/p/minify/wiki/CustomSource for other ideas
 **/

return array(
	'adminjs' => array('//framework/library/jquery-1.8.3.min.js','//framework/library/jquery-ui-1.10.0.custom.min.js',
     '//framework/plugins/jquery.form.3.20.js','//framework/plugins/jquery.validate.1.10.0.min.js','//'.PATHADMIN.'/template/js/plugins/bootstrap.min.js',
     '//'.PATHADMIN.'/template/js/plugins/holder.js'),
	'jimagine' => array('//framework/library/jimagine/config.js','//framework/library/jimagine/jmConstant.js',
	'//framework/library/jimagine/plugins/jquery.nicenotify.js','//framework/library/jimagine/plugins/jquery.jmShowIt.js',
    '//'.PATHADMIN.'/template/js/plugins/jquery.fancybox.min.js','//'.PATHADMIN.'/template/js/setting.js'),
	'globalize'=> array('//framework/library/globalize/globalize.js','//framework/library/globalize/cultures/globalize.cultures.js'),
    'charts'=>array('//'.PATHADMIN.'/template/js/plugins/raphael-min.js','//'.PATHADMIN.'/template/js/plugins/morris.min.js'),
    'tinymce' => array('//'.PATHADMIN.'/template/js/tiny_mce.'.VERSION_EDITOR.'/jquery.tinymce.js'),
    'css' => array('//'.PATHADMIN.'/template/css/bootstrap.2.2.2.css','//'.PATHADMIN.'/template/css/font-awesome.css',
    '//'.PATHADMIN.'/template/css/ui-bootstrap/jquery-ui-1.10.0.custom.css','//'.PATHADMIN.'/template/css/fancybox/jquery.fancybox.css',
    '//'.PATHADMIN.'/template/css/jquery.tagsinput.css','//'.PATHADMIN.'/template/css/style.css'),
    'maxAge' => 31536000,
    'setExpires' => time() + 86400 * 365
);