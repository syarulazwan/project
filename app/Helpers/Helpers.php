<?php
use Carbon\Carbon;
use App\Models\AccessLog;
use App\Models\GeneralLog;

if (!function_exists('pr')) {
    function pr($data)
    {
        echo '<pre>';

        if ($data instanceof \Illuminate\Database\Eloquent\Model) {
            print_r($data->toArray()); // safer untuk lihat attributes + relations
        }

        elseif ($data instanceof \Illuminate\Database\Eloquent\Collection) {
            print_r($data->toArray());
        }

        elseif ($data instanceof \Illuminate\Http\Request) {
            print_r([
                'data' => $data->all(),
                'files' => $data->allFiles(),
            ]);
        }

        elseif (is_iterable($data) && !empty($data) && is_object(current($data))) {
            $output = array_map(function ($item) {
                return (array) $item;
            }, (array) $data);

            print_r($output);
        }

        elseif (is_object($data)) {
            print_r((array) $data);
        }

        else {
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


// if (!function_exists('buildMenuTree')) {
//     function buildMenuTree($menus)
//     {
//         $indexed = [];
//         $tree = [];

//         // Index all menus by id for easy access
//         foreach ($menus as $menu) {
//             $indexed[$menu->id] = ['menu' => $menu, 'children' => []];
//         }

//         foreach ($indexed as $id => &$item) {
//             $menu = $item['menu'] ?? [];

//             if (is_null($menu->idp0)) {
//                 // Level 1 - root
//                 $tree[$id] = &$item;
//             } elseif (!is_null($menu->idp0) && is_null($menu->idp1)) {
//                 // Level 2
//                 $indexed[$menu->idp0]['children'][$id] = &$item;
//             } elseif (!is_null($menu->idp1) && is_null($menu->idp2)) {
//                 // Level 3
//                 $indexed[$menu->idp1]['children'][$id] = &$item;
//             } elseif (!is_null($menu->idp2) && is_null($menu->idp3)) {
//                 // Level 4
//                 $indexed[$menu->idp2]['children'][$id] = &$item;
//             } elseif (!is_null($menu->idp3)) {
//                 // Level 5
//                 $indexed[$menu->idp3]['children'][$id] = &$item;
//             }
//         }

//         return $tree;
//     }
// }

if (!function_exists('buildMenuTree')) {
    function buildMenuTree($menus)
    {
        $indexed = [];
        $tree = [];

        foreach ($menus as $menu) {
            $indexed[$menu->id] = ['menu' => $menu, 'children' => []];
        }

        foreach ($indexed as $id => &$item) {
            $menu = $item['menu'];

            if (empty($menu->idp0)) {
                $tree[$id] = &$item;
            } elseif (!empty($menu->idp0) && empty($menu->idp1)) {
                $indexed[$menu->idp0]['children'][$id] = &$item;
            } elseif (!empty($menu->idp1) && empty($menu->idp2)) {
                $indexed[$menu->idp1]['children'][$id] = &$item;
            } elseif (!empty($menu->idp2) && empty($menu->idp3)) {
                $indexed[$menu->idp2]['children'][$id] = &$item;
            } elseif (!empty($menu->idp3)) {
                $indexed[$menu->idp3]['children'][$id] = &$item;
            }
        }

        return $tree;
    }
}

if (!function_exists('filterMenuTree')) {
    function filterMenuTree($menuTree, $allowedMenuIds)
    {
        $filtered = [];

        foreach ($menuTree as $item) {
            $menu = $item['menu'] ?? null;

            if (!$menu || !in_array($menu->id, $allowedMenuIds)) {
                continue;
            }

            $children = $item['children'] ?? [];
            $filteredChildren = filterMenuTree($children, $allowedMenuIds);

            $filtered[] = [
                'menu' => $menu,
                'children' => $filteredChildren
            ];
        }

        return $filtered;
    }
}

if (!function_exists('format_date')) {
    function format_date($date, $format = 'd-m-Y H:i:s', $fallback = '-')
    {
        try {
            if (empty($date)) {
                return $fallback;
            }

            if ($date instanceof Carbon) {
                return $date->format($format);
            }

            return Carbon::parse($date)->format($format);

        } catch (\Exception $e) {
            return $fallback;
        }
    }
}


function log_access($action = 'login', $userId = null)
{
    $userId = $userId ?? auth()->id();

    if ($action === 'login') {
        AccessLog::create([
            'user_id'    => $userId,
            'role_id'    => optional(auth()->user())->role_id,
            'action'     => 'login',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'login_at'   => now(),
        ]);
    }

    if ($action === 'logout') {
        $latest = AccessLog::where('user_id', $userId)
            ->where('action', 'login')
            ->whereNull('logout_at')
            ->latest()
            ->first();

        if ($latest) {
            $latest->update([
                'logout_at' => now(),
            ]);
        } else {
            AccessLog::create([
                'user_id'    => $userId,
                'role_id'    => optional(auth()->user())->role_id,
                'action'     => 'logout',
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'logout_at'  => now(),
            ]);
        }
    }
}



if (!function_exists('log_general')) {
    function log_general($type, $model, $before = null, $after = null)
    {
        GeneralLog::create([
            'log_type'    => $type,
            'model_type'  => get_class($model),
            'model_id'    => $model->id,
            'before'      => $before ? json_encode($before) : null,
            'after'       => $after ? json_encode($after) : null,
            'user_id'     => auth()->id(),
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
        ]);
    }
}






