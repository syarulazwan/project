<?php

if (!function_exists('pr')) {
    function pr($data)
    {
        echo '<pre>';

        if (is_object($data) && method_exists($data, 'all')) {
            print_r([
                'data' => $data->all(),
                'files' => $data->allFiles(),
            ]);
        } else {
            print_r($data);
        }

        echo '</pre>';
        dd();
    }
}

if (!function_exists('mpr')) {
    function mpr($data)
    {
        echo '<pre>';

        if (is_object($data) && method_exists($data, 'all')) {
            print_r([
                'data' => $data->all(),
                'files' => $data->allFiles(),
            ]);
        } else {
            print_r($data);
        }

        echo '</pre>';
        // tak die
    }
}


if (!function_exists('buildMenuTree')) {
    function buildMenuTree($menus)
    {
        $indexed = [];
        $tree = [];

        // Index all menus by id for easy access
        foreach ($menus as $menu) {
            $indexed[$menu->id] = ['menu' => $menu, 'children' => []];
        }

        foreach ($indexed as $id => &$item) {
            $menu = $item['menu'];

            if (is_null($menu->idp0)) {
                // Level 1 - root
                $tree[$id] = &$item;
            } elseif (!is_null($menu->idp0) && is_null($menu->idp1)) {
                // Level 2
                $indexed[$menu->idp0]['children'][$id] = &$item;
            } elseif (!is_null($menu->idp1) && is_null($menu->idp2)) {
                // Level 3
                $indexed[$menu->idp1]['children'][$id] = &$item;
            } elseif (!is_null($menu->idp2) && is_null($menu->idp3)) {
                // Level 4
                $indexed[$menu->idp2]['children'][$id] = &$item;
            } elseif (!is_null($menu->idp3)) {
                // Level 5
                $indexed[$menu->idp3]['children'][$id] = &$item;
            }
        }

        return $tree;
    }
}




