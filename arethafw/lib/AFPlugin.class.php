<?php
namespace aretha\lib;

class AFPlugin {

	private static $jsFiles = array();
	private static $cssFiles = array();

	public static function addJS($js) {
		array_push(AFPlugin::jsFiles, $js);
	}

	public static function addCSS($css) {
		array_push(AFPlugin::cssFiles, $css);
	}

	public static function init($json) {

		// echo "<br> debug-> msg:load ADPlugin:";
		$config = json_decode($json);
		$scripts = "";
		$links = "";

		$script  = "";
		// $script .= "<!-- ArethaFW PlugIns -->" . "\n";
		$script .= '<script type="module" id="af-plugins">' . "\n";
		
		// var_dump($config);

		if (count($config->javascript) > 0) {
			
			foreach ($config->javascript as $file) {
				$scripts .= '"' . ARETHA_DIRNAME . "/plugins/" . $config->name . "/js/" . $file . '", ';
			}

			$script .= 'aretha().loadScripts(' . "\n";
			$script .= '	[' . "\n";
			$script .= substr($scripts, 0, -2) . "\n";
			$script .= '	],' . "\n";
			$script .= '	function() { console.log("ArethaFW Plugins Loaded!"); }' . "\n";
			$script .= ');' . "\n" . "\n";
		}
		

		if (count($config->css) > 0) {
			
			foreach ($config->css as $file) {
				$links .= '"' . ARETHA_DIRNAME . "/plugins/" . $config->name . "/css/" . $file . '", ';
			}

			$script .= 'aretha().loadCSS(' . "\n";
			$script .= substr($links, 0, -2)  . "\n";
			$script .= ');' . "\n" . "\n";
		}

		$script .= '</script>' . "\n" . "\n";
		// echo "<br> debug-> msg:load ADPlugin script:".$script;
		echo $script;
	}


}
?>