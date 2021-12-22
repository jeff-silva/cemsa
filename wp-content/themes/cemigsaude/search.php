<?php get_header(); global $wp_query; ?>

<div class="container">
    <div class="mb-4">
        Resultados de busca para <q><?php echo request_input('s'); ?></q>
    </div>

    <div class="row">
        <?php if (empty($wp_query->posts)): ?>
        <div class="col-12 text-center py-5 bg-light">
            Nenhum resultado encontrado
        </div>
        <?php endif; ?>

        <?php foreach($wp_query->posts as $post): ?>
        <div class="col-12 col-md-3">
            <div class="bg-light mb-3">
                <div class="p-2 fw-bold">
                    <?php echo $post->post_title; ?>
                </div>

                <?php if ($excerpt = get_the_excerpt($post)): ?>
                <div class="p-2"><?php echo $excerpt; ?></div>
                <?php endif; ?>

                <a href="<?php echo get_the_permalink($post); ?>" class="btn btn-primary w-100 rounded-0">
                    Leia mais
                </a>
            </div>
        </div>    
        <?php endforeach; ?>
    </div>
</div>

<?php get_footer(); ?>