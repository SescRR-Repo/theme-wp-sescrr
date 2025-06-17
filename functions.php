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
        $icons = array(
            'educacao' => array(
                'M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917z',   // primeiro <path>
                'M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466z',   // segundo <path>
            ),
            'cultura' => array(
                'M6 3a3 3 0 1 1-6 0 3 3 0 0 1 6 0',          // único <path>
                'M9 6a3 3 0 1 1 0-6 3 3 0 0 1 0 6',          // único <path>
                'M9 6h.5a2 2 0 0 1 1.983 1.738l3.11-1.382A1 1 0 0 1 16 7.269v7.462a1 1 0 0 1-1.406.913l-3.111-1.382A2 2 0 0 1 9.5 16H2a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2z',          // único <path>
            ),
            'assistencia' => array(
                'M6 6.207v9.043a.75.75 0 0 0 1.5 0V10.5a.5.5 0 0 1 1 0v4.75a.75.75 0 0 0 1.5 0v-8.5a.25.25 0 1 1 .5 0v2.5a.75.75 0 0 0 1.5 0V6.5a3 3 0 0 0-3-3H6.236a1 1 0 0 1-.447-.106l-.33-.165A.83.83 0 0 1 5 2.488V.75a.75.75 0 0 0-1.5 0v2.083c0 .715.404 1.37 1.044 1.689L5.5 5c.32.32.5.754.5 1.207',          // único <path>
                'M8 3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3',          // único <path>
            ),
            'saude' => array(
                'M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314',
            ),
            'turismo' => array(
                'M2 1.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V5h.5A1.5 1.5 0 0 1 8 6.5V7H7v-.5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .5.5H4v1H2.5v.25a.75.75 0 0 1-1.5 0v-.335A1.5 1.5 0 0 1 0 13.5v-7A1.5 1.5 0 0 1 1.5 5H2zM3 5h2V2H3z',          // único <path>
                'M2.5 7a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0v-5a.5.5 0 0 1 .5-.5m10 1v-.5A1.5 1.5 0 0 0 11 6h-1a1.5 1.5 0 0 0-1.5 1.5V8H8v8h5V8zM10 7h1a.5.5 0 0 1 .5.5V8h-2v-.5A.5.5 0 0 1 10 7M5 9.5A1.5 1.5 0 0 1 6.5 8H7v8h-.5A1.5 1.5 0 0 1 5 14.5zm9 6.5V8h.5A1.5 1.5 0 0 1 16 9.5v5a1.5 1.5 0 0 1-1.5 1.5z',          // único <path>
            ),
            'esporte' => array(
                'M8 0C3.584 0 0 3.584 0 8s3.584 8 8 8c4.408 0 8-3.584 8-8s-3.592-8-8-8m5.284 3.688a6.8 6.8 0 0 1 1.545 4.251c-.226-.043-2.482-.503-4.755-.217-.052-.112-.096-.234-.148-.355-.139-.33-.295-.668-.451-.99 2.516-1.023 3.662-2.498 3.81-2.69zM8 1.18c1.735 0 3.323.65 4.53 1.718-.122.174-1.155 1.553-3.584 2.464-1.12-2.056-2.36-3.74-2.551-4A7 7 0 0 1 8 1.18m-2.907.642A43 43 0 0 1 7.627 5.77c-3.193.85-6.013.833-6.317.833a6.87 6.87 0 0 1 3.783-4.78zM1.163 8.01V7.8c.295.01 3.61.053 7.02-.971.199.381.381.772.555 1.162l-.27.078c-3.522 1.137-5.396 4.243-5.553 4.504a6.82 6.82 0 0 1-1.752-4.564zM8 14.837a6.8 6.8 0 0 1-4.19-1.44c.12-.252 1.509-2.924 5.361-4.269.018-.009.026-.009.044-.017a28.3 28.3 0 0 1 1.457 5.18A6.7 6.7 0 0 1 8 14.837m3.81-1.171c-.07-.417-.435-2.412-1.328-4.868 2.143-.338 4.017.217 4.251.295a6.77 6.77 0 0 1-2.924 4.573z',          // único <path>
            ),
            // etc
            );

            

            if ( $depth === 0 ) {
            $paths = isset($icons[$category_class])
                ? $icons[$category_class]
                : $icons['cultura'];

            // monta o SVG com todos os paths
            $icon  = '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">';
            foreach( $paths as $d ){
                $icon .= '<path d="' . esc_attr($d) . '" />';
            }
            $icon .= '</svg>';
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