<?php

namespace App\Http\Controllers\Administration\Access\Menu;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Administration\Access\Menu\MenuService;
use App\Http\Requests\Administration\Access\Menu\MenuRequest;

class MenuController extends Controller
{
    public function __construct(MenuService $menuService) {

        $this->menuService = $menuService;

    }

    public function index()
    {
        $menus = Menu::orderBy('priority')->get();
        $tree = buildMenuTree($menus);

        $data = [
            'tree' => $tree, 
            'menus' => $menus 
        ];

        return view('pages/administration/access-management/menu/menu', $data);
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

   public function store(MenuRequest $request)
    {
        $data = $request->validated();
        $data['route'] = $request->input('route', null);
        $data['parent_id'] = $request->input('parent_id', 0); 

        DB::beginTransaction();

        try {
            $create = $this->menuService->CreateMenu($data);

            DB::commit();

            return response()->json(['message' => 'Menu created successfully!'], 200);

        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Menu creation failed: ' . $e->getMessage());

            return response()->json(['message' => 'Menu creation failed.'], 500);
        }
    }

}
