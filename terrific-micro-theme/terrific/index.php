<?php

define('BASE', dirname(__FILE__) . '/');
define('DEV', true);
define('MAX_CACHE_AGE', 86400); // Max terrific cache age in seconds

global $nocache;
$nocache = true;

/**
 * Output module markup.
 */
function module($name, $template = null, $skin = null, $attr = array()) {
    $flat = strtolower($name);
    $dashed = strtolower(preg_replace(array('/([A-Z]+)([A-Z][a-z])/', '/([a-z\d])([A-Z])/'), array('\\1-\\2', '\\1-\\2'), $name));
    $template = $template == null ? '' : '-' . $template;
    $skin = $skin == null ? '' : ' skin-' . $dashed . '-' . $skin;
    $attributes = " ";
    foreach ($attr as $key => $value) {
        $attributes .= $key . '="' . $value . '" ';
    }
    echo "<div class=\"mod mod-" . $dashed . $skin . "\"" . chop($attributes) . ">" . "\n";
    require dirname(__FILE__) . '/modules/' . $name . '/' . $flat . $template . '.php';
    echo "\n</div>";
}

/**
 * Compile a CSS/LESS/SCSS file.
 */
function compile($filename, $extension, $base = false) {
    global $nocache;
    switch ($extension) {
        case 'less':
            $modified = filemtime($filename);
            $cachefile = sys_get_temp_dir() . '/terrific-' . md5($filename) . '.css';
            if ($nocache || !is_file($cachefile) || (filemtime($cachefile) != $modified)) {
                require_once BASE . 'library/lessphp/lessc.inc.php';
                $less = new lessc;
                $content = $less->compileFile($filename);
                file_put_contents($cachefile, $content);
                touch($cachefile, $modified);
                if ($base) {
                    $nocache = true;
                }
            } else {
                $content = file_get_contents($cachefile);
            }
            break;

        case 'scss':
            $modified = filemtime($filename);
            $cachefile = sys_get_temp_dir() . '/terrific-' . md5($filename) . '.css';
            if ($nocache || !is_file($cachefile) || (filemtime($cachefile) != $modified)) {
                require_once BASE . 'library/phpsass/SassParser.php';
                $sass = new SassParser(array('style'=>'nested', 'cache' => false));
                $content = $sass->toCss($filename);
                file_put_contents($cachefile, $content);
                touch($cachefile, $modified);
                if ($base) {
                    $nocache = true;
                }
            } else {
                $content = file_get_contents($cachefile);
            }
            break;

        default:
            $content = file_get_contents($filename);
            break;
    }
    return $content;
}

/**
 * Dump CSS/JS.
 */
function dump($extension, $mimetype) {	
	@unlink(dirname(__FILE__) . '/../cache/app.'.$extension);
	
    $formats = array(
        'js' => array('js'),
        'css' => array('less', 'scss', 'css')
    );
    $files = array();
    $output = "";
    $assets = json_decode(file_get_contents(BASE . '/assets/assets.json'));
    foreach ($assets->$extension as $pattern) {
        foreach (glob(BASE . 'assets/' . $extension . '/' . $pattern) as $entry) {
            if (is_file($entry) && !array_key_exists($entry, $files)) {
                $format = substr(strrchr($entry, '.'), 1);
                $output .= compile($entry, $format, true);
                $files[$entry] = true;
            }
        }
    }
    foreach (glob(BASE . 'modules/*', GLOB_ONLYDIR) as $dir) {
        $module = basename($dir);
        foreach ($formats[$extension] as $format) {
            $entry = $dir . '/' . $extension . '/' . strtolower($module) . '.' . $format;
            if (is_file($entry) && !array_key_exists($entry, $files)) {
                $output .= compile($entry, $format);
                $files[$entry] = true;
            }
            foreach (glob($dir . '/' . $extension . '/*-*.' . $format) as $entry) {
                if (is_file($entry) && !array_key_exists($entry, $files)) {
                    $output .= compile($entry, $format);
                    $files[$entry] = true;
                }
            }
        }
    }

    if (isset($_REQUEST['min']) || !DEV) {
        switch ($extension) {
            case 'css':
                require BASE . 'library/cssmin/cssmin.php';
                $output = CssMin::minify($output);
                break;
            case 'js':
                require BASE . 'library/jsmin/jsmin.php';
                $output = JsMin::minify($output);
                break;
        }
    }
    header("Content-Type: " . $mimetype);
    
    $cache_dir = BASE . '/../cache/';
    file_put_contents($cache_dir.'app.'.$extension, $output);
    
    echo $output;
}

if (preg_match("/\/app.css/",$_SERVER['REQUEST_URI'])) {
	$cache_dir = BASE . '/../cache/';
	$file = $cache_dir . 'app.css';
	if (is_file($file) && !DEV) {
		$last_modified_time = date('Y-m-d H:i:s', filemtime($file));
		if(strtotime(date('Y-m-d H:i:s')) - strtotime($last_modified_time) < MAX_CACHE_AGE){
			header("Content-Type: text/css");
			echo file_get_contents($file);
			exit();
		}
	}
	
	dump('css', 'text/css'); exit();
}
if (preg_match("/\/app.js/",$_SERVER['REQUEST_URI'])) {
	
	$cache_dir = BASE . '/../cache/';
	$file = $cache_dir . 'app.js';
	if (is_file($file) && !DEV) {
		$last_modified_time = date('Y-m-d H:i:s', filemtime($file));
		if(strtotime(date('Y-m-d H:i:s')) - strtotime($last_modified_time) < MAX_CACHE_AGE){
			header("Content-Type: text/javascript; charset=utf-8");
			echo file_get_contents($file);
			exit();
		}
	}
	
	dump('js', 'text/javascript'); exit();
}

function flushTerrificCache(){
	// Remove cache
	$cache = glob(dirname(__FILE__) . '/../cache/*');
	foreach ($cache as $entry) {
		@unlink($entry);
	}
}

?>