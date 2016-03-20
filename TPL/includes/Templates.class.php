<?php
	//模板类
	class Templates{
		//用一个数组接收注入的变量键值对
		private $_vars = array();
		//用一个数组保存系统变量
		private $_config = array();
		public function __construct() {
			if (!is_dir(CACHE_DIR) || !is_dir(TPL_C_DIR) || !is_dir(TPL_DIR)){
				exit('ERROR:缓存目录或模板目录或模板编译目录不存在，请手动添加！');
			}
			//保存系统变量
			$_sxe = simplexml_load_file('config/profile.xml');
			$_tagLib = $_sxe->xpath('/root/taglib');
			foreach ($_tagLib as $_tag) {
				$this->_config["$_tag->name"] = $_tag->value;
			}
		}
		//assign()方法，用于注入变量
		function assign($_var, $_value){
			//$_var用于同步模板里的变量
			if (isset($_var) && !empty($_var)) {
				$this->_vars[$_var] = $_value;

			}else {
				exit('ERROR:请设置模板变量！');
			}

		}
		//display()方法
		function display($_file){
			//设置模板路径
			$_tplFile = TPL_DIR.$_file;
			//判断模板是否存在
			if (!file_exists($_tplFile)){
				exit('ERROR：'.$_file.'模板不存在');
			}
			//生成编译文件
			$_parFile = TPL_C_DIR.md5($_file).$_file.'.php';
			//缓存文件路径
			$_cacheFile = CACHE_DIR.md5($_file).$_file.'.html';
			//判断是否开启缓存
			if (IS_CACHE) {
				//判断缓存文件和编译文件是否存在
				if (file_exists($_cacheFile) && file_exists($_parFile)) {
					//判断模板文件是否修改过，以及编译文件是否修改过
					if (filemtime($_parFile)>=filemtime($_tplFile) && filemtime($_cacheFile)>=filemtime($_parFile)) {
						//echo "我是缓存文件";
						//载入缓存文件
						include $_cacheFile;
						return;
					}
				}
			}
			//如果编译文件不存在，或者已经修改过，则声称编译文件
			if (!file_exists($_parFile) || filemtime($_parFile)<filemtime($_tplFile)) {
				//引入模板解析类
				require ROOT_PATH.'/includes/Parser.class.php';
				//实例化
				$_parser = new Parser($_tplFile); //传入模板文件
				$_parser->complie($_parFile);     //传入编译文件
			}
		//	print_r($this->_vars);
			//载入编译文件
			include $_parFile;
			if (IS_CACHE){
			//获取缓冲区内的数据，并且创建缓存文件
			file_put_contents($_cacheFile,ob_get_contents());
			//清除缓存区（清除了编译文件加载的内容）
			ob_end_clean();
			//载入缓存文件
			include $_cacheFile;
		}
		}

	}


?>
