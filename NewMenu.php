<?php
namespace App\Controller\Menu;
use App\Views\View;

class NeuMenu
{
    /**
     * Esse menu e defalt, quando n�o temos uma sess�o, ou voce pode tratar de forma como lhe for conveniente 
     * */
    private static $modulos = [
        'home' => [
            'label'=>'Inicio', 
            'link' => URL.'/'
        ],
        'sobre' => [
            'label'=>'Sobre n�s', 
            'link' => URL.'/sobre'
        ],
        'contato' => [
            'label'=>'Contato', 
            'link' => URL.'/contato'
        ]
    ];

    /**
     * Esse meunu ser� exibido se o usu�rio estiver logado
     * */    
    private static $dropModulos = [
        'home' => [
            'label'=>'Inicio', 
            'link' => URL.'/',
            'submenu'   => []
        ],
        'sobre' => [
            'label'=>'Sobre', 
            'link' => URL.'/sobre',
            'submenu'   => []
        ],
        'depoimentos' => [
            'label'   => 'Depoimentos', 
            'link'    => URL.'/depoimentos',
            'submenu'     => []
        ]
    ];

    private static $pathTo = 'path/to/';

    /**
     * o costruct pode ser utilizado para fazer algumas defini��es.
     * por exemplo, no caso de existir uma session voc� pode definir outros links
    */
    public function __construct() {
        self::$dropModulos['outros'] = [
            'label' => 'Saiba mais',
            'link'  => URL.'/outros',
            'submenu'   => 
            [
                [
                    "label" => "Descubra mais",
                    "link"  => URL.'/outros'
                ],
                [
                    "label" => "Results",
                    "link"  => URL.'/resultados'
                ],
                [
                    "label" => "Buscar",
                    "link"  => URL.'/seach'
                ]
            ]
        ];
    }


    /**
     * M�todo respons�vel por renderizar o menu e verificar sa h� existencia de sub-menu
     *
     * @param string $currentModel
     * @param array $menuItems
     * @param string $btn
     *
     * @return string
     */
    public static function renderMenu($currentModel, $menuItems, $btn) {
        $dropdownItems = '';
        $pathTo = self::$pathTo;

        foreach($menuItems as $model => $item) {
            $isActive = ($currentModel === $model);
            $hasDropdown = (!empty($item['submenu']));

            if ($hasDropdown) {
                $dropdownItems .= self::renderDropdownItem($item['label'], $item['submenu'], $isActive);
            } else {
                $dropdownItems .= self::renderLinkItem($item['label'], $item['link'], $isActive);
            }
        }

        return View::render("{$pathTo}/header", [
            'menu' => self::renderDropdown($dropdownItems),
            "btn" => $btn
        ]);
    }

    /**
     * Description
     *
     * @param string $label
     * @param string $link
     * @param string $isActive
     *
     * @return string
     */
    private static function renderLinkItem($label, $link, $isActive) {
        $activeClass = ($isActive) ? 'active' : '';
        $pathTo = self::$pathTo;

        return View::render("{$pathTo}/menu/sub/subitem", [
            "activeClass" => $activeClass ?? '',
            "link" => $link,
            "label"=> $label
        ]);
    }

    /**
     * Renderiza o sub-menu se houver n�veis de sub-menu
     *
     * @param string $label
     * @param string $submenu
     * @param string $isActive
     * 
     * @return string
     */
    private static function renderDropdownItem($label, $submenu, $isActive) {
        $activeClass = ($isActive) ? 'active' : '';
        $dropdownItems = '';
        $pathTo = self::$pathTo;

        foreach ($submenu as $item) {
            $dropdownItems .= self::renderLinkItem($item['label'], $item['link'], false);
        }

        return View::render("{$pathTo}/menu/sub/submenu", [
            "activeClass"=> $activeClass,
            "label" => $label,
            "dropdownItems" => $dropdownItems
        ]);
    }

    /**
     * M�todo respons�vel por retornar o menu renderizado j� com os links
     *
     * @param string $dropdownItens
     * @return mixed 
     */
    private static function renderDropdown($dropdownItems) {
        
        return View::render("{$pathTo}/menu/dropdown",[
            "dropdownItems" => $dropdownItems
        ]);
    }

    /**
     * @return mixed
     */
    public function getDropModulos() {
        return self::$dropModulos;
    }

    /**
     * @param mixed $dropModulos
     *
     * @return self
     */
    public function setDropModulos($dropModulos) {
        self::$dropModulos = $dropModulos;

        return self::$dropModulos;
    }

    /**
     * @return mixed
     */
    public function getModulos() {
        return self::$modulos;
    }

    /**
     * @param mixed $modulos
     *
     * @return self
     */
    public function setModulos($modulos) {
        self::$modulos = $modulos;

        return self::$modulos;
    }
}