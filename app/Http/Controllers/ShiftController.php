<?php

namespace App\Http\Controllers;

use App\Http\Resources\MyShift as MyShiftResource;
use App\Http\Resources\Shift as ShiftResource;
use App\Http\Resources\ShiftroleInfo as ShiftroleInfoResource;
use App\Models\Shift;
use App\Models\Shiftrole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ShiftController extends Controller
{
    public function index($day)
    {
        $auth_user_id = auth()->user()->id;

        $shifts = Shift::with('shiftroles', 'help_category')
            ->where('orga', false)
            ->where('day', $day)
            ->get()->sortBy('time');

        $data = [];
        $users = User::with('Shifts')->get();
        foreach ($shifts as $shift) {
            $entry = [];
            $entry['id'] = $shift->id;
            $entry['name'] = $shift->name;
            $entry['description'] = $shift->description;
            $entry['duration'] = $shift->duration;
            $entry['time'] = $shift->time;
            $entry['category'] = $shift->help_category->name;

            $user_shiftrole = [];
            foreach ($users as $user) {
                foreach ($user->shifts as $item) {
                    $i = [];
                    $i['id'] = $user->id;
                    $i['name'] = $user->name;
                    $user_shiftrole[$item->id][$item->pivot->shiftrole_id][] = $i;
                }
            }

            foreach ($shift->shiftroles as $shiftrole) {
                $status = 'open';
                $role_shift_users = [];

                $allowed = $shiftrole->pivot->count;
                $found = 0;
                foreach (auth()->user()->shifts as $myshift) {
                    if ($myshift->day == $shift->day && $myshift->time == $shift->time) {
                        $status = 'full';
                    }
                }
                $shift_users = '';
                if (!empty($user_shiftrole[$shift->id][$shiftrole->id])) {
                    $shift_users = $user_shiftrole[$shift->id][$shiftrole->id];
                    $found = count($shift_users);
                    if ($found >= $allowed) {
                        $status = 'full';
                    }
                    foreach ($shift_users as $shift_user) {
                        if ($shift_user['id'] == $auth_user_id) {
                            $status = 'assigned';
                        }
                    }
                }

                $role = [];
                $role['id'] = $shiftrole->id;
                $role['name'] = $shiftrole->name;
                $role['status'] = $status;
                $role['allowed'] = $allowed;
                $role['found'] = $found;
                $role['users'] = $shift_users;
                $entry['shiftroles'][] = $role;
            }

            $data['data'][] = $entry;
        }

        return inertia('Shifts/Index', $data);
    }

    public function roles()
    {
        $roles = Shiftrole::all();

        return inertia('Shifts/Info', ['roles' => ShiftroleInfoResource::collection($roles)]);
    }

    public function myshifts()
    {
        $days = auth()->user()->shifts()->get()->sortBy('day')->groupBy('day');
        $ret = [];
        foreach ($days as $day => $shifts) {
            $array['name'] = $day;
            $array['shifts'] = MyShiftResource::collection(
                $shifts->sortBy('time')
            );

            $ret[] = $array;
        }

        return inertia('Shifts/My', [ 'data' => $ret ]);
    }

    public function attach(Shift $shift)
    {
        $user = auth()->user();
        if ($shift->shiftroles()->find(request()->shiftrole_id)->full($shift->id)) {
            return;
        }
        $shift->users()->attach($user->id, ['shiftrole_id' => request()->shiftrole_id]);
        Cache::forget('shifts_count');

        return redirect()->back();
    }

    public function detach(Shift $shift)
    {
        $shift->users()->detach(auth()->user()->id, ['shiftrole_id' => request()->shiftrole_id]);
        Cache::forget('shifts_count');

        return redirect()->back();
    }

    public function shifts_count()
    {
        return Cache::remember('shifts_count', 300, function () {
            $shifts = Shift::with('shiftroles')
                ->where('orga', false)
                ->get();
            $count = 0;
            foreach ($shifts as $shift) {
                foreach ($shift->shiftroles as $role) {
                    $count = $count + $role->pivot->count;
                }
            }
            $users = User::with('Shifts')->get();
            $user_shifts = 0;
            foreach ($users as $user) {
                foreach ($user->shifts as $shift) {
                    $user_shifts++;
                }
            }
            $ret = [];
            $ret['users'] = $user_shifts;
            $ret['count'] = $count;

            return $ret;
        });
    }
}
