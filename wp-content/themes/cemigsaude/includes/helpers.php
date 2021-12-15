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
    $global = (new \Elementor\Core\Kits\Manager)->get_current_settings();

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