<?php
/*
   +----------------------------------------------------------------------+
   | Author: Yang Yu <yangyu1@staff.sina.com.cn>    create@2009-5-18      |
   +----------------------------------------------------------------------+
*/
require_once("Smarty/Smarty.class.php");
class smarty_excel extends Smarty { 

   function smarty_excel() 
   { 
        $this->Smarty();
        $this->template_dir = ROOT."/templates/";
		$compile_dir = ROOT."/templates_c";
		if (!is_dir($compile_dir)){
			mkdir($compile_dir, 0777);
		}
        $this->compile_dir  = $compile_dir;
        $this->compile_check  = true;
//		$this->force_compile = true;
//		$this->cache_dir    = $compile_dir;
		$this->caching = false;
		$this->debugging = false;
   }
}
?>