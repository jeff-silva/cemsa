<?php

$manager->register_widget_type(new class extends \ElementorThemeBase {
    
    public function get_name() { return 'cemigsaude-cadastro-cta'; }
    public function get_title() { return 'Cemig Saúde: Cadastro CTA'; }
    public function get_icon() { return 'eicon-editor-code'; }
    public function get_categories() { return [ 'general' ]; }

    public function regsiter_controls_data() {
        return [
            'section_test' => [
                'label' => 'Teste',
                'items' => [
                    'test_text' => [
                        'label' => 'Texto de teste',
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => '',
                    ],
                ],
            ],
        ];
    }


    public function render_html($data) {
?>
cemigsaude-posts
<?php
    }

});