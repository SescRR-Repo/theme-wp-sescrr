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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-square-fill" viewBox="0 0 16 16">
                                    <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"/>
                                </svg>
                                Inscrições
                            </a>
                            <a href="<?php echo esc_url(home_url('/servicos/carteirinha')); ?>" role="menuitem">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-vcard-fill" viewBox="0 0 16 16">
                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5M9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8m1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5m-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96q.04-.245.04-.5M7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0"/>
                                </svg>
                                Credencial SESC
                            </a>
                            <a href="<?php echo esc_url(home_url('/servicos/agendamentos')); ?>" role="menuitem">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/>
                                </svg>
                                Agendamentos
                            </a>
                            <a href="<?php echo esc_url(home_url('/servicos/consultas')); ?>" role="menuitem">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard2-pulse-fill" viewBox="0 0 16 16">
                                    <path d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5"/>
                                    <path d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585q.084.236.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5q.001-.264.085-.5M9.98 5.356 11.372 10h.128a.5.5 0 0 1 0 1H11a.5.5 0 0 1-.479-.356l-.94-3.135-1.092 5.096a.5.5 0 0 1-.968.039L6.383 8.85l-.936 1.873A.5.5 0 0 1 5 11h-.5a.5.5 0 0 1 0-1h.191l1.362-2.724a.5.5 0 0 1 .926.08l.94 3.135 1.092-5.096a.5.5 0 0 1 .968-.039Z"/>
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
                            <span><?php echo esc_html(get_theme_mod('sesc_login_text', 'Espaço do Cliente')); ?></span>
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- MENU DE CATEGORIAS COLORIDO -->
        <nav class="category-nav" role="navigation" aria-label="Menu de categorias">
            <div class="container">
                <?php
                if (has_nav_menu('category_menu')) {
                    // USAR MENU CONFIGURADO NO WORDPRESS
                    wp_nav_menu(array(
                        'theme_location' => 'category_menu',
                        'menu_class'     => 'category-menu',
                        'container'      => false,
                        'depth'          => 2,
                        'walker'         => new SESC_Category_Walker(),
                        'fallback_cb'    => false,
                    ));
                } else {
                    // FALLBACK SIMPLES - SEM SUBMENUS FIXOS
                    ?>
                    <ul class="category-menu">
                        <li class="category-item cat-educacao" style="background-color: #9b59b6;">
                            <a href="<?php echo esc_url(home_url('/educacao')); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-mortarboard-fill" viewBox="0 0 16 16">
                                    <path d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917z"/>
                                    <path d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466z"/>
                                </svg>
                                <span>EDUCAÇÃO</span>
                            </a>
                        </li>
                        
                        <li class="category-item cat-esporte" style="background-color: #f39c12;">
                            <a href="<?php echo esc_url(home_url('/esporte')); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dribbble" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 0C3.584 0 0 3.584 0 8s3.584 8 8 8c4.408 0 8-3.584 8-8s-3.592-8-8-8m5.284 3.688a6.8 6.8 0 0 1 1.545 4.251c-.226-.043-2.482-.503-4.755-.217-.052-.112-.096-.234-.148-.355-.139-.33-.295-.668-.451-.99 2.516-1.023 3.662-2.498 3.81-2.69zM8 1.18c1.735 0 3.323.65 4.53 1.718-.122.174-1.155 1.553-3.584 2.464-1.12-2.056-2.36-3.74-2.551-4A7 7 0 0 1 8 1.18m-2.907.642A43 43 0 0 1 7.627 5.77c-3.193.85-6.013.833-6.317.833a6.87 6.87 0 0 1 3.783-4.78zM1.163 8.01V7.8c.295.01 3.61.053 7.02-.971.199.381.381.772.555 1.162l-.27.078c-3.522 1.137-5.396 4.243-5.553 4.504a6.82 6.82 0 0 1-1.752-4.564zM8 14.837a6.8 6.8 0 0 1-4.19-1.44c.12-.252 1.509-2.924 5.361-4.269.018-.009.026-.009.044-.017a28.3 28.3 0 0 1 1.457 5.18A6.7 6.7 0 0 1 8 14.837m3.81-1.171c-.07-.417-.435-2.412-1.328-4.868 2.143-.338 4.017.217 4.251.295a6.77 6.77 0 0 1-2.924 4.573z"/>
                                </svg>
                                <span>ESPORTE</span>
                            </a>
                        </li>
                        
                        <li class="category-item cat-saude" style="background-color: #27ae60;">
                            <a href="<?php echo esc_url(home_url('/saude')); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-pulse-fill" viewBox="0 0 16 16">
                                    <path d="M1.475 9C2.702 10.84 4.779 12.871 8 15c3.221-2.129 5.298-4.16 6.525-6H12a.5.5 0 0 1-.464-.314l-1.457-3.642-1.598 5.593a.5.5 0 0 1-.945.049L5.889 6.568l-1.473 2.21A.5.5 0 0 1 4 9z"/>
                                    <path d="M.88 8C-2.427 1.68 4.41-2 7.823 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C11.59-2 18.426 1.68 15.12 8h-2.783l-1.874-4.686a.5.5 0 0 0-.945.049L7.921 8.956 6.464 5.314a.5.5 0 0 0-.88-.091L3.732 8z"/>
                                </svg>
                                <span>SAÚDE</span>
                            </a>
                        </li>
                        
                        <li class="category-item cat-cultura" style="background-color: #e74c3c;">
                            <a href="<?php echo esc_url(home_url('/cultura')); ?>">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <span>CULTURA</span>
                            </a>
                        </li>
                        
                        <li class="category-item cat-assistencia" style="background-color: #8e44ad;">
                            <a href="<?php echo esc_url(home_url('/assistencia')); ?>">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                                <span>ASSISTÊNCIA</span>
                            </a>
                        </li>
                        
                        <li class="category-item cat-turismo" style="background-color: #2ecc71;">
                            <a href="<?php echo esc_url(home_url('/turismo')); ?>">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M14 6V4h-4v2h4zM4 8v11h16V8H4zm16-2c1.11 0 2 .89 2 2v11c0 1.11-.89 2-2 2H4c-1.11 0-2-.89-2-2l.01-11c0-1.11.89-2 2-2h4l2-2h4l2 2h4z"/>
                                </svg>
                                <span>TURISMO</span>
                            </a>
                        </li>
                    </ul>
                    
                    <!-- Aviso para configurar menu -->
                    <div class="menu-config-notice" style="background: rgba(255,255,255,0.1); padding: 10px; text-align: center; margin-top: 10px; border-radius: 4px;">
                        <p style="color: white; margin: 0; font-size: 12px;">
                            💡 <strong>Configure o Menu:</strong> Vá em <strong>Aparência > Menus</strong> e crie o "Menu de Categorias SESC" para ter submenus personalizados.
                        </p>
                    </div>
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
