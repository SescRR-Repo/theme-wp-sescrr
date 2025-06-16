<?php
/**
 * Template do cabeçalho - SESC RR
 * Navbar estilo SESC TO - VERSÃO CORRIGIDA
 * 
 * @package SESC_RR
 * @since 1.0.0
 */

// Prevenir acesso direto
if (!defined('ABSPATH')) {
    exit;
}
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="#00a8cc">
    <meta name="msapplication-navbutton-color" content="#00a8cc">
    <meta name="apple-mobile-web-app-status-bar-style" content="#00a8cc">
    
    <!-- Preconnect para performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="site">
    
    <!-- BARRA SUPERIOR UTILITÁRIA -->
    <div class="sesc-utility-bar">
        <div class="container">
            <div class="utility-content">
                <!-- Telefone (esquerda) -->
                <div class="utility-left">
                    <a href="tel:<?php echo esc_attr(get_theme_mod('sesc_phone', '(95) 3219-4100')); ?>" 
                       class="phone-link" 
                       aria-label="Ligar para SESC RR">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M20 15.5c-1.25 0-2.45-.2-3.57-.57-.35-.11-.74-.03-1.02.24l-2.2 2.2c-2.83-1.44-5.15-3.75-6.59-6.59l2.2-2.2c.27-.27.35-.67.24-1.02C8.7 6.45 8.5 5.25 8.5 4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1 0 9.39 7.61 17 17 17 .55 0 1-.45 1-1v-3.5c0-.55-.45-1-1-1z"/>
                        </svg>
                        <span><?php echo esc_html(get_theme_mod('sesc_phone', '(95) 3219-4100')); ?></span>
                    </a>
                </div>
                
                <!-- Dropdown Serviços (direita) -->
                <div class="utility-right">
                    <div class="services-dropdown">
                        <button class="btn-services" 
                                type="button" 
                                aria-expanded="false" 
                                aria-haspopup="true"
                                aria-controls="services-menu">
                            Serviços 
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M7 10l5 5 5-5z"/>
                            </svg>
                        </button>
                        <div class="services-menu" id="services-menu" role="menu">
                            <a href="<?php echo esc_url(home_url('/servicos/inscricoes')); ?>" role="menuitem">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                                </svg>
                                Inscrições
                            </a>
                            <a href="<?php echo esc_url(home_url('/servicos/carteirinha')); ?>" role="menuitem">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                                Carteirinha SESC
                            </a>
                            <a href="<?php echo esc_url(home_url('/servicos/agendamentos')); ?>" role="menuitem">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/>
                                </svg>
                                Agendamentos
                            </a>
                            <a href="<?php echo esc_url(home_url('/servicos/consultas')); ?>" role="menuitem">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                Consultas Médicas
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- HEADER PRINCIPAL -->
    <header class="site-header" role="banner">
        <div class="main-navbar">
            <div class="container">
                <div class="navbar-content">
                    
                    <!-- LOGO E LOCALIZAÇÃO -->
                    <div class="navbar-brand">
                        <?php if (has_custom_logo()) : ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" 
                               class="custom-logo-link" 
                               rel="home"
                               aria-label="<?php echo esc_attr(get_bloginfo('name')); ?> - Página inicial">
                                <?php the_custom_logo(); ?>
                            </a>
                        <?php else : ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" 
                               class="site-title-link" 
                               rel="home">
                                <h1 class="site-title"><?php bloginfo('name'); ?></h1>
                                <?php 
                                $description = get_bloginfo('description', 'display');
                                if ($description || is_customize_preview()) : ?>
                                    <p class="site-description"><?php echo $description; ?></p>
                                <?php endif; ?>
                            </a>
                        <?php endif; ?>
                        
                        <span class="location-badge" aria-label="Localização">
                            <?php echo esc_html(get_theme_mod('sesc_location', 'RORAIMA')); ?>
                        </span>
                    </div>
                    
                    <!-- BARRA DE BUSCA CENTRAL -->
                    <div class="navbar-search">
                        <form class="sesc-search-form" 
                              role="search" 
                              method="get" 
                              action="<?php echo esc_url(home_url('/')); ?>"
                              aria-label="Formulário de busca">
                            <label for="search-input" class="sr-only">Buscar conteúdo</label>
                            <input type="search" 
                                   id="search-input"
                                   name="s"
                                   class="search-input" 
                                   placeholder="<?php echo esc_attr(get_theme_mod('sesc_search_placeholder', 'Busque por atividades ou outros conteúdos...')); ?>"
                                   value="<?php echo get_search_query(); ?>" 
                                   autocomplete="off"
                                   aria-describedby="search-help" />
                            <span id="search-help" class="sr-only">Digite sua busca e pressione Enter</span>
                            <button type="submit" 
                                    class="search-button" 
                                    aria-label="Executar busca">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                                </svg>
                            </button>
                        </form>
                        
                        <!-- Resultados de busca em tempo real -->
                        <div class="search-results" id="search-results" role="region" aria-live="polite"></div>
                    </div>
                    
                    <!-- ÁREA DE LOGIN -->
                    <div class="navbar-user">
                        <a href="<?php echo esc_url(get_theme_mod('sesc_login_url', home_url('/minha-conta'))); ?>" 
                           class="user-login-link"
                           aria-label="Área do cliente">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                            <span><?php echo esc_html(get_theme_mod('sesc_login_text', 'Espaço do Cliente ou Cadastre-se')); ?></span>
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- MENU DE CATEGORIAS COLORIDO -->
        <nav class="category-nav" role="navigation" aria-label="Menu de categorias">
            <div class="container">
                <?php
                // USAR MENU PERSONALIZADO SE EXISTIR, SENÃO USAR FALLBACK
                if (has_nav_menu('category_menu')) {
                    wp_nav_menu(array(
                        'theme_location' => 'category_menu',
                        'menu_class'     => 'category-menu',
                        'container'      => false,
                        'depth'          => 2,
                        'walker'         => new SESC_Category_Walker(),
                        'fallback_cb'    => false,
                    ));
                } else {
                    // FALLBACK COM DROPDOWN FUNCIONAL
                    ?>
                    <ul class="category-menu">
                        <li class="category-item menu-item-has-children cat-educacao" style="background-color: #9b59b6;">
                            <a href="<?php echo esc_url(home_url('/educacao')); ?>">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/>
                                </svg>
                                <span>EDUCAÇÃO</span>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="<?php echo esc_url(home_url('/educacao/cursos')); ?>">Cursos</a></li>
                                <li><a href="<?php echo esc_url(home_url('/educacao/oficinas')); ?>">Oficinas</a></li>
                                <li><a href="<?php echo esc_url(home_url('/educacao/palestras')); ?>">Palestras</a></li>
                                <li><a href="<?php echo esc_url(home_url('/educacao/ead')); ?>">Ensino à Distância</a></li>
                            </ul>
                        </li>
                        
                        <li class="category-item menu-item-has-children cat-esporte" style="background-color: #f39c12;">
                            <a href="<?php echo esc_url(home_url('/esporte')); ?>">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                                <span>ESPORTE</span>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="<?php echo esc_url(home_url('/esporte/academia')); ?>">Academia</a></li>
                                <li><a href="<?php echo esc_url(home_url('/esporte/piscina')); ?>">Piscina</a></li>
                                <li><a href="<?php echo esc_url(home_url('/esporte/quadras')); ?>">Quadras</a></li>
                                <li><a href="<?php echo esc_url(home_url('/esporte/atividades')); ?>">Atividades Esportivas</a></li>
                            </ul>
                        </li>
                        
                        <li class="category-item menu-item-has-children cat-saude" style="background-color: #27ae60;">
                            <a href="<?php echo esc_url(home_url('/saude')); ?>">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M19 8h-2v3h-3v2h3v3h2v-3h3v-2h-3V8zM4 8h2v8H4V8zm0-2h2V4H4v2zm14 0h2V4h-2v2z"/>
                                </svg>
                                <span>SAÚDE</span>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="<?php echo esc_url(home_url('/saude/consultas')); ?>">Consultas</a></li>
                                <li><a href="<?php echo esc_url(home_url('/saude/odontologia')); ?>">Odontologia</a></li>
                                <li><a href="<?php echo esc_url(home_url('/saude/nutricao')); ?>">Nutrição</a></li>
                                <li><a href="<?php echo esc_url(home_url('/saude/prevencao')); ?>">Prevenção</a></li>
                            </ul>
                        </li>
                        
                        <li class="category-item menu-item-has-children cat-cultura" style="background-color: #e74c3c;">
                            <a href="<?php echo esc_url(home_url('/cultura')); ?>">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <span>CULTURA</span>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="<?php echo esc_url(home_url('/cultura/exposicoes')); ?>">Exposições</a></li>
                                <li><a href="<?php echo esc_url(home_url('/cultura/teatro')); ?>">Teatro</a></li>
                                <li><a href="<?php echo esc_url(home_url('/cultura/musica')); ?>">Música</a></li>
                                <li><a href="<?php echo esc_url(home_url('/cultura/biblioteca')); ?>">Biblioteca</a></li>
                            </ul>
                        </li>
                        
                        <li class="category-item menu-item-has-children cat-assistencia" style="background-color: #8e44ad;">
                            <a href="<?php echo esc_url(home_url('/assistencia')); ?>">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                                <span>ASSISTÊNCIA</span>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="<?php echo esc_url(home_url('/assistencia/social')); ?>">Assistência Social</a></li>
                                <li><a href="<?php echo esc_url(home_url('/assistencia/juridica')); ?>">Assessoria Jurídica</a></li>
                                <li><a href="<?php echo esc_url(home_url('/assistencia/emergencia')); ?>">Atendimento Emergencial</a></li>
                                <li><a href="<?php echo esc_url(home_url('/assistencia/orientacao')); ?>">Orientação</a></li>
                            </ul>
                        </li>
                        
                        <li class="category-item menu-item-has-children cat-turismo" style="background-color: #2ecc71;">
                            <a href="<?php echo esc_url(home_url('/turismo')); ?>">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M14 6V4h-4v2h4zM4 8v11h16V8H4zm16-2c1.11 0 2 .89 2 2v11c0 1.11-.89 2-2 2H4c-1.11 0-2-.89-2-2l.01-11c0-1.11.89-2 2-2h4l2-2h4l2 2h4z"/>
                                </svg>
                                <span>TURISMO</span>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="<?php echo esc_url(home_url('/turismo/hoteis')); ?>">Hotéis SESC</a></li>
                                <li><a href="<?php echo esc_url(home_url('/turismo/pacotes')); ?>">Pacotes</a></li>
                                <li><a href="<?php echo esc_url(home_url('/turismo/excursoes')); ?>">Excursões</a></li>
                                <li><a href="<?php echo esc_url(home_url('/turismo/reservas')); ?>">Reservas</a></li>
                            </ul>
                        </li>
                    </ul>
                    <?php
                }
                ?>
            </div>
        </nav>
    </header>

    <!-- MENU MOBILE -->
    <div class="mobile-overlay" id="mobile-overlay" aria-hidden="true"></div>
    
    <button class="mobile-toggle" 
            aria-controls="mobile-menu" 
            aria-expanded="false"
            aria-label="Abrir menu de navegação">
        <span class="hamburger-icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
        <span class="menu-text">Menu</span>
    </button>

    <div class="mobile-menu" id="mobile-menu" role="dialog" aria-modal="true" aria-labelledby="mobile-menu-title">
        <div class="mobile-menu-header">
            <h2 id="mobile-menu-title">Menu Principal</h2>
            <button class="mobile-close" aria-label="Fechar menu">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                </svg>
            </button>
        </div>
        
        <div class="mobile-search">
            <form class="mobile-search-form" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                <label for="mobile-search-input" class="sr-only">Buscar conteúdo</label>
                <input type="search" 
                       id="mobile-search-input"
                       name="s" 
                       placeholder="Buscar..." 
                       value="<?php echo get_search_query(); ?>" />
                <button type="submit">Buscar</button>
            </form>
        </div>
        
        <nav class="mobile-nav" role="navigation" aria-label="Menu mobile">
            <?php
            // Menu mobile usando o mesmo menu de categorias
            if (has_nav_menu('category_menu')) {
                wp_nav_menu(array(
                    'theme_location' => 'category_menu',
                    'menu_class'     => 'mobile-category-list',
                    'container'      => false,
                    'depth'          => 2,
                    'walker'         => new SESC_Category_Walker(),
                    'fallback_cb'    => false
                ));
            } else {
                // Fallback manual se não houver menu configurado
                ?>
                <ul class="mobile-category-list">
                    <li class="menu-item-has-children">
                        <a href="<?php echo esc_url(home_url('/educacao')); ?>">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3z"/>
                            </svg>
                            EDUCAÇÃO
                        </a>
                        <ul class="sub-menu">
                            <li><a href="<?php echo esc_url(home_url('/educacao/cursos')); ?>">Cursos</a></li>
                            <li><a href="<?php echo esc_url(home_url('/educacao/oficinas')); ?>">Oficinas</a></li>
                            <li><a href="<?php echo esc_url(home_url('/educacao/palestras')); ?>">Palestras</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children">
                        <a href="<?php echo esc_url(home_url('/esporte')); ?>">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/>
                            </svg>
                            ESPORTE
                        </a>
                        <ul class="sub-menu">
                            <li><a href="<?php echo esc_url(home_url('/esporte/academia')); ?>">Academia</a></li>
                            <li><a href="<?php echo esc_url(home_url('/esporte/piscina')); ?>">Piscina</a></li>
                            <li><a href="<?php echo esc_url(home_url('/esporte/quadras')); ?>">Quadras</a></li>
                        </ul>
                    </li>
                    <!-- Outras categorias seguem o mesmo padrão -->
                </ul>
                <?php
            }
            ?>
        </nav>
        
        <div class="mobile-user-area">
            <a href="<?php echo esc_url(get_theme_mod('sesc_login_url', home_url('/minha-conta'))); ?>" 
               class="mobile-login">
                <?php echo esc_html(get_theme_mod('sesc_login_text', 'Espaço do Cliente')); ?>
            </a>
            <a href="tel:<?php echo esc_attr(get_theme_mod('sesc_phone', '(95) 3219-4100')); ?>" 
               class="mobile-phone">
                <?php echo esc_html(get_theme_mod('sesc_phone', '(95) 3219-4100')); ?>
            </a>
        </div>
    </div>

    <!-- Skip link para acessibilidade -->
    <a class="skip-link sr-only" href="#main">Pular para o conteúdo principal</a>

    <!-- INÍCIO DO CONTEÚDO PRINCIPAL -->