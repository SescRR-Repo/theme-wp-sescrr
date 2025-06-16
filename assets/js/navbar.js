/**
 * SESC RR - JavaScript do Navbar - VERSÃO CORRIGIDA
 * navbar.js - Funcionalidades completas com dropdown funcional
 */

(function($) {
    'use strict';

    // Variáveis globais
    let searchTimeout;
    let isSearching = false;
    let lastScrollY = 0;

    // Inicializar quando o DOM estiver pronto
    $(document).ready(function() {
        initNavbar();
    });

    /**
     * Inicializar todas as funcionalidades do navbar
     */
    function initNavbar() {
        initMobileMenu();
        initServicesDropdown();
        initCategoryDropdowns(); // NOVA FUNÇÃO PRINCIPAL
        initSearch();
        initStickyHeader();
        initAccessibility();
        initScrollEffects();
        initPerformanceOptimizations();
        initMobileAccordion(); // ACCORDION MOBILE
        
        console.log('SESC RR Navbar inicializado com sucesso!');
    }

    /**
     * DROPDOWN DE CATEGORIAS - PRINCIPAL CORREÇÃO
     */
    function initCategoryDropdowns() {
        console.log('Inicializando dropdowns de categoria...');
        
        // Selecionar todos os itens de categoria que têm submenu
        const $categoryItems = $('.category-item.menu-item-has-children, .category-item:has(.sub-menu)');
        
        console.log('Encontrados', $categoryItems.length, 'itens com submenu');
        
        $categoryItems.each(function() {
            const $item = $(this);
            const $submenu = $item.find('.sub-menu');
            let hoverTimeout;

            console.log('Configurando item:', $item.find('> a').text().trim());
            
            // Garantir que o submenu existe
            if ($submenu.length === 0) {
                console.log('Submenu não encontrado para:', $item.find('> a').text().trim());
                return;
            }

            // Mouse enter no item principal
            $item.on('mouseenter', function() {
                console.log('Mouse enter em:', $item.find('> a').text().trim());
                clearTimeout(hoverTimeout);
                
                // Esconder outros submenus
                $('.category-item .sub-menu').not($submenu).css({
                    'opacity': '0',
                    'visibility': 'hidden',
                    'transform': 'translateY(-10px)'
                });
                
                // Mostrar este submenu
                $submenu.css({
                    'opacity': '1',
                    'visibility': 'visible',
                    'transform': 'translateY(0)'
                });
            });

            // Mouse leave do item principal
            $item.on('mouseleave', function() {
                console.log('Mouse leave em:', $item.find('> a').text().trim());
                hoverTimeout = setTimeout(() => {
                    $submenu.css({
                        'opacity': '0',
                        'visibility': 'hidden',
                        'transform': 'translateY(-10px)'
                    });
                }, 200); // Delay para permitir movimento do mouse
            });

            // Mouse enter no submenu (manter visível)
            $submenu.on('mouseenter', function() {
                console.log('Mouse enter no submenu');
                clearTimeout(hoverTimeout);
            });

            // Mouse leave do submenu
            $submenu.on('mouseleave', function() {
                console.log('Mouse leave no submenu');
                hoverTimeout = setTimeout(() => {
                    $submenu.css({
                        'opacity': '0',
                        'visibility': 'hidden',
                        'transform': 'translateY(-10px)'
                    });
                }, 100);
            });

            // Navegação por teclado
            $item.find('> a').on('keydown', function(e) {
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    $submenu.css({
                        'opacity': '1',
                        'visibility': 'visible',
                        'transform': 'translateY(0)'
                    });
                    $submenu.find('a').first().focus();
                }
            });

            // Navegação dentro do submenu
            $submenu.find('a').on('keydown', function(e) {
                const $links = $submenu.find('a');
                const currentIndex = $links.index(this);
                
                switch(e.key) {
                    case 'ArrowDown':
                        e.preventDefault();
                        if (currentIndex < $links.length - 1) {
                            $links.eq(currentIndex + 1).focus();
                        }
                        break;
                    case 'ArrowUp':
                        e.preventDefault();
                        if (currentIndex > 0) {
                            $links.eq(currentIndex - 1).focus();
                        } else {
                            $item.find('> a').focus();
                            $submenu.css({
                                'opacity': '0',
                                'visibility': 'hidden',
                                'transform': 'translateY(-10px)'
                            });
                        }
                        break;
                    case 'Escape':
                        e.preventDefault();
                        $item.find('> a').focus();
                        $submenu.css({
                            'opacity': '0',
                            'visibility': 'hidden',
                            'transform': 'translateY(-10px)'
                        });
                        break;
                }
            });
        });

        // Fechar todos os dropdowns ao clicar fora
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.category-item').length) {
                $('.category-item .sub-menu').css({
                    'opacity': '0',
                    'visibility': 'hidden',
                    'transform': 'translateY(-10px)'
                });
            }
        });
    }

    /**
     * MENU MOBILE
     */
    function initMobileMenu() {
        const $mobileToggle = $('.mobile-toggle');
        const $mobileMenu = $('.mobile-menu');
        const $mobileOverlay = $('.mobile-overlay');
        const $mobileClose = $('.mobile-close');
        const $body = $('body');

        // Abrir menu mobile
        $mobileToggle.on('click', function(e) {
            e.preventDefault();
            openMobileMenu();
        });

        // Fechar menu mobile
        $mobileClose.on('click', closeMobileMenu);
        $mobileOverlay.on('click', closeMobileMenu);

        // Fechar com ESC
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && $mobileMenu.hasClass('open')) {
                closeMobileMenu();
            }
        });

        // Fechar ao clicar em links (exceto se tiver submenu)
        $('.mobile-category-list a').on('click', function(e) {
            const $parent = $(this).parent();
            if (!$parent.hasClass('menu-item-has-children')) {
                setTimeout(closeMobileMenu, 100);
            }
        });

        // Fechar ao redimensionar para desktop
        $(window).on('resize', debounce(function() {
            if ($(window).width() > 768) {
                closeMobileMenu();
            }
        }, 250));

        function openMobileMenu() {
            $mobileMenu.addClass('open opening').removeClass('closing');
            $mobileOverlay.addClass('show');
            $mobileToggle.attr('aria-expanded', 'true');
            $body.addClass('menu-open').css('overflow', 'hidden');
            
            // Focar no primeiro item do menu
            setTimeout(() => {
                $mobileMenu.find('a, button').first().focus();
            }, 100);

            // Remover classe de animação
            setTimeout(() => {
                $mobileMenu.removeClass('opening');
            }, 300);
        }

        function closeMobileMenu() {
            $mobileMenu.addClass('closing').removeClass('opening');
            $mobileOverlay.removeClass('show');
            $mobileToggle.attr('aria-expanded', 'false');
            $body.removeClass('menu-open').css('overflow', '');

            setTimeout(() => {
                $mobileMenu.removeClass('open closing');
            }, 300);

            // Retornar foco para o botão
            $mobileToggle.focus();
        }
    }

    /**
     * ACCORDION MOBILE PARA CATEGORIAS
     */
    function initMobileAccordion() {
        $('.mobile-category-list .menu-item-has-children > a').on('click', function(e) {
            e.preventDefault();
            
            const $item = $(this).parent();
            const $submenu = $item.find('.sub-menu');
            
            console.log('Clique no accordion mobile:', $(this).text().trim());
            
            // Toggle classe open
            $item.toggleClass('open');
            
            // Fechar outros itens
            $item.siblings('.menu-item-has-children').removeClass('open');
            
            // Log do estado
            console.log('Item agora está:', $item.hasClass('open') ? 'aberto' : 'fechado');
        });
    }

    /**
     * DROPDOWN DE SERVIÇOS
     */
    function initServicesDropdown() {
        const $dropdown = $('.services-dropdown');
        const $button = $('.btn-services');
        const $menu = $('.services-menu');
        let isOpen = false;
        let hoverTimeout;

        // Hover events
        $dropdown.on('mouseenter', function() {
            clearTimeout(hoverTimeout);
            openServicesDropdown();
        });

        $dropdown.on('mouseleave', function() {
            hoverTimeout = setTimeout(() => {
                closeServicesDropdown();
            }, 200);
        });

        // Click events
        $button.on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            if (isOpen) {
                closeServicesDropdown();
            } else {
                openServicesDropdown();
            }
        });

        // Fechar ao clicar fora
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.services-dropdown').length && isOpen) {
                closeServicesDropdown();
            }
        });

        // Navegação por teclado
        $dropdown.on('keydown', function(e) {
            if (!isOpen) return;

            const $items = $menu.find('a');
            const $current = $items.filter(':focus');
            const currentIndex = $items.index($current);

            switch(e.key) {
                case 'ArrowDown':
                    e.preventDefault();
                    if (currentIndex < $items.length - 1) {
                        $items.eq(currentIndex + 1).focus();
                    } else {
                        $items.first().focus();
                    }
                    break;

                case 'ArrowUp':
                    e.preventDefault();
                    if (currentIndex > 0) {
                        $items.eq(currentIndex - 1).focus();
                    } else {
                        $items.last().focus();
                    }
                    break;

                case 'Escape':
                    e.preventDefault();
                    closeServicesDropdown();
                    $button.focus();
                    break;

                case 'Tab':
                    if (e.shiftKey && currentIndex === 0) {
                        closeServicesDropdown();
                    } else if (!e.shiftKey && currentIndex === $items.length - 1) {
                        closeServicesDropdown();
                    }
                    break;
            }
        });

        function openServicesDropdown() {
            $menu.css({
                'opacity': '1',
                'visibility': 'visible',
                'transform': 'translateY(0)'
            });
            $button.attr('aria-expanded', 'true');
            $dropdown.attr('aria-expanded', 'true');
            isOpen = true;

            // Focar no primeiro item
            setTimeout(() => {
                $menu.find('a').first().focus();
            }, 100);
        }

        function closeServicesDropdown() {
            $menu.css({
                'opacity': '0',
                'visibility': 'hidden',
                'transform': 'translateY(-10px)'
            });
            $button.attr('aria-expanded', 'false');
            $dropdown.attr('aria-expanded', 'false');
            isOpen = false;
        }
    }

    /**
     * SISTEMA DE BUSCA
     */
    function initSearch() {
        const $searchForm = $('.sesc-search-form');
        const $searchInput = $('.search-input');
        const $searchButton = $('.search-button');
        const $searchResults = $('.search-results');
        const $mobileSearchForm = $('.mobile-search-form');
        const $mobileSearchInput = $('.mobile-search-form input');

        // Busca em tempo real
        $searchInput.on('input', debounce(function() {
            const query = $(this).val().trim();
            
            if (query.length >= 3) {
                performSearch(query);
            } else {
                hideSearchResults();
            }
        }, 300));

        // Busca mobile
        $mobileSearchInput.on('input', debounce(function() {
            const query = $(this).val().trim();
            if (query.length >= 3) {
                // Sincronizar com busca desktop
                $searchInput.val(query);
                performSearch(query);
            }
        }, 300));

        // Submeter formulário
        $searchForm.on('submit', function(e) {
            const query = $searchInput.val().trim();
            if (query.length < 2) {
                e.preventDefault();
                showNotification('Digite pelo menos 2 caracteres para buscar', 'warning');
                return;
            }
            
            // Adicionar classe de loading
            $searchForm.addClass('loading');
        });

        $mobileSearchForm.on('submit', function(e) {
            const query = $mobileSearchInput.val().trim();
            if (query.length < 2) {
                e.preventDefault();
                showNotification('Digite pelo menos 2 caracteres para buscar', 'warning');
                return;
            }
        });

        // Fechar resultados ao clicar fora
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.navbar-search').length) {
                hideSearchResults();
            }
        });

        // Navegação por teclado nos resultados
        $searchInput.on('keydown', function(e) {
            const $results = $searchResults.find('.result-item');
            const $focused = $results.filter(':focus');
            const currentIndex = $results.index($focused);

            switch(e.key) {
                case 'ArrowDown':
                    e.preventDefault();
                    if ($results.length > 0) {
                        if (currentIndex < 0) {
                            $results.first().focus();
                        } else if (currentIndex < $results.length - 1) {
                            $results.eq(currentIndex + 1).focus();
                        }
                    }
                    break;

                case 'ArrowUp':
                    e.preventDefault();
                    if (currentIndex > 0) {
                        $results.eq(currentIndex - 1).focus();
                    } else if (currentIndex === 0) {
                        $searchInput.focus();
                    }
                    break;

                case 'Escape':
                    hideSearchResults();
                    break;
            }
        });

        /**
         * Realizar busca AJAX
         */
        function performSearch(query) {
            if (isSearching) return;

            isSearching = true;
            $searchForm.addClass('loading');

            // AJAX real 
            $.ajax({
                url: sescAjax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'sesc_search',
                    query: query,
                    nonce: sescAjax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        displaySearchResults(response.data);
                    } else {
                        // Fallback para resultados mock
                        const mockResults = generateMockResults(query);
                        displaySearchResults(mockResults);
                    }
                },
                error: function() {
                    // Fallback para resultados mock em caso de erro
                    const mockResults = generateMockResults(query);
                    displaySearchResults(mockResults);
                },
                complete: function() {
                    isSearching = false;
                    $searchForm.removeClass('loading');
                }
            });
        }

        /**
         * Exibir resultados da busca
         */
        function displaySearchResults(results) {
            if (!results || results.length === 0) {
                $searchResults.html('<div class="no-results" style="padding: 20px; text-align: center; color: #666;">Nenhum resultado encontrado.</div>');
            } else {
                let html = '';
                results.forEach(result => {
                    html += `
                        <a href="${result.url}" class="result-item" tabindex="0">
                            ${result.thumbnail ? `<img src="${result.thumbnail}" alt="">` : ''}
                            <div class="result-content">
                                <h4>${result.title}</h4>
                                <p>${result.excerpt}</p>
                            </div>
                        </a>
                    `;
                });
                $searchResults.html(html);
            }
            
            $searchResults.addClass('show');
        }

        /**
         * Esconder resultados da busca
         */
        function hideSearchResults() {
            $searchResults.removeClass('show');
        }

        /**
         * Gerar resultados mock para demonstração
         */
        function generateMockResults(query) {
            const mockData = [
                {
                    title: 'Atividades de Educação',
                    excerpt: 'Cursos e atividades educacionais do SESC RR',
                    url: '/educacao',
                    thumbnail: null
                },
                {
                    title: 'Esportes e Lazer',
                    excerpt: 'Atividades esportivas e de lazer para toda família',
                    url: '/esporte',
                    thumbnail: null
                },
                {
                    title: 'Saúde e Bem-estar',
                    excerpt: 'Serviços de saúde e programas de bem-estar',
                    url: '/saude',
                    thumbnail: null
                },
                {
                    title: 'Cultura e Arte',
                    excerpt: 'Eventos culturais e exposições artísticas',
                    url: '/cultura',
                    thumbnail: null
                },
                {
                    title: 'Assistência Social',
                    excerpt: 'Serviços de assistência e orientação',
                    url: '/assistencia',
                    thumbnail: null
                },
                {
                    title: 'Turismo SESC',
                    excerpt: 'Pacotes e destinos turísticos SESC',
                    url: '/turismo',
                    thumbnail: null
                }
            ];

            return mockData.filter(item => 
                item.title.toLowerCase().includes(query.toLowerCase()) ||
                item.excerpt.toLowerCase().includes(query.toLowerCase())
            );
        }
    }

    /**
     * HEADER STICKY
     */
    function initStickyHeader() {
        const $header = $('.site-header');
        const $utilityBar = $('.sesc-utility-bar');
        
        $(window).on('scroll', throttle(function() {
            const scrollY = window.pageYOffset;
            
            // Esconder/mostrar utility bar
            if (scrollY > 100) {
                $utilityBar.addClass('hidden');
                $header.addClass('scrolled');
            } else {
                $utilityBar.removeClass('hidden');
                $header.removeClass('scrolled');
            }
            
            lastScrollY = scrollY;
        }, 16)); // ~60fps
    }

    /**
     * EFEITOS DE SCROLL
     */
    function initScrollEffects() {
        // Parallax suave nos elementos do navbar
        $(window).on('scroll', throttle(function() {
            const scrollY = window.pageYOffset;
            const $locationBadge = $('.location-badge');
            
            // Efeito parallax no badge
            if ($locationBadge.length) {
                $locationBadge.css('transform', `translateY(${scrollY * 0.1}px)`);
            }
        }, 16));
    }

    /**
     * ACESSIBILIDADE
     */
    function initAccessibility() {
        // Skip links
        $('<a href="#main" class="skip-link sr-only">Pular para o conteúdo principal</a>')
            .prependTo('body')
            .on('focus', function() {
                $(this).removeClass('sr-only');
            })
            .on('blur', function() {
                $(this).addClass('sr-only');
            });

        // Anunciar mudanças para screen readers
        const $announcer = $('<div aria-live="polite" aria-atomic="true" class="sr-only"></div>')
            .appendTo('body');

        window.announceToScreenReader = function(message) {
            $announcer.text(message);
            setTimeout(() => $announcer.empty(), 1000);
        };

        // Melhorar navegação por teclado
        $('a, button', '.site-header').on('focus', function() {
            $(this).addClass('keyboard-focused');
        }).on('blur', function() {
            $(this).removeClass('keyboard-focused');
        });
    }

    /**
     * OTIMIZAÇÕES DE PERFORMANCE
     */
    function initPerformanceOptimizations() {
        // Lazy load de elementos não críticos
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in-view');
                    }
                });
            });

            $('.category-item').each(function() {
                observer.observe(this);
            });
        }

        // Preload de páginas importantes
        $('a[href^="' + window.location.origin + '"]').on('mouseenter', debounce(function() {
            const href = $(this).attr('href');
            if (href && !$('link[rel="prefetch"][href="' + href + '"]').length) {
                $('<link rel="prefetch" href="' + href + '">').appendTo('head');
            }
        }, 100));
    }

    /**
     * SISTEMA DE NOTIFICAÇÕES
     */
    function showNotification(message, type = 'info') {
        const $notification = $(`
            <div class="sesc-notification ${type}" role="alert" aria-live="assertive">
                <span class="notification-message">${message}</span>
                <button class="notification-close" aria-label="Fechar notificação">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                    </svg>
                </button>
            </div>
        `);

        $('body').append($notification);

        // Animar entrada
        setTimeout(() => $notification.addClass('show'), 100);

        // Auto remover
        setTimeout(() => {
            $notification.removeClass('show');
            setTimeout(() => $notification.remove(), 300);
        }, 5000);

        // Fechar manualmente
        $notification.find('.notification-close').on('click', function() {
            $notification.removeClass('show');
            setTimeout(() => $notification.remove(), 300);
        });
    }

    /**
     * UTILITÁRIOS
     */
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    function throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }

    // Expor funcionalidades globalmente se necessário
    window.SescNavbar = {
        showNotification: showNotification,
        announceToScreenReader: window.announceToScreenReader
    };

})(jQuery);