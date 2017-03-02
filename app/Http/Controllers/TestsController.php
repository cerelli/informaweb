<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Datatables;
use App\Models\Account;
use App\User;
use DB;

class TestsController extends Controller
{
    /**
     * Displays datatables front end view
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        return view('test');
    }

    public function anyData()
    {
        $id = 1;
        $first = DB::table('users')
                    ->leftJoin('account_user', 'account_user.user_id', '=', 'users.id')
                    ->leftJoin('role_user', 'role_user.user_id', '=', 'users.id')
                    ->leftJoin('roles', 'roles.id', '=', 'role_user.role_id')
                    ->select('users.name', 'account_user.id as account_user_id', 'account_user.acc_view', 'account_user.acc_create', 'account_user.acc_edit', 'account_user.acc_delete')
                    ->whereNotIn('roles.name', ['SUPER_ADMIN'])
                    ->where('account_user.account_id', $id);

        $usersAccessRights = DB::table('users')
                                ->leftJoin('account_user', 'account_user.user_id', '=', 'users.id')
                                ->leftJoin('role_user', 'role_user.user_id', '=', 'users.id')
                                ->leftJoin('roles', 'roles.id', '=', 'role_user.role_id')
                                ->select('users.name', 'account_user.id as account_user_id', 'account_user.acc_view', 'account_user.acc_create', 'account_user.acc_edit', 'account_user.acc_delete')
                                ->whereNotIn('roles.name', ['SUPER_ADMIN'])
                                ->union($first)
                                ->get();

        return Datatables::of($usersAccessRights)
            ->make(true);
        // return Datatables::of(User::query())->make(true);
    }

}
