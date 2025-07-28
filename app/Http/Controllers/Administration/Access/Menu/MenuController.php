<?php

namespace App\Http\Controllers\Administration\Access\Menu;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Administration\Access\Menu\MenuService;

class MenuController extends Controller
{
    public function __construct(MenuService $menuService) {

        $this->menuService = $menuService;

    }

    public function index(){

        return view('pages/administration/access-management/menu/menu');

    }

    public function getMenuAjax() {

        $menus = $this->menuService->getMenu();

        $menuTree = buildMenuTree($menus); 

        $data = [];
        $counter = 1;

        $this->flattenMenuTree($menuTree, $data, 0, $counter);

        return response()->json([
            'data' => $data
        ]);
    }

    private function flattenMenuTree($tree, &$data, $level = 0, &$counter = 1) {

        foreach ($tree as $item) {
            $menu = $item['menu'];

            $data[] = [
                'no' => $counter++,
                'name' => str_repeat('— ', $level) . $menu->name,
                'code' => $menu->code ?? '-',
                'route' => $menu->route ?? '-',
                'url' => $menu->url ?? '-',
                'icon' => $menu->icon ?? '-',
                'priority' => $menu->priority ?? '-',
                'action' => '<button class="btn btn-sm btn-primary rounded-circle d-inline-flex justify-content-center align-items-center"
                                    style="width: 40px; height: 40px;" title="Lihat">
                                    <i class="fa fa-eye"></i>
                            </button>',
            ];

            if (!empty($item['children'])) {

                uasort($item['children'], function ($a, $b) {
                    return $a['menu']->priority <=> $b['menu']->priority;
                });

                $this->flattenMenuTree($item['children'], $data, $level + 1, $counter);
            }
        }
    }
}
