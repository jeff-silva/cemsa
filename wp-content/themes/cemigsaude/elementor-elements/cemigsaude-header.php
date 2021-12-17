<?php

$manager->register_widget_type(new class extends \ElementorThemeBase {
    
    public function get_name() { return 'cemigsaude-header'; }
    public function get_title() { return 'Cemig Saúde: Cabeçalho'; }
    public function get_icon() { return 'eicon-editor-code'; }
    public function get_categories() { return [ 'general' ]; }
    public function get_script_depends() { return []; }
    public function get_style_depends() { return []; }

    public function register_controls_data() {
        return [
            'section_logo' => [
                'label' => 'Logo',
                'items' => [
                    'logo' => [
                        'label' => 'Logo',
                        'type' => \Elementor\Controls_Manager::MEDIA,
                        'default' => ['url'=>'https://templates.envytheme.com/ketan/default/assets/img/who-we-are/who-we-are.jpg'],
                    ],
                ],
            ],

            'section_actions' => [
                'label' => 'Ações',
                'items' => [
                    'actions' => [
                        'label' => '',
                        'type' => \Elementor\Controls_Manager::REPEATER,
                        'title_field' => '{{{ label }}}',
                        'default' => [],
                        'items' => [
                            'label' => [
                                'label' => 'Título',
                                'type' => \Elementor\Controls_Manager::TEXT,
                                'default' => 'Título',
                            ],
                            'url' => [
                                'label' => 'URL',
                                'type' => \Elementor\Controls_Manager::URL,
                                'default' => ['url'=>''],
                            ],
                            'color' => [
                                'label' => 'Cor',
                                'type' => \Elementor\Controls_Manager::COLOR,
                                'default' => '#ffdddd',
                            ],
                            'color_hover' => [
                                'label' => 'Cor hover',
                                'type' => \Elementor\Controls_Manager::COLOR,
                                'default' => '#444444',
                            ],
                        ],
                    ],
                    'search_placeholder' => [
                        'label' => 'Placeholder busca',
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => 'Busca',
                    ],
                    'search_color' => [
                        'label' => 'Cor da busca',
                        'type' => \Elementor\Controls_Manager::COLOR,
                        'default' => '#ffdddd',
                    ],
                ],
            ],

            'section_menu' => [
                'label' => 'Menu',
                'items' => [
                    'menu' => [
                        'label' => 'Menu',
                        'type' => \Elementor\Controls_Manager::SELECT2,
                        'options' => $this->get_menus(),
                        'default' => '',
                    ],
                    function($that) {
                        $that->add_group_control(\Elementor\Group_Control_Typography::get_type(), [
                            'name' => 'content_typography',
                            'label' => 'Tipografia do menu',
                            'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                            'selector' => '{{WRAPPER}} .cemigsaude-header-nav a',
                        ]);
                    },
                    'menu_note' => [
                        'label' => '',
                        'type' => \Elementor\Controls_Manager::RAW_HTML,
                        'raw' => 'Menu nível base',
                    ],
                    'menu_font_color' => [
                        'label' => 'Cor da fonte do menu',
                        'type' => \Elementor\Controls_Manager::COLOR,
                        'default' => '#444444',
                    ],
                    'menu_font_color_hover' => [
                        'label' => 'Cor da fonte do menu ativo/hover',
                        'type' => \Elementor\Controls_Manager::COLOR,
                        'default' => '#222222',
                    ],
                    'menu_dropdown_note' => [
                        'label' => '',
                        'type' => \Elementor\Controls_Manager::RAW_HTML,
                        'raw' => 'Dropdown',
                    ],
                    'menu_dropdown_bg_color' => [
                        'label' => 'Cor do dropdown',
                        'type' => \Elementor\Controls_Manager::COLOR,
                        'default' => '#ffffff',
                    ],
                    'menu_dropdown_font_color' => [
                        'label' => 'Cor da fonte em dropdown',
                        'type' => \Elementor\Controls_Manager::COLOR,
                        'default' => '#444444',
                    ],
                    'menu_dropdown_font_color_hover' => [
                        'label' => 'Cor da fonte em dropdown',
                        'type' => \Elementor\Controls_Manager::COLOR,
                        'default' => '#AAAAAA',
                    ],
                    'menu_dropdown_bg_color_hover' => [
                        'label' => 'Cor da fonte em dropdown',
                        'type' => \Elementor\Controls_Manager::COLOR,
                        'default' => '#EEEEEE',
                    ],
                ],
            ],
        ];
    }


    public function render_html($data) {
?>
<style>
.cemigsaude-header-fixed {position:fixed; top:0; left:0; width:100%; z-index:9;}

/* Search */
:element_class .cemigsaude-header-search-input {border-radius:10px; border-color:<?php echo $data->search_color; ?>;}
:element_class .cemigsaude-header-search-input input {color:<?php echo $data->search_color; ?>;}
:element_class .cemigsaude-header-search-input input::placeholder {color:<?php echo $data->search_color; ?>!important;}

/* Menu */
:element_class .cemigsaude-header-nav {}
:element_class .cemigsaude-header-nav ul {list-style-type:none; padding:0; margin:0; transition: all 300ms ease;}
:element_class .cemigsaude-header-nav > ul {display:flex;}
:element_class .cemigsaude-header-nav > ul > li {position:relative;}
:element_class .cemigsaude-header-nav > ul > li > a {display:block; padding:5px 7px; color:<?php echo $data->menu_font_color; ?>;}
:element_class .cemigsaude-header-nav > ul > li > a:hover {color:<?php echo $data->menu_font_color_hover; ?>;}
:element_class .cemigsaude-header-nav > ul > li > ul {position:absolute; top:100%; left:0; z-index:2; background:<?php echo $data->menu_dropdown_bg_color; ?>; width:200px; visibility:hidden; opacity:0;}
:element_class .cemigsaude-header-nav > ul > li:hover > ul {visibility:visible; opacity:1;}
:element_class .cemigsaude-header-nav > ul > li > ul > li {}
:element_class .cemigsaude-header-nav > ul > li > ul > li > a {display:block; padding:10px 10px; color:<?php echo $data->menu_dropdown_font_color; ?>;}
:element_class .cemigsaude-header-nav > ul > li > ul > li > a:hover {color:<?php echo $data->menu_dropdown_font_color_hover; ?>; background:<?php echo $data->menu_dropdown_bg_color_hover; ?>;}

/* Actions */
<?php if (is_array($data->actions)): foreach($data->actions as $act): ?>
:element_class .cemigsaude-header-action-<?php echo $act->_id; ?> .btn {border-color:<?php echo $act->color; ?>; color:<?php echo $act->color; ?>;}
<?php if ($act->color_hover): ?>
:element_class .cemigsaude-header-action-<?php echo $act->_id; ?> .btn:hover {color:<?php echo $act->color_hover; ?>;}
<?php endif; ?>
<?php endforeach; endif; ?>
</style>

<section>
    <div class="row g-0 align-items-center">
        <div class="col-12 col-md-2 py-4 py-md-0 text-center">
            <a href="<?php echo site_url(); ?>">
                <img src="<?php echo $data->logo->url; ?>" alt="" style="width:100%; max-width:300px;">
            </a>
        </div>
        <div class="col-12 col-md-10 py-3">
            <div class="d-flex align-items-center justify-content-end mb-3">
                <?php if (is_array($data->actions)): foreach($data->actions as $act): ?>
                <div class="me-2 cemigsaude-header-action-<?php echo $act->_id; ?>">
                    <a href="" class="btn btn-outline-primary" style="border-radius:10px; ;"><?php echo $act->label; ?></a>
                </div>
                <?php endforeach; endif; ?>
                <div>
                    <form method="get" class="input-group form-control p-0 cemigsaude-header-search-input">
                        <input type="search" name="s" value="<?php echo request_input('s'); ?>" class="form-control border-0 bg-transparent" placeholder="<?php echo $data->search_placeholder; ?>">
                        <div class="input-group-btn">
                            <button type="submit" class="btn border-0 bg-transparent">
                                <i class="fas fa-search" style="color:<?php echo $data->search_color; ?>;"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Menu -->
            <div class="d-flex justify-content-end">
                <nav class="cemigsaude-header-nav">
                    <?php echo $this->render_menu($data->menu); ?>
                </nav>
            </div>
        </div>
    </div>
</section>

<script>
(ev => {
    let parent = document.querySelector(':section_class').closest('.elementor-section');
    parent.style.position = "fixed";
    parent.style.top = '0';
    parent.style.left = '0';
    parent.style.width = '100%';
    parent.style.zIndex = '99';

    let spacer = Object.assign(document.createElement('div'), {
        style: {background:"red"},
    });
    parent.parentNode.insertBefore(spacer, parent);
    
    ['load', 'resize'].forEach(evt => {
        window.addEventListener(evt, ev => {
            spacer.style.height = parent.offsetHeight+'px';
            console.log(this, spacer, parent.offsetHeight);
        });
    });
})();

// window.addEventListener('scroll', ev => {
//     let target = document.querySelector(':section_class').closest('.elementor-section');
//     if (window.scrollY>=200) { return target.classList.add('cemigsaude-header-fixed'); }
//     target.classList.remove('cemigsaude-header-fixed');
// });
</script>
<?php
    }

});