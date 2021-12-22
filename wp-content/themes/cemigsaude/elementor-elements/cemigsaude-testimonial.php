<?php

$manager->register_widget_type(new class extends \ElementorThemeBase {
    
    public function get_name() { return 'cemigsaude-testimonial'; }
    public function get_title() { return 'Cemig Saúde: Testimonial'; }
    public function get_icon() { return 'eicon-editor-code'; }
    public function get_categories() { return [ 'general' ]; }

    public function render_scripts() {
        return [
            'slick-carousel' => '//unpkg.com/slick-carousel@1.8.1/slick/slick.min.js',
        ];
    }

    public function render_styles() {
        return [
            'slick-carousel' => '//unpkg.com/slick-carousel@1.8.1/slick/slick.css',
        ];
    }

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
Testimonial
<?php
    }

});