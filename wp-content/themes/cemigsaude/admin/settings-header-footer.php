<?php

/* Add submenu | /wp-admin/options-general.php?page=wp-translations-search */
add_action('admin_menu', function() {
	add_submenu_page('themes.php', 'Cabeçalho/Rodapé', 'Cabeçalho/Rodapé', 'manage_options', 'header-footer', function() {

        if (isset($_POST['save'])) {
            update_option('theme_header', $_POST['theme_header']);
            update_option('theme_footer', $_POST['theme_footer']);
            echo '<div class="alert alert-success pt-3">Configurações salvas</div>';
        }

        $modelos = array_filter(get_posts('post_type=elementor_library'), function($model) {
            return $model->post_name != 'kit-padrao';
        });

        $settings = (object) [
            'theme_header' => get_option('theme_header'),
            'theme_footer' => get_option('theme_footer'),
        ];

        ?>
        <form method="post" action="">
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

            <div class="mt-3">
                <a href="https://xd.adobe.com/view/359562ed-4b96-44fa-b32d-35459d17f809-60c6/" class="btn" target="_blank">Tema</a>

                <button type="submit" class="btn btn-primary" name="save">
                    Salvar
                </button>
            </div>
        </form>
        <?php
    });
});
