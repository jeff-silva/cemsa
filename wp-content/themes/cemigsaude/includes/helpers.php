<?php

function css_process($style, $params=[]) {
    $params = array_merge([
        'minify' => false,
        'replaces' => [],
    ], $params);


    if (is_array($style)) {
        $style = implode('', $style);
    }

    foreach($params['replaces'] as $find => $replace) {
        $style = str_replace($find, $replace, $style);
    }

    $style = preg_replace_callback('/}(.+?)\{/', function($all) use($params) {
        if (strpos($all[1], '::placeholder') !== false) {
            $all[1] = trim($all[1]);
            $style = [ $all[1] ];
            foreach(['::-webkit-input-placeholder', '::-moz-placeholder', ':-ms-input-placeholder', ':-moz-placeholder'] as $replace) {
                $style[] = str_replace(':placeholder', $replace, $all[1]);
            }
            $glue = $params['minify']? ',': ",\n";
            return '} '. implode($glue, $style) .' {';
        }

        return $all[0];
    }, $style);

    if (!$params['minify']) {
        $style = preg_replace('/\}\s*/', "}\n", $style);
    }

    return $style;
}


function elementor_colors() {
    $global = data_cache('elementor_get_current_settings', 60*60, function() {
        return (new \Elementor\Core\Kits\Manager)->get_current_settings();
    });

    $colors = [];
    foreach($global['system_colors'] as $c) {
        $colors[ $c['_id'] ] = (object) [
            'title' => $c['title'],
            'color' => $c['color'],
            'inverse' => null,
        ];
    }
    foreach($global['custom_colors'] as $c) {
        $colors[ $c['title'] ] = (object) [
            'title' => $c['title'],
            'color' => $c['color'],
            'inverse' => null,
        ];
    }

    return $colors;
}

function data_cache($key, $seconds, $callback, $ignore_cache=false) {
    if ($ignore_cache) return call_user_func($callback);
    if (is_array($key)) { $key = json_encode($key); }
    $key = md5($key);
    // delete_transient($key);
    $value = get_transient($key);

    if (false === $value) {
        $value = call_user_func($callback);
        set_transient($key, $value, $seconds);
    }

    return $value;
}

function request_input($name, $default=null) {
    if (isset($_GET[ $name ])) return $_GET[ $name ];
    if (isset($_POST[ $name ])) return $_POST[ $name ];
    return $default;
}