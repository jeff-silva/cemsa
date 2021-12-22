<?php

add_action('elementor/widgets/widgets_registered', function($manager) {
    class ElementorThemeBase extends \Elementor\Widget_Base {
        public function get_name() { return 'elementor-theme-base'; }
        public function get_title() { return 'Elementor Theme Base'; }
        public function get_icon() { return 'eicon-editor-code'; }
        public function get_categories() { return [ 'general' ]; }
        public function get_script_depends() { return $render_scripts; }
        public function get_style_depends() { return $render_styles; }

        public $render_scripts = [];
        public $render_styles = [];

        public function __construct($data=[], $args=null) {
            parent::__construct($data, $args);

            foreach($this->render_scripts() as $name => $file) {
                $this->render_scripts[] = $name;
                wp_register_script($name, $file);
            }

            foreach($this->render_styles() as $name => $file) {
                $this->render_styles[] = $name;
                wp_register_style($name, $file);
            }
        }

        protected function _register_controls() {
            foreach($this->register_controls_data() as $section_id=>$section) {
                $section = array_merge([
                    'label' => '',
                    'items' => [],
                ], $section);
    
                $this->start_controls_section($section_id, $section);
    
                foreach($section['items'] as $field_id=>$field) {
                    if (is_callable($field)) {
                        call_user_func($field, $this);
                        continue;
                    }

                    $field = array_merge([
                        'label' => '',
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => false,
                        'items' => [],
                    ], $field);
    
                    if ($field['type']==\Elementor\Controls_Manager::REPEATER) {
                        $repeater = new \Elementor\Repeater();
                        foreach($field['items'] as $ffield_id=>$ffield) {
                            $repeater->add_control($ffield_id, $ffield);
                        }
                        $field['fields'] = $repeater->get_controls();
                        $field['prevent_empty'] = false;
                        $this->add_control($field_id, $field);
                        continue;
                    }
    
                    $this->add_control($field_id, $field);
                }
    
                $this->end_controls_section();
            }
        }

        protected function render() {
            $element_name = $this->get_name();
            $element_id = uniqid("{$element_name}-");
            $data = $this->get_settings_data();
            $data->is_edit_mode = \Elementor\Plugin::$instance->editor->is_edit_mode();
            // $data->is_preview_mode = \Elementor\Plugin::$instance->editor->is_preview_mode();
            $data->section_class = ltrim($this->get_unique_selector(), '.');

            $_callback = function() use($element_name, $element_id, $data) {
                ob_start();
                echo "\n<!-- {$element_name} start -->\n";
                // echo "<style>\n". css_process($this->render_style($data)) ."</style>\n";
                echo "<div class=\"{$element_name} {$element_id}\" id=\"{$element_id}\">\n";
                $this->render_html($data);
                echo "</div>";
                echo "\n<!-- {$element_name} end -->\n\n";
                $content = ob_get_clean();
    
                $content = str_replace(':element_id', "#{$element_id}", $content);
                $content = str_replace(':element_class', ".{$element_id}", $content);
                $content = str_replace(':section_class', ".{$data->section_class}", $content);
                
                // $content = preg_replace_callback('/(\<style*+\>)(.*?)(\<\/style\>)/s', function($all) {
                //     return $all[1] . css_process($all[2]) . $all[3];
                // }, $content);

                return $content;
            };

            if ($theme_cache = get_option('theme_cache')) {
                $data_cache_key = [$element_name, $_GET, $_POST];
                $i = 0;
                foreach($data as $key => $value) {
                    $i++;
                    if ($i>=10) break;
                    if ($key[0]=='_') continue;
                    $data_cache_key[] = $value;
                }
    
                echo data_cache($data_cache_key, $theme_cache, $_callback); return;
            }
            
            echo call_user_func($_callback);
        }


        public function register_controls_data() {
            return [];
        }


        public function get_settings_data() {
            $global = (new \Elementor\Core\Kits\Manager)->get_current_settings();
            $data = $this->get_settings_for_display();

            if (!function_exists('_elementor_recursive_global_value')) {
                function _elementor_recursive_global_value($data, $global, $level=0) {
                    if (is_array($data) AND isset($data['__globals__']) AND is_array($data['__globals__'])) {
                        foreach($data['__globals__'] as $gkey => $gval) {
                            list($gtype, $gparam, $gname) = preg_split('/\?|\=/', $gval);
                            if ('globals/colors'==$gtype) {
                                foreach($global['system_colors'] as $c) {
                                    if ($c['_id']==$gname) {
                                        $data[$gkey] = $c['color'];
                                    }
                                }
                                foreach($global['custom_colors'] as $c) {
                                    if ($c['_id']==$gname) {
                                        $data[$gkey] = $c['color'];
                                    }
                                }
                            }
                        }
                    }

                    if (is_array($data)) {
                        foreach($data as $key => $val) {
                            $data[$key] = _elementor_recursive_global_value($data[$key], $global, $level+1);
                        }
                    }
                    
                    return $data;
                }
            }

            $data = _elementor_recursive_global_value($data, $global, $level);
            return json_decode(json_encode($data));
        }

        public function render_scripts() {
            return [];
        }

        public function render_styles() {
            return [];
        }

        public function render_html($data) {
            // 
        }

        public function render_style($data) {
            // 
        }

        public function get_menus() {
            $menus = [];

            foreach(get_registered_nav_menus() as $location => $description) {
                $menus[ $location ] = $description;
            }

            return $menus;
        }

        public function render_menu($menu) {
            if (!$menu) return;

            return wp_nav_menu([
                'menu' => $menu,
                'container' => false,
                'items_wrap' => '<ul>%3$s</ul>',
                'walker' => (new class extends Walker_Nav_Menu {
                    // function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0 ) {
                    //     $item->url = $item->url? $item->url: get_the_permalink($item);
                    //     $item->title = $item->title? $item->title: $item->post_title;
                    //     $output .= "<li><a href='{$item->url}'>{$item->title}</a>";
                    // }
                }),
            ]);
        }

        public function link_attrs($link) {
            return implode(' ', array_filter([
                "href=\"{$link->url}\"",
                ($link->is_external? 'target="_blank"': null),
                ($link->nofollow? 'rel="nofollow"': null),
            ]));
        }
    }
    
    foreach(glob(__DIR__ .'/../elementor-elements/*.php') as $include) {
        include $include;
    }
});

add_filter('nav_menu_item_id', function($id, $item, $args) { return ''; }, 10, 3);
add_filter('nav_menu_css_class', function($classes, $item, $args) { return []; }, 10, 3);

add_action('wp_head', function() {
    $style_lines = [];
    $style_lines[] = '.form-control {outline:none!important; box-shadow:none!important;}';

    foreach(elementor_colors() as $name => $info) {
        $style_lines[] = ".bg-{$name} {background-color: {$info->color};}";
        $style_lines[] = ".border-{$name} {border-color:{$info->color}!important;}";
        $style_lines[] = ".text-{$name} {color: {$info->color};}";
        $style_lines[] = ".btn-{$name} {background:{$info->color}; border-color:{$info->color}!important;}";
        $style_lines[] = ".btn-{$name}:hover {background:{$info->color}; border-color:{$info->color}!important;}";
        $style_lines[] = ".btn-outline-{$name} {border-color:{$info->color}!important; color:{$info->color};}";
        $style_lines[] = ".btn-outline-{$name}:hover {background: {$info->color};}";
        $style_lines[] = ".placeholder-{$name}:placeholder {color: {$info->color};}";
    }
    
    echo '<style>'. css_process($style_lines, ['minify' => true]) .'</style>';
});