<?php

/**
 * Copyright © 2012 by Bastian Gebhardt
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, 
 * are permitted provided that the following conditions are met:
 * 
 * 1. Redistributions of source code must retain the above copyright notice, 
 *    this list of conditions and the following disclaimer.
 * 
 * 2. Redistributions in binary form must reproduce the above copyright notice, 
 *    this list of conditions and the following disclaimer in the documentation 
 *    and/or other materials provided with the distribution.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" 
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE 
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE 
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR 
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER 
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, 
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE 
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

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