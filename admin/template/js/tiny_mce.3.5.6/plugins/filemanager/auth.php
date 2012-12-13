<?php
$baseadmin = '../../../../../../../baseadmin.php';
if(file_exists($baseadmin)){
    require $baseadmin;
    if(!defined('PATHADMIN')){
        throw new Exception('PATHADMIN is not defined');
    }
}
class fileManagerAuth{
    public function basePath(){
        $realpathFilemanager = dirname(realpath( __FILE__ ));
        $filemanagerArrayDir = array(PATHADMIN.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.'tiny_mce.'.VERSION_EDITOR.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'filemanager');
        $filemanagerPath = str_replace($filemanagerArrayDir,array('') , $realpathFilemanager);
        return $filemanagerPath;
    }
    private function mcbackend(){
        require $this->basePath().'lib/mcbackend.php';
    }
    public function mcAuth(){
        $this->mcbackend();
        $members = new backend_controller_admin();
        $members->securePage();
        $members->closeSession();
    }
}
?>