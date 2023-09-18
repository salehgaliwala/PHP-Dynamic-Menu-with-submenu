<?php
namespace App\Controller\Menu;
use App\Views\View;

class NeuMenu
{
    /**
     * Esse menu e defalt, quando não temos uma sessão, ou voce pode tratar de forma como lhe for conveniente 
     * */
    private static $modulos = [
        'home' => [
            'label'=>'Inicio', 
            'link' => URL.'/'
        ],
        'sobre' => [
            'label'=>'Sobre nós', 
            'link' => URL.'/sobre'
        ],
        'contato' => [
            'label'=>'Contato', 
            'link' => URL.'/contato'
        ]
    ];

    /**
     * Esse meunu será exibido se o usuário estiver logado
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
     * o costruct pode ser utilizado para fazer algumas definições.
     * por exemplo, no caso de existir uma session você pode definir outros links
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
     * Método responsável por renderizar o menu e verificar sa há existencia de sub-menu
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
     * Renderiza o sub-menu se houver níveis de sub-menu
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
     * Método responsável por retornar o menu renderizado já com os links
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