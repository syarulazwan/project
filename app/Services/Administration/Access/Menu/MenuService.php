<?php

namespace App\Services\Administration\Access\Menu;
use App\Models\Menu;
use Illuminate\Support\Facades\Session;

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

    public function CreateMenu($data)
    {
        // pr($data);
        $createdId = Session::get('role_id');


        $idp0 = 0;
        $idp1 = 0;
        $idp2 = 0;
        $idp3 = 0;

        if ($data['parent_id'] != 0) {
            $parent = Menu::find($data['parent_id']);

            if ($parent) {

                $idp0 = $parent->idp0 ?? 0;
                $idp1 = $parent->idp1 ?? 0;
                $idp2 = $parent->idp2 ?? 0;

                if ($idp0 == 0) {
                    $idp0 = $parent->id;
                } elseif ($idp1 == 0) {
                    $idp1 = $parent->id;
                } elseif ($idp2 == 0) {
                    $idp2 = $parent->id;
                } else {
                    $idp3 = $parent->id;
                }
            }
        }

        $menu = Menu::create([
            'name'       => $data['name'],
            'code'       => $data['code'],
            'url'        => $data['url'],
            'route'      => $data['route'],
            'icon'       => $data['icon'],
            'priority'   => $data['priority'],
            'idp0'       => $idp0,
            'idp1'       => $idp1,
            'idp2'       => $idp2,
            'idp3'       => $idp3,
            'created_id' => $createdId,
        ]);

        return $menu;
    }



}
