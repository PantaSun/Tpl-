<?php
	/**
	 * 模板解析类
	 */
	class Parser
	{
		//保存模板内容
		private $_tpl;
		//获取模板文件
		function __construct($_tplFile){
			if (!$this->_tpl = file_get_contents($_tplFile)) {
				exit('ERROR：读取模板文件错误！');
			}
		}

		//解析普通变量
		private function parVar(){
			$_patten = '/\{\$([\w]+)\}/';
			if (preg_match($_patten, $this->_tpl)) {
				$this->_tpl = preg_replace($_patten,"<?php echo \$this->_vars['$1']; ?>",$this->_tpl);
			}
		}
		//解析if语句
		private function parIf(){
			$_pattenif = '/\{if\s+\$([\w]+)\}/';
			$_pattenendif = '/\{\/if\}/';
			$_pattenelse = '/\{else\}/';
			if (preg_match($_pattenif,$this->_tpl)) {
				if (preg_match($_pattenendif,$this->_tpl)) {
						$this->_tpl = preg_replace($_pattenif,"<?php if (\$this->_vars['$1']){?>",$this->_tpl);
						$this->_tpl = preg_replace($_pattenendif,"<?php }?>",$this->_tpl);
						if (preg_match($_pattenelse,$this->_tpl)) {
							$this->_tpl = preg_replace($_pattenelse,"<?php }else{ ?>",$this->_tpl);
						}
				}else {
					exit('ERROR:if 语句没有关闭！！');
				}
			}

		}
		//解析动态注释
		private function parCommon(){
			$_pattencom = '/\{#\}(.*)\{#\}/';
			if (preg_match($_pattencom, $this->_tpl)) {
				$this->_tpl = preg_replace($_pattencom,"<?php /* $1 */ ?>",$this->_tpl);
			}
		}
		//解析foreach语句
		private function parForeach(){
			$_pattenforeach = '/\{foreach\s\$+([\w]+)\(\$([\w]+),\$([\w]+)\)\}/';
			$_pattenendforeach = '/\{\/foreach\}/';
			$_pattenvar = '/\{@([\w]+)\}/';
			if (preg_match($_pattenforeach,$this->_tpl)) {
				if (preg_match($_pattenendforeach,$this->_tpl)) {
					$this->_tpl = preg_replace($_pattenforeach,"<?php foreach(\$this->_vars['$1'] as \$$2=>\$$3){ ?>",$this->_tpl);
					$this->_tpl = preg_replace($_pattenendforeach,"<?php } ?>",$this->_tpl);
					if (preg_match($_pattenvar,$this->_tpl)) {
						$this->_tpl = preg_replace($_pattenvar,"<?php echo $$1 ?>",$this->_tpl);
					}
				}else {
					exit('ERROR:缺少foreach结束语句！！！');
				}
			}
		}
		//解析系统变量
		private function parConfig(){
			$_pattenconfig = '/<!--\{([\w]+)\}-->/';
			if (preg_match($_pattenconfig,$this->_tpl)) {
				$this->_tpl = preg_replace($_pattenconfig,"<?php echo \$this->_config['$1'];?>",$this->_tpl);
			}
		}
		//解析include方法
		private function parInclude(){
			$_patteninclude = '/\{include\s+file=\"([\w\.\-]+)\"\}/';
			if (preg_match($_patteninclude,$this->_tpl,$_file)) {
				if (!file_exists($_file[1])) {
					exit('ERROR:'.$_file[1].'文件不存在或为空！！');
				}
				$this->_tpl = preg_replace($_patteninclude,"<?php include '$1' ?>",$this->_tpl);
			}
		}
		//对外公共方法
		function complie($_parFile){
			//解析模板文件
			$this->parVar();
			$this->parIf();
			$this->parCommon();
			$this->parForeach();
			$this->parInclude();
			$this->parConfig();
			//生成编译文件
			if (!file_put_contents($_parFile,$this->_tpl)){
				exit('ERROR：生成编译文件失败！');
			}
		}
	}



?>
