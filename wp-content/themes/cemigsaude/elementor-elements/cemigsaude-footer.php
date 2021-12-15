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
            'section_footer_left' => [
                'label' => 'Rodapé esquerdo',
                'items' => [
                    'text' => [
                        'label' => 'Texto',
                        'type' => \Elementor\Controls_Manager::WYSIWYG,
                        'default' => 'Hello world',
                    ],
                    'text_color' => [
                        'label' => 'Cor do texto',
                        'type' => \Elementor\Controls_Manager::COLOR,
                        'default' => '#444444',
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
                    'texts_right_title_color' => [
                        'label' => 'Cor dos títulos',
                        'type' => \Elementor\Controls_Manager::COLOR,
                        'default' => '#444444',
                    ],
                    'texts_right_text_color' => [
                        'label' => 'Cor dos textos',
                        'type' => \Elementor\Controls_Manager::COLOR,
                        'default' => '#666666',
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
    <div class="container p-0">
        <div class="row g-0">
            <div class="col-12 col-md-8">
                <div class="cemigsaude-footer-text mb-5">
                    <?php echo $data->text; ?>
                </div>

                <div class="d-flex">
                    <?php if (is_array($data->actions)): foreach($data->actions as $act): ?>
                    <div class="flex-grow-1 pe-2">
                        <a <?php echo $this->render_link($act->url); ?> class="btn btn-outline-primary w-100">
                            <?php echo $act->label; ?>
                        </a>
                    </div>
                    <?php endforeach; endif; ?>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <?php if (is_array($data->texts_right)): foreach($data->texts_right as $text): ?>
                <div class="mb-4">
                    <div class="mb-2" style="color:<?php echo $data->texts_right_title_color; ?>; font-weight:bold;"><?php echo $text->label; ?></div>
                    <div style="color:<?php echo $data->texts_right_text_color; ?>;"><?php echo $text->text; ?></div>
                </div>
                <?php endforeach; endif; ?>
            </div>
        </div>
    </div>
</section>
<?php
    }

});