<?php

/* Add submenu | /wp-admin/options-general.php?page=wp-translations-search */
add_action('admin_menu', function() {
	add_submenu_page('themes.php', 'Cabeçalho/Rodapé', 'Cabeçalho/Rodapé', 'manage_options', 'header-footer', function() {

        if (isset($_POST['save'])) {
            unset($_POST['save']);
            foreach($_POST as $key => $value) {
                update_option($key, $value);
            }
            echo '<div class="alert alert-success pt-3">Configurações salvas</div>';
        }

        $modelos = array_filter(get_posts('post_type=elementor_library'), function($model) {
            return $model->post_name != 'kit-padrao';
        });

        $settings = (object) [
            'theme_header' => get_option('theme_header'),
            'theme_footer' => get_option('theme_footer'),
            'theme_cache' => get_option('theme_cache'),
        ];

        ?>
        <div id="app">
            <form method="post" action="" style="max-width:600px;">
                <div class="mb-3">
                    <label class="form-label">Cabeçalho</label>
                    <div class="input-group">
                        <select name="theme_header" class="form-control">
                            <option value="">Selecione</option>
                            <?php foreach($modelos as $modelo): ?>
                            <option value="<?php echo $modelo->ID; ?>" <?php if ($modelo->ID==$settings->theme_header) echo 'selected'; ?>><?php echo $modelo->post_title; ?></option>
                            <?php endforeach; ?>
                        </select>

                        <?php if ($settings->theme_header): ?>
                        <div class="input-group-btn">
                            <a href="post.php?post=<?php echo $settings->theme_header; ?>&action=elementor" class="btn btn-primary" target="_blank">
                                Editar
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Rodapé</label>
                    <div class="input-group">
                        <select name="theme_footer" class="form-control">
                            <option value="">Selecione</option>
                            <?php foreach($modelos as $modelo): ?>
                            <option value="<?php echo $modelo->ID; ?>" <?php if ($modelo->ID==$settings->theme_footer) echo 'selected'; ?>><?php echo $modelo->post_title; ?></option>
                            <?php endforeach; ?>
                        </select>

                        <?php if ($settings->theme_footer): ?>
                        <div class="input-group-btn">
                            <a href="post.php?post=<?php echo $settings->theme_footer; ?>&action=elementor" class="btn btn-primary" target="_blank">
                                Editar
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-label">Cache</div>
                    <div class="input-group">
                        <select v-model="settings.theme_cache" class="form-control">
                            <option value="">Sem cache</option>
                            <option :value="60*15">15 minutos</option>
                            <option :value="60*30">30 minutos</option>
                            <option :value="60*60">1 hora</option>
                            <option :value="60*60*3">3 horas</option>
                            <option :value="60*60*6">6 horas</option>
                            <option :value="60*60*12">12 horas</option>
                            <option :value="60*60*24">24 horas</option>
                            <option :value="60*60*24*2">2 dias</option>
                            <option :value="60*60*24*7">7 dias</option>
                            <option :value="60*60*24*15">15 dias</option>
                            <option :value="60*60*24*30">30 dias</option>
                            <option :value="60*60*24*30*6">6 meses</option>
                            <option :value="60*60*24*30*12">1 ano</option>
                        </select>
                        <div class="input-group-text">=</div>
                        <input type="number" name="theme_cache" v-model="settings.theme_cache" class="form-control">
                        <div class="input-group-text">Segundos</div>
                    </div>
                </div>

                <div class="mt-3">
                    <a href="https://xd.adobe.com/view/359562ed-4b96-44fa-b32d-35459d17f809-60c6/" class="btn" target="_blank">Tema</a>

                    <button type="submit" class="btn btn-primary" name="save">
                        Salvar
                    </button>
                </div>
            </form>
        </div>

        <script>
        new Vue({
            el: "#app",
            data() {
                return {
                    settings: <?php echo json_encode($settings); ?>,
                    modelos: <?php echo json_encode($modelos); ?>,
                };
            },
        });
        </script>
        <?php
    });
});
