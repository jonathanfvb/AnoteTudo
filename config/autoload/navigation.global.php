<?php
return array(
        // All navigation-related configuration is collected in the 'navigation' key
        'navigation' => array(
                // The DefaultNavigationFactory we configured in (1) uses 'default' as the sitemap key
                'default' => array(
                        // And finally, here is where we define our page hierarchy
                        'home'		=> array(
                                'label'		=> 'Início',
                                'route' 	=> 'home',
                                'module' 	=> 'home',
                        ),
                        'comercial' => array(                                
                                'label' 	=> 'Comercial',
                                'route' 	=> 'comercial-home',
                                'module' 	=> 'comercial',
                                'pages' 	=> array(
                                        'prospect' => array(
                                                'label' 	 => 'Prospect',
                                                'route' 	 => 'comercial',
                                                'module' 	 => 'comercial',
                                                'controller' => 'prospect',
                                        ),
                                        'orcamento' => array(
                                                'label' 	 => 'Orçamentos',
                                                'route' 	 => 'comercial',
                                                'module' 	 => 'comercial',
                                                'controller' => 'orcamento',
                                                'pages'		 => array(
                                                        'ganhos'	=> array(
                                                                'label' 	 => 'Ganhos',
                                                                'route' 	 => 'comercial',
                                                                'module' 	 => 'comercial',
                                                                'controller' => 'orcamento',
                                                                'action'	 => 'orcamentos-ganhos'
                                                        ),
                                                        'perdidos'	=> array(
                                                                'label' 	 => 'Perdidos',
                                                                'route' 	 => 'comercial',
                                                                'module' 	 => 'comercial',
                                                                'controller' => 'orcamento',
                                                                'action'	 => 'orcamentos-perdidos'
                                                        ),
                                                        'entregues'	=> array(
                                                                'label' 	 => 'Entregues',
                                                                'route' 	 => 'comercial',
                                                                'module' 	 => 'comercial',
                                                                'controller' => 'orcamento',
                                                                'action'	 => 'orcamentos-entregues'
                                                        ),
                                                        'andamento'	=> array(
                                                                'label' 	 => 'Novos e Em Curso',
                                                                'route' 	 => 'comercial',
                                                                'module' 	 => 'comercial',
                                                                'controller' => 'orcamento',
                                                                'action'	 => 'orcamentos-andamento'
                                                        ),
                                                        'todos'		=> array(
                                                                'label' 	 => 'Ver Todos',
                                                                'route' 	 => 'comercial',
                                                                'module' 	 => 'comercial',
                                                                'controller' => 'orcamento',
                                                                'action'	 => 'index'
                                                        ),
                                                )
                                        )
                                ),
                        ),
                        array (
                                'label' => 'Orçamento',
                                'uri'	=> '#',
                                'pages' => array(
                                        array(
                                                'uri' => '#'
                                        ),
                                )
                        ),
                        array (
                                'label' 	=> 'Engenharia',
                                'route' 	=> 'engenharia-home',
                                'module' 	=> 'obra',
                                'pages' => array(
                                        'prospect' => array(
                                                'label' 	 => 'Obras',
                                                'route' 	 => 'engenharia',
                                                'controller' => 'obra',
                                        ),
                                        'requisicao' => array(
                                                'label' 	 => 'Requisição',
                                                'route' 	 => 'engenharia',
                                                'controller' => 'requisicao',
                                        ),
                                )
                        ),
                        array (
                                'label' => 'Suprimento',
                                'uri'	=> '#',
                                'pages' => array(
                                        array(
                                                'uri' => '#'
                                        ),
                                )
                        ),
                        array (
                                'label' => 'Financeiro',
                                'uri'	=> '#',
                                'pages' => array(
                                        array(
                                                'uri' => '#'
                                        ),
                                )
                        ),
                        array (
                                'label' => 'Kross',
                                'uri'	=> '#',
                                'pages' => array(
                                        array(
                                                'uri' => '#'
                                        ),
                                )
                        ),                        
                ),
        ),
);