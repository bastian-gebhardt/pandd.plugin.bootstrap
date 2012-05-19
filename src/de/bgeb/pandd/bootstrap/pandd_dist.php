<?php

class Pandd{
	
	public static function bootStrap(){

		define('PANDD_ENVIRONMENT','@add_environment_here@');
		
		self::setRootConsts();
		
		self::setIncludePath();
		
		self::addAutoLoader();
		
	}
	
	private static function setRootConsts(){
		define('PANDD_APP_ROOT',dirname(__FILE__));
		define('PANDD_SRC_ROOT',PANDD_APP_ROOT.'/src');
		define('PANDD_TEST_ROOT',PANDD_APP_ROOT.'/test');
		define('PANDD_LIB_ROOT',PANDD_APP_ROOT.'/lib');
	}
	
	private static function setIncludePath(){
		set_include_path(
				PANDD_LIB_ROOT.PATH_SEPARATOR
				.PANDD_SRC_ROOT.PATH_SEPARATOR
				.PANDD_TEST_ROOT.PATH_SEPARATOR
				.get_include_path()
		);
	}
		
	private static function addAutoLoader(){
		spl_autoload_register(array(__CLASS__, 'userAutoLoader'));
	}
	private static function userAutoLoader($className){
		if (strpos($className, "\\")===false){
			$classfile = str_replace('_', '/', ltrim($className, '_')) . '.php';
		}
		else {
			$classfile = str_replace('\\', '/', ltrim($className, '\\')) . '.php';
		}
		
		$srcfile = PANDD_SRC_ROOT.'/'.$classfile;
		$libfile = PANDD_LIB_ROOT.'/'.$classfile;
		$testfile = PANDD_TEST_ROOT.'/'.$classfile;
		if(	is_file($srcfile)){
			require_once $srcfile;
		}
		else if (is_file($libfile)){
			require_once $libfile;
		}
		else if (is_file($testfile)){
			require_once $testfile;
		}

		// else continue with the next autoloader
	}


}

?>