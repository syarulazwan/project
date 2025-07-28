<?php

namespace App\Services\Administration\Access\Menu;
use App\Models\Menu;

class MenuService
{
    public function getMenu()
    {
        return Menu::orderBy('priority')->get(); 
    }

    // public function getMenuTree() {
        
    //     $menus = Menu::orderBy('priority')->get();

    //     $indexed = [];
    //     $tree = [];

    //     foreach ($menus as $menu) {
    //         $indexed[$menu->id] = ['menu' => $menu, 'children' => []];
    //     }

    //     foreach ($indexed as $id => &$item) {
    //         $menu = $item['menu'];

    //         if (is_null($menu->idp0)) {
    //             $tree[$id] = &$item;
    //         } elseif (!is_null($menu->idp0) && is_null($menu->idp1)) {
    //             $indexed[$menu->idp0]['children'][$id] = &$item;
    //         } elseif (!is_null($menu->idp1) && is_null($menu->idp2)) {
    //             $indexed[$menu->idp1]['children'][$id] = &$item;
    //         } elseif (!is_null($menu->idp2) && is_null($menu->idp3)) {
    //             $indexed[$menu->idp2]['children'][$id] = &$item;
    //         } elseif (!is_null($menu->idp3)) {
    //             $indexed[$menu->idp3]['children'][$id] = &$item;
    //         }
    //     }

    //     return $tree;
    // }

    public function getMenuTree()
    {
        $menus = Menu::orderBy('priority')->get();

        $tree = buildMenuTree($menus);

        return $tree;
    }


}
