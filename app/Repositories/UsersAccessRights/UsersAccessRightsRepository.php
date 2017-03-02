<?php
namespace App\Repositories\UsersAccessRights;

use App\Repositories\UsersAccessRights\UsersAccessRightsRepositoryContract;
use DB;
use App\Models\Account;

/**
* Class UsersAccessRightsRepository
* @package App\Repositories\UsersAccessRightsRepository
*/
class UsersAccessRightsRepository implements UsersAccessRightsRepositoryContract
{
   /**
   * @param $account_id
   * @return mixed
   */
   public function getAccountUsersAccessRights($account_id)
   {
       $first = DB::table('users')
                   ->leftJoin('account_user', 'account_user.user_id', '=', 'users.id')
                   ->leftJoin('role_user', 'role_user.user_id', '=', 'users.id')
                   ->leftJoin('roles', 'roles.id', '=', 'role_user.role_id')
                   ->select('users.name', 'account_user.id', 'account_user.acc_view', 'account_user.acc_create', 'account_user.acc_edit', 'account_user.acc_delete')
                   ->whereNotIn('roles.name', ['SUPER_ADMIN','NORMAL_ADMIN'])
                   ->where('account_user.account_id', $account_id);

       $AccountUsersAccessRights = DB::table('users')
                               ->leftJoin('account_user', 'account_user.user_id', '=', 'users.id')
                               ->leftJoin('role_user', 'role_user.user_id', '=', 'users.id')
                               ->leftJoin('roles', 'roles.id', '=', 'role_user.role_id')
                               ->select('users.name', 'account_user.id', 'account_user.acc_view', 'account_user.acc_create', 'account_user.acc_edit', 'account_user.acc_delete')
                               ->whereNotIn('roles.name', ['SUPER_ADMIN','NORMAL_ADMIN'])
                               ->union($first)
                               ->get();

       return $AccountUsersAccessRights;
   }
}
