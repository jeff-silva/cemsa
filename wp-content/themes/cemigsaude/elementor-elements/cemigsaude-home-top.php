<?php

$manager->register_widget_type(new class extends \ElementorThemeBase {
    
    public function get_name() { return 'cemigsaude-home-top'; }
    public function get_title() { return 'Cemig Saúde: Topo home'; }
    public function get_icon() { return 'eicon-editor-code'; }
    public function get_categories() { return [ 'general' ]; }
    public function get_script_depends() { return []; }
    public function get_style_depends() { return []; }

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
cemigsaude-home-top
<?php
    }

});