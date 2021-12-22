<?php

$manager->register_widget_type(new class extends \ElementorThemeBase {
    
    public function get_name() { return 'cemigsaude-footer'; }
    public function get_title() { return 'Cemig Saúde: Rodapé'; }
    public function get_icon() { return 'eicon-editor-code'; }
    public function get_categories() { return [ 'general' ]; }
    public function get_script_depends() { return []; }
    public function get_style_depends() { return []; }

    public function register_controls_data() {
        return [
            'section_style' => [
                'label' => 'Estilo',
                'items' => [
                    'title_color' => [
                        'label' => 'Cor dos títulos',
                        'type' => \Elementor\Controls_Manager::COLOR,
                        'default' => '#444444',
                    ],
                    function($that) {
                        $that->add_group_control(\Elementor\Group_Control_Typography::get_type(), [
                            'name' => 'title_typography',
                            'label' => 'Tipografia dos títulos',
                            'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                            'selector' => '{{WRAPPER}} .cemigsaude-footer-title, {{WRAPPER}} .cemigsaude-footer-title *',
                        ]);
                    },
                    'text_color' => [
                        'label' => 'Cor dos textos',
                        'type' => \Elementor\Controls_Manager::COLOR,
                        'default' => '#666666',
                    ],
                    function($that) {
                        $that->add_group_control(\Elementor\Group_Control_Typography::get_type(), [
                            'name' => 'text_typography',
                            'label' => 'Tipografia dos textos',
                            'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                            'selector' => '{{WRAPPER}} .cemigsaude-footer-text, {{WRAPPER}} .cemigsaude-footer-text *',
                        ]);
                    },
                ],
            ],

            'section_footer_left' => [
                'label' => 'Rodapé esquerdo',
                'items' => [
                    'texts_left' => [
                        'label' => 'Textos',
                        'type' => \Elementor\Controls_Manager::REPEATER,
                        'title_field' => '{{{ label }}}',
                        'default' => [],
                        'items' => [
                            'label' => [
                                'label' => 'Título',
                                'type' => \Elementor\Controls_Manager::TEXT,
                                'label_block' => true,
                                'default' => 'Título',
                            ],
                            'text' => [
                                'label' => '',
                                'type' => \Elementor\Controls_Manager::WYSIWYG,
                                'default' => 'Conteúdo HTML',
                            ],
                        ],
                    ],
                    'actions' => [
                        'label' => 'Ações',
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
                        ],
                    ],
                ],
            ],

            'section_footer_right' => [
                'label' => 'Rodapé direito',
                'items' => [
                    'ans' => [
                        'label' => 'ANS',
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => 'ANS - Nº 000000',
                    ],
                    'texts_right' => [
                        'label' => 'Textos',
                        'type' => \Elementor\Controls_Manager::REPEATER,
                        'title_field' => '{{{ label }}}',
                        'default' => [],
                        'items' => [
                            'label' => [
                                'label' => 'Título',
                                'type' => \Elementor\Controls_Manager::TEXT,
                                'label_block' => true,
                                'default' => 'Título',
                            ],
                            'text' => [
                                'label' => '',
                                'type' => \Elementor\Controls_Manager::WYSIWYG,
                                'default' => 'Conteúdo HTML',
                            ],
                        ],
                    ],
                    'socials' => [
                        'label' => 'Redes sociais',
                        'type' => \Elementor\Controls_Manager::REPEATER,
                        'title_field' => '{{{ label }}}',
                        'default' => [],
                        'items' => [
                            'label' => [
                                'label' => 'Título',
                                'type' => \Elementor\Controls_Manager::TEXT,
                                'label_block' => true,
                                'default' => 'Título',
                            ],
                            'url' => [
                                'label' => '',
                                'type' => \Elementor\Controls_Manager::URL,
                                'default' => ['url' => ''],
                            ],
                            'icon' => [
                                'label' => '',
                                'type' => \Elementor\Controls_Manager::ICONS,
                                'default' => ['value' => ''],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    
    public function render_style($data) {
        $style[] = ":element_class {color:red;}";
        return $style;
    }


    public function render_html($data) {
?>
<style>
:element_class .cemigsaude-footer-text, :element_class .cemigsaude-footer-text * {color:<?php echo $data->text_color; ?>;}
</style>
<section>
    <div class="row">

        <!-- Coluna esquerda -->
        <div class="col-12 col-md-8">
            <?php if (is_array($data->texts_left)): foreach($data->texts_left as $text): ?>
            <div class="mb-4">
                <div class="cemigsaude-footer-title mb-2" style="color:<?php echo $data->title_color; ?>; font-weight:bold;"><?php echo $text->label; ?></div>
                <div class="cemigsaude-footer-text" style="color:<?php echo $data->text_color; ?>;"><?php echo $text->text; ?></div>
            </div>
            <?php endforeach; endif; ?>

            <div class="d-flex">
                <?php if (is_array($data->actions)): foreach($data->actions as $act): ?>
                <div class="flex-grow-1 pe-2">
                    <a <?php echo $this->link_attrs($act->url); ?> class="btn btn-outline-primary w-100 cemsa-rounded-3">
                        <?php echo $act->label; ?>
                    </a>
                </div>
                <?php endforeach; endif; ?>
            </div>
        </div>

        <!-- Coluna direita -->
        <div class="col-12 col-md-4">
            <div class="text-end mb-3">
                <div class="d-inline-block p-2 text-white border border-white">
                    <?php echo $data->ans; ?>
                </div>
            </div>

            <?php if (is_array($data->texts_right)): foreach($data->texts_right as $text): ?>
            <div class="mb-4">
                <div class="cemigsaude-footer-title mb-2" style="color:<?php echo $data->title_color; ?>; font-weight:bold;"><?php echo $text->label; ?></div>
                <div class="cemigsaude-footer-text" style="color:<?php echo $data->text_color; ?>;"><?php echo $text->text; ?></div>
            </div>
            <?php endforeach; endif; ?>
            
            <div class="d-flex">
                <?php if (is_array($data->socials)): foreach($data->socials as $social): ?>
                <div>
                    <a <?php echo $this->link_attrs($social->url); ?> class="btn text-white border border-white me-2" title="<?php echo $social->label; ?>" style="width:35px; height:35px; border-radius:50%; padding:0; display:flex; align-items:center; justify-content:center;">
                        <i class="<?php echo $social->icon->value; ?>"></i>
                    </a>
                </div>
                <?php endforeach; endif; ?>
            </div>
        </div>
    </div>
</section>
<?php
    }

});