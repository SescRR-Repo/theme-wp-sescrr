<?php
/**
 * Funções do tema SESC RR
 * 
 * @package SESC_RR
 * @since 1.0.0
 */

// Prevenir acesso direto
if (!defined('ABSPATH')) {
    exit;
}

// Definir constantes do tema
define('SESC_RR_VERSION', '1.0.0');
define('SESC_RR_THEME_DIR', get_template_directory());
define('SESC_RR_THEME_URI', get_template_directory_uri());

/**
 * Configuração inicial do tema
 */
function sesc_rr_setup() {
    // Tornar o tema disponível para tradução
    load_theme_textdomain('sesc-rr', SESC_RR_THEME_DIR . '/languages');

    // Suporte a recursos do WordPress
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ));
    
    // Suporte a feed links
    add_theme_support('automatic-feed-links');

    // Suporte a logo customizado
    add_theme_support('custom-logo', array(
        'height'      => 80,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array('site-title', 'site-description'),
    ));

    // Suporte a imagens destacadas
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(1200, 600, true);

    // Tamanhos de imagem adicionais
    add_image_size('sesc-thumbnail', 300, 200, true);
    add_image_size('sesc-medium', 600, 400, true);
    add_image_size('sesc-large', 1200, 800, true);

    // Suporte a menus
    register_nav_menus(array(
        'primary' => __('Menu Principal', 'sesc-rr'),
        'footer'  => __('Menu do Rodapé', 'sesc-rr'),
        'social'  => __('Links Sociais', 'sesc-rr'),
    ));

    // Suporte a cores customizadas
    add_theme_support('custom-background', array(
        'default-color' => 'ffffff',
    ));

    // Suporte ao editor de blocos
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-style.css');

    // Remover emoji scripts para performance
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
}
add_action('after_setup_theme', 'sesc_rr_setup');

/**
 * Enqueue scripts e styles
 */
function sesc_rr_scripts() {
    // CSS principal
    wp_enqueue_style(
        'sesc-rr-style', 
        get_stylesheet_uri(), 
        array(), 
        SESC_RR_VERSION
    );

    // CSS do navbar
    wp_enqueue_style(
        'sesc-rr-navbar', 
        SESC_RR_THEME_URI . '/assets/css/navbar.css', 
        array('sesc-rr-style'), 
        SESC_RR_VERSION
    );

    // CSS responsivo
    wp_enqueue_style(
        'sesc-rr-responsive', 
        SESC_RR_THEME_URI . '/assets/css/responsive.css', 
        array('sesc-rr-navbar'), 
        SESC_RR_VERSION
    );

    // JavaScript principal
    wp_enqueue_script(
        'sesc-rr-navbar', 
        SESC_RR_THEME_URI . '/assets/js/navbar.js', 
        array('jquery'), 
        SESC_RR_VERSION, 
        true
    );

    // JavaScript principal do tema
    wp_enqueue_script(
        'sesc-rr-main', 
        SESC_RR_THEME_URI . '/assets/js/main.js', 
        array('jquery', 'sesc-rr-navbar'), 
        SESC_RR_VERSION, 
        true
    );

    // Localizar scripts para AJAX
    wp_localize_script('sesc-rr-navbar', 'sescAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('sesc_ajax_nonce'),
        'homeUrl' => home_url('/'),
        'themeUrl' => SESC_RR_THEME_URI,
        'strings' => array(
            'searchPlaceholder' => __('Busque por atividades ou outros conteúdos...', 'sesc-rr'),
            'searchNoResults' => __('Nenhum resultado encontrado.', 'sesc-rr'),
            'searchError' => __('Erro na busca. Tente novamente.', 'sesc-rr'),
            'searchMinChars' => __('Digite pelo menos 2 caracteres para buscar', 'sesc-rr'),
        )
    ));

    // Script para comentários (se necessário)
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'sesc_rr_scripts');

/**
 * Enqueue scripts do admin
 */
function sesc_rr_admin_scripts($hook) {
    if ('appearance_page_theme-options' === $hook) {
        wp_enqueue_script(
            'sesc-rr-admin',
            SESC_RR_THEME_URI . '/assets/js/admin.js',
            array('jquery'),
            SESC_RR_VERSION,
            true
        );
    }
}
add_action('admin_enqueue_scripts', 'sesc_rr_admin_scripts');

/**
 * Configurar áreas de widgets
 */
function sesc_rr_widgets_init() {
    // Sidebar principal
    register_sidebar(array(
        'name'          => __('Sidebar Principal', 'sesc-rr'),
        'id'            => 'sidebar-main',
        'description'   => __('Widgets da sidebar principal', 'sesc-rr'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    // Footer - Coluna 1
    register_sidebar(array(
        'name'          => __('Rodapé - Coluna 1', 'sesc-rr'),
        'id'            => 'footer-1',
        'description'   => __('Primeira coluna do rodapé', 'sesc-rr'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    // Footer - Coluna 2
    register_sidebar(array(
        'name'          => __('Rodapé - Coluna 2', 'sesc-rr'),
        'id'            => 'footer-2',
        'description'   => __('Segunda coluna do rodapé', 'sesc-rr'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    // Footer - Coluna 3
    register_sidebar(array(
        'name'          => __('Rodapé - Coluna 3', 'sesc-rr'),
        'id'            => 'footer-3',
        'description'   => __('Terceira coluna do rodapé', 'sesc-rr'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'sesc_rr_widgets_init');

/**
 * Busca AJAX
 */
function sesc_rr_ajax_search() {
    // Verificar nonce
    check_ajax_referer('sesc_ajax_nonce', 'nonce');
    
    $search_term = sanitize_text_field($_POST['query']);
    
    if (strlen($search_term) < 2) {
        wp_send_json_error(__('Termo de busca muito curto', 'sesc-rr'));
    }
    
    $args = array(
        'post_type' => array('post', 'page'),
        'post_status' => 'publish',
        'posts_per_page' => 8,
        's' => $search_term,
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => '_thumbnail_id',
                'compare' => 'EXISTS'
            ),
            array(
                'key' => '_thumbnail_id',
                'compare' => 'NOT EXISTS'
            )
        )
    );
    
    $search_query = new WP_Query($args);
    $results = array();
    
    if ($search_query->have_posts()) {
        while ($search_query->have_posts()) {
            $search_query->the_post();
            
            $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'sesc-thumbnail');
            $excerpt = get_the_excerpt();
            if (empty($excerpt)) {
                $excerpt = wp_trim_words(get_the_content(), 20, '...');
            }
            
            $results[] = array(
                'title' => get_the_title(),
                'url' => get_permalink(),
                'excerpt' => $excerpt,
                'date' => get_the_date(),
                'thumbnail' => $thumbnail,
                'type' => get_post_type()
            );
        }
        wp_reset_postdata();
    }
    
    wp_send_json_success($results);
}
add_action('wp_ajax_sesc_search', 'sesc_rr_ajax_search');
add_action('wp_ajax_nopriv_sesc_search', 'sesc_rr_ajax_search');

/**
 * Customizer - Configurações do tema
 */
function sesc_rr_customize_register($wp_customize) {
    // Seção SESC Settings
    $wp_customize->add_section('sesc_settings', array(
        'title' => __('Configurações SESC', 'sesc-rr'),
        'priority' => 30,
    ));

    // Telefone de contato
    $wp_customize->add_setting('sesc_phone', array(
        'default' => '(95) 3219-4100',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('sesc_phone', array(
        'label' => __('Telefone de Contato', 'sesc-rr'),
        'section' => 'sesc_settings',
        'type' => 'text',
        'description' => __('Telefone exibido na barra superior', 'sesc-rr'),
    ));

    // Texto do link de login
    $wp_customize->add_setting('sesc_login_text', array(
        'default' => 'Espaço do Cliente ou Cadastre-se',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('sesc_login_text', array(
        'label' => __('Texto do Link de Login', 'sesc-rr'),
        'section' => 'sesc_settings',
        'type' => 'text',
    ));

    // URL do link de login
    $wp_customize->add_setting('sesc_login_url', array(
        'default' => '/minha-conta',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('sesc_login_url', array(
        'label' => __('URL do Link de Login', 'sesc-rr'),
        'section' => 'sesc_settings',
        'type' => 'url',
    ));

    // Localização
    $wp_customize->add_setting('sesc_location', array(
        'default' => 'RORAIMA',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('sesc_location', array(
        'label' => __('Localização', 'sesc-rr'),
        'section' => 'sesc_settings',
        'type' => 'text',
        'description' => __('Texto exibido ao lado do logo', 'sesc-rr'),
    ));

    // Placeholder da busca
    $wp_customize->add_setting('sesc_search_placeholder', array(
        'default' => 'Busque por atividades ou outros conteúdos...',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('sesc_search_placeholder', array(
        'label' => __('Placeholder da Busca', 'sesc-rr'),
        'section' => 'sesc_settings',
        'type' => 'text',
    ));

    // Cores do tema
    $wp_customize->add_setting('sesc_primary_color', array(
        'default' => '#00a8cc',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'sesc_primary_color', array(
        'label' => __('Cor Primária', 'sesc-rr'),
        'section' => 'sesc_settings',
    )));

    $wp_customize->add_setting('sesc_secondary_color', array(
        'default' => '#f39c12',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'sesc_secondary_color', array(
        'label' => __('Cor Secundária', 'sesc-rr'),
        'section' => 'sesc_settings',
    )));
}
add_action('customize_register', 'sesc_rr_customize_register');

/**
 * Adicionar CSS customizado baseado nas configurações do Customizer
 */
function sesc_rr_customizer_css() {
    $primary_color = get_theme_mod('sesc_primary_color', '#00a8cc');
    $secondary_color = get_theme_mod('sesc_secondary_color', '#f39c12');
    
    ?>
    <style type="text/css">
        :root {
            --sesc-blue: <?php echo esc_attr($primary_color); ?>;
            --sesc-orange: <?php echo esc_attr($secondary_color); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'sesc_rr_customizer_css');

/**
 * Adicionar classes CSS ao body
 */
function sesc_rr_body_classes($classes) {
    // Adicionar classe para o navbar
    $classes[] = 'sesc-navbar';
    
    // Adicionar classe baseada na página
    if (is_front_page()) {
        $classes[] = 'sesc-homepage';
    }
    
    if (is_page()) {
        $classes[] = 'sesc-page';
    }
    
    if (is_single()) {
        $classes[] = 'sesc-single';
    }
    
    return $classes;
}
add_filter('body_class', 'sesc_rr_body_classes');

/**
 * Filtrar o excerpt
 */
function sesc_rr_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'sesc_rr_excerpt_length');

function sesc_rr_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'sesc_rr_excerpt_more');

/**
 * Remover versão do WordPress do head por segurança
 */
remove_action('wp_head', 'wp_generator');

/**
 * Desabilitar XML-RPC se não necessário
 */
add_filter('xmlrpc_enabled', '__return_false');

/**
 * Adicionar meta tags necessárias
 */
function sesc_rr_meta_tags() {
    ?>
    <meta name="theme-color" content="<?php echo esc_attr(get_theme_mod('sesc_primary_color', '#00a8cc')); ?>">
    <meta name="msapplication-navbutton-color" content="<?php echo esc_attr(get_theme_mod('sesc_primary_color', '#00a8cc')); ?>">
    <meta name="apple-mobile-web-app-status-bar-style" content="<?php echo esc_attr(get_theme_mod('sesc_primary_color', '#00a8cc')); ?>">
    <?php
}
add_action('wp_head', 'sesc_rr_meta_tags');

/**
 * Shortcodes úteis
 */

// Shortcode para exibir telefone
function sesc_rr_phone_shortcode($atts) {
    $phone = get_theme_mod('sesc_phone', '(95) 3219-4100');
    return '<a href="tel:' . esc_attr($phone) . '" class="phone-link">' . esc_html($phone) . '</a>';
}
add_shortcode('sesc_phone', 'sesc_rr_phone_shortcode');

// Shortcode para botão
function sesc_rr_button_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
        'url' => '#',
        'style' => 'primary',
        'size' => 'normal',
        'target' => '_self'
    ), $atts);
    
    $classes = 'btn btn-' . esc_attr($atts['style']);
    if ($atts['size'] !== 'normal') {
        $classes .= ' btn-' . esc_attr($atts['size']);
    }
    
    return '<a href="' . esc_url($atts['url']) . '" class="' . $classes . '" target="' . esc_attr($atts['target']) . '">' . do_shortcode($content) . '</a>';
}
add_shortcode('sesc_button', 'sesc_rr_button_shortcode');

/**
 * Widget personalizado para categorias SESC
 */
class SESC_Categories_Widget extends WP_Widget {
    
    function __construct() {
        parent::__construct(
            'sesc_categories',
            __('SESC Categorias', 'sesc-rr'),
            array('description' => __('Exibe as categorias SESC em formato colorido', 'sesc-rr'))
        );
    }
    
    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        
        $categories = array(
            'educacao' => array('name' => __('Educação', 'sesc-rr'), 'color' => '#9b59b6', 'url' => '/educacao'),
            'esporte' => array('name' => __('Esporte', 'sesc-rr'), 'color' => '#f39c12', 'url' => '/esporte'),
            'saude' => array('name' => __('Saúde', 'sesc-rr'), 'color' => '#27ae60', 'url' => '/saude'),
            'cultura' => array('name' => __('Cultura', 'sesc-rr'), 'color' => '#e74c3c', 'url' => '/cultura'),
            'assistencia' => array('name' => __('Assistência', 'sesc-rr'), 'color' => '#8e44ad', 'url' => '/assistencia'),
            'turismo' => array('name' => __('Turismo', 'sesc-rr'), 'color' => '#2ecc71', 'url' => '/turismo')
        );
        
        echo '<div class="sesc-categories-widget">';
        foreach ($categories as $slug => $category) {
            echo '<a href="' . esc_url(home_url($category['url'])) . '" 
                     class="widget-category-item" 
                     style="background-color: ' . esc_attr($category['color']) . ';">' 
                     . esc_html($category['name']) . '</a>';
        }
        echo '</div>';
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Nossas Áreas', 'sesc-rr');
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Título:', 'sesc-rr'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" 
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
}

function sesc_rr_register_widgets() {
    register_widget('SESC_Categories_Widget');
}
add_action('widgets_init', 'sesc_rr_register_widgets');

/**
 * Funções auxiliares
 */

// Obter configurações do tema
function sesc_get_option($option, $default = '') {
    return get_theme_mod($option, $default);
}

// Incluir arquivos adicionais
require_once SESC_RR_THEME_DIR . '/inc/customizer.php';
require_once SESC_RR_THEME_DIR . '/inc/widgets.php';

/**
 * Otimizações de performance
 */

// Remover jQuery Migrate
function sesc_rr_remove_jquery_migrate($scripts) {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) {
            $script->deps = array_diff($script->deps, array('jquery-migrate'));
        }
    }
}
add_action('wp_default_scripts', 'sesc_rr_remove_jquery_migrate');

// Preload de recursos críticos
function sesc_rr_preload_resources() {
    echo '<link rel="preload" href="' . SESC_RR_THEME_URI . '/assets/css/navbar.css" as="style">';
    echo '<link rel="preload" href="' . SESC_RR_THEME_URI . '/assets/js/navbar.js" as="script">';
}
add_action('wp_head', 'sesc_rr_preload_resources', 1);

?>