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
        'categorias' => __('Menu de Categorias SESC', 'sesc-rr'), // novo menu de categorias

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

/**
 * ADICIONAR ao final do functions.php
 * Sistema de Menu de Categorias com Dropdown
 */

// Registrar novo local de menu
function sesc_register_category_menu() {
    register_nav_menus(array(
        'category_menu' => __('Menu de Categorias SESC', 'sesc-rr'),
    ));
}
add_action('after_setup_theme', 'sesc_register_category_menu');

// Walker personalizado para o menu de categorias
class SESC_Category_Walker extends Walker_Nav_Menu {
    
    // Definir cores das categorias
    private $category_colors = array(
        'educacao'    => '#9b59b6',
        'esporte'     => '#f39c12', 
        'saude'       => '#27ae60',
        'cultura'     => '#e74c3c',
        'assistencia' => '#8e44ad',
        'turismo'     => '#2ecc71'
    );
    
    // Iniciar item do menu
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        // Detectar categoria pela classe CSS personalizada
        $category_class = '';
        $background_color = '';
        
        // Procurar por classes CSS personalizadas
        foreach ($classes as $class) {
            if (array_key_exists($class, $this->category_colors)) {
                $category_class = $class;
                $background_color = $this->category_colors[$class];
                break;
            }
        }
        
        // Se não encontrou pela classe, tentar pelo título/nome
        if (!$background_color) {
            $title_lower = strtolower($item->title);
            $title_clean = remove_accents($title_lower);
            
            if (strpos($title_clean, 'educacao') !== false || strpos($title_clean, 'educação') !== false) {
                $category_class = 'educacao';
                $background_color = $this->category_colors['educacao'];
            } elseif (strpos($title_clean, 'esporte') !== false) {
                $category_class = 'esporte';
                $background_color = $this->category_colors['esporte'];
            } elseif (strpos($title_clean, 'saude') !== false || strpos($title_clean, 'saúde') !== false) {
                $category_class = 'saude';
                $background_color = $this->category_colors['saude'];
            } elseif (strpos($title_clean, 'cultura') !== false) {
                $category_class = 'cultura';
                $background_color = $this->category_colors['cultura'];
            } elseif (strpos($title_clean, 'assistencia') !== false || strpos($title_clean, 'assistência') !== false) {
                $category_class = 'assistencia';
                $background_color = $this->category_colors['assistencia'];
            } elseif (strpos($title_clean, 'turismo') !== false) {
                $category_class = 'turismo';
                $background_color = $this->category_colors['turismo'];
            }
        }
        
        // Cor padrão se não encontrar
        if (!$background_color) {
            $background_color = '#00a8cc';
        }
        
        // Verificar se tem submenu
        $has_children = in_array('menu-item-has-children', $classes);
        if ($has_children) {
            $classes[] = 'has-submenu';
        }

        if (!in_array('menu-item-has-children', $classes) && isset($args->has_children) && $args->has_children) {
            $classes[] = 'menu-item-has-children';
        }


        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . ' category-item cat-' . $category_class . '"' : ' class="category-item"';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        // Estilo inline para cor de fundo (apenas no nível principal)
        $style = '';
        if ($depth === 0) {
            $style = ' style="background-color: ' . esc_attr($background_color) . ';"';
        }
        
        $output .= $indent . '<li' . $id . $class_names . $style . '>';
        
        $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target     ) .'"' : '';
        $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn        ) .'"' : '';
        $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url        ) .'"' : '';
        
        // Adicionar ícone se for menu principal
        $icon = '';
        if ($depth === 0) {
            $icons = array(
                'educacao'    => 'M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z',
                'esporte'     => 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z',
                'saude'       => 'M19 8h-2v3h-3v2h3v3h2v-3h3v-2h-3V8zM4 8h2v8H4V8zm0-2h2V4H4v2zm14 0h2V4h-2v2z',
                'cultura'     => 'M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z',
                'assistencia' => 'M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z',
                'turismo'     => 'M14 6V4h-4v2h4zM4 8v11h16V8H4zm16-2c1.11 0 2 .89 2 2v11c0 1.11-.89 2-2 2H4c-1.11 0-2-.89-2-2l.01-11c0-1.11.89-2 2-2h4l2-2h4l2 2h4z'
            );
            
            $icon_path = isset($icons[$category_class]) ? $icons[$category_class] : $icons['cultura'];
            $icon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="' . esc_attr($icon_path) . '"/>
                     </svg>';
        }
        
        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a' . $attributes . '>';
        $item_output .= ($icon && $depth === 0) ? $icon . '<span>' : '';
        $item_output .= (isset($args->link_before) ? $args->link_before : '') . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : '');
        $item_output .= ($icon && $depth === 0) ? '</span>' : '';
        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
    
    // Iniciar submenu
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu\">\n";
    }
    
    // Finalizar submenu
    function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }
}

// Menu fallback se não estiver configurado
function sesc_fallback_menu() {
    echo '<div class="menu-not-configured">';
    echo '<p style="text-align: center; padding: 20px; color: white; background: rgba(0,0,0,0.2);">';
    echo 'Menu não configurado. Vá em <strong>Aparência > Menus</strong> para configurar o "Menu de Categorias SESC".';
    echo '</p>';
    echo '</div>';
}

// Adicionar campo personalizado para cores no admin de menus
function sesc_add_menu_color_field($item_id, $item, $depth, $args) {
    $category_colors = array(
        'educacao'    => 'Educação (#9b59b6)',
        'esporte'     => 'Esporte (#f39c12)', 
        'saude'       => 'Saúde (#27ae60)',
        'cultura'     => 'Cultura (#e74c3c)',
        'assistencia' => 'Assistência (#8e44ad)',
        'turismo'     => 'Turismo (#2ecc71)'
    );
    
    $current_classes = get_post_meta($item_id, '_menu_item_classes', true);
    $current_category = '';
    
    if (is_array($current_classes)) {
        foreach ($current_classes as $class) {
            if (array_key_exists($class, $category_colors)) {
                $current_category = $class;
                break;
            }
        }
    }
    ?>
    <p class="field-sesc-category description description-wide">
        <label for="edit-menu-item-sesc-category-<?php echo $item_id; ?>">
            Categoria SESC<br />
            <select id="edit-menu-item-sesc-category-<?php echo $item_id; ?>" name="menu-item-sesc-category[<?php echo $item_id; ?>]">
                <option value="">Selecione uma categoria</option>
                <?php foreach ($category_colors as $key => $label) : ?>
                    <option value="<?php echo esc_attr($key); ?>" <?php selected($current_category, $key); ?>>
                        <?php echo esc_html($label); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
    </p>
    <?php
}
add_action('wp_nav_menu_item_custom_fields', 'sesc_add_menu_color_field', 10, 4);

// Salvar campo personalizado
function sesc_save_menu_color_field($menu_id, $menu_item_db_id, $args) {
    if (isset($_REQUEST['menu-item-sesc-category'][$menu_item_db_id])) {
        $category = sanitize_text_field($_REQUEST['menu-item-sesc-category'][$menu_item_db_id]);
        
        if ($category) {
            // Adicionar classe CSS
            $classes = get_post_meta($menu_item_db_id, '_menu_item_classes', true);
            if (!is_array($classes)) {
                $classes = array();
            }
            
            // Remover classes antigas de categoria
            $category_classes = array('educacao', 'esporte', 'saude', 'cultura', 'assistencia', 'turismo');
            $classes = array_diff($classes, $category_classes);
            
            // Adicionar nova classe
            $classes[] = $category;
            
            update_post_meta($menu_item_db_id, '_menu_item_classes', $classes);
        }
    }
}
add_action('wp_update_nav_menu_item', 'sesc_save_menu_color_field', 10, 3);

?>