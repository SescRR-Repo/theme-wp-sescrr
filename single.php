<?php
/**
 * Template para posts
 */

get_header(); 
?>

<main class="site-main">
    <div class="container">
        <?php while ( have_posts() ) : the_post(); ?>
            <article>
                <h1><?php the_title(); ?></h1>
                <div class="post-meta">
                    <p>Publicado em <?php the_date(); ?></p>
                </div>
                <div><?php the_content(); ?></div>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
