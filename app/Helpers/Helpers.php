<?php
use Carbon\Carbon;
use App\Models\User;
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

if (!function_exists('buildMenuTree')) {
    function buildMenuTree($menus)
    {
        $indexed = [];
        $tree = [];

        // Step 1: Index semua menu by ID
        foreach ($menus as $menu) {
            $indexed[$menu->id] = ['menu' => $menu, 'children' => []];
        }

        // Step 2: Buang menu yang parent dia tak wujud
        foreach ($indexed as $id => $item) {
            $menu = $item['menu'];
            $valid = true;

            if (!empty($menu->idp0) && !isset($indexed[$menu->idp0])) {
                $valid = false;
            } elseif (!empty($menu->idp1) && !isset($indexed[$menu->idp1])) {
                $valid = false;
            } elseif (!empty($menu->idp2) && !isset($indexed[$menu->idp2])) {
                $valid = false;
            } elseif (!empty($menu->idp3) && !isset($indexed[$menu->idp3])) {
                $valid = false;
            }

            if (!$valid) {
                unset($indexed[$id]);
            }
        }

        // Step 3: Bina tree
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

if (! function_exists('get_user_creator')) {
    function get_user_creator($userId) {
        $user = User::find($userId);
        return $user ? $user->name : '-';
    }
}

if (! function_exists('collect_log')) {
    function collect_log(array $log)
    {
        $logs = app()->bound('log_collector') ? app('log_collector') : [];
        $logs[] = $log;
        app()->instance('log_collector', $logs);
    }
}

if (! function_exists('flush_log')) {
    function flush_log()
    {
        $logs = app()->bound('log_collector') ? app('log_collector') : [];

        foreach ($logs as $log) {
            \App\Models\GeneralLog::create($log);
        }

        app()->forgetInstance('log_collector');
    }
}

if (! function_exists('get_companies')) {
    function get_companies()
    {
        return \App\Models\Company::all();
    }
}

if (! function_exists('get_branch')) {
    function get_branch()
    {
        return \App\Models\Branch::all();
    }
}

if (! function_exists('get_department')) {
    function get_department()
    {
        return \App\Models\Department::all();
    }
}

if (! function_exists('get_unit')) {
    function get_unit()
    {
        return \App\Models\Unit::all();
    }
}

if (! function_exists('get_job_grade')) {
    function get_job_grade()
    {
        return \App\Models\JobGrade::all();
    }
}

if (! function_exists('get_designation')) {
    function get_designation()
    {
        return \App\Models\Designation::all();
    }
}









