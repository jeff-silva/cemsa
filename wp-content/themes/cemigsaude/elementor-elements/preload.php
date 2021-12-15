<?php

$manager->register_widget_type(new class extends \ElementorThemeBase {
    
    public function get_name() { return 'preload'; }
    public function get_title() { return 'Preloader'; }
    public function get_icon() { return 'eicon-editor-code'; }
    public function get_categories() { return [ 'general' ]; }
    public function get_script_depends() { return []; }
    public function get_style_depends() { return []; }

    public function register_controls_data() {
        return [
            'section_test' => [
                'label' => 'Rodapé lado 1',
                'items' => [
                    'preview' => [
                        'label' => 'Conteúdo',
                        'type' => \Elementor\Controls_Manager::SWITCHER,
                        'default' => '',
                    ],

                    'content' => [
                        'label' => 'Conteúdo',
                        'type' => \Elementor\Controls_Manager::CODE,
                        'default' => 'Carregando...',
                    ],

                    'image' => [
                        'label' => 'Imagem',
                        'type' => \Elementor\Controls_Manager::MEDIA,
                        'default' => ['url' => ''],
                    ],
                ],
            ],
        ];
    }

    public function render_html($data) {
        if ($data->is_edit_mode AND !$data->preview) return;
?>
<div class="preload-overlay" style="position:fixed; top:0; left:0; width:100%; height:100%; background:#fff; z-index:9; display:flex; align-items:center; justify-content:center; animation-duration:200ms;">
    <div>
        <?php if ($data->image AND $data->image->url): ?>
            <img src="<?php echo $data->image->url; ?>" alt="">
        <?php endif; ?>

        <?php echo $data->content; ?>
    </div>
</div>

<script>
(() => {
    let target = document.querySelector(':element_id .preload-overlay');
    let animateIn = 'animate__fadeIn';
    let animateOut = 'animate__fadeOut';
    
    target.addEventListener('animationend', ev => {
        if (!target.classList.contains(animateOut)) return;
        target.style.zIndex = '0';
    });

    document.addEventListener("DOMContentLoaded", ev => {
        setTimeout(() => {
            target.classList.add('animate__animated', animateOut);
        }, 500);
    });

    window.addEventListener('beforeunload', function(event) {
        target.style.zIndex = '9';
        target.classList.remove(animateOut);
        target.classList.add(animateIn);
    });
})();
</script>
<?php
    }

});