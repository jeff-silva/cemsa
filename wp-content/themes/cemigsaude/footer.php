<?php wp_footer(); ?>
<?php if ($model_id = get_option('theme_footer')) {
    echo \Elementor\Plugin::$instance->frontend->get_builder_content($model_id, true);
} ?>

<!-- Tradutor de Libras -->
<!-- <div vw class="enabled"><div vw-access-button class="active"></div><div vw-plugin-wrapper><div class="vw-plugin-top-wrapper"></div></div></div>
<script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
<script>new window.VLibras.Widget('https://vlibras.gov.br/app');</script> -->

</body></html>