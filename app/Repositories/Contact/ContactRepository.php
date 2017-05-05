<?php
namespace App\Repositories\Contacts;

use App\Repositories\Contacts\ContactsRepositoryContract;
use DB;

/**
* Class UsersAccessRightsRepository
* @package App\Repositories\UsersAccessRightsRepository
*/
class UsersAccessRightsRepository implements UsersAccessRightsRepositoryContract
{
    protected $obj;

    public function __construct()
    {
        $this->obj=$this;
    }
   /**
   * @param $account_id
   * @return mixed
   */
   public function getAccountsUsersAccessRights($account_id)
   {
       $first = DB::table('users')
                   ->leftJoin('account_user', 'account_user.user_id', '=', 'users.id')
                   ->leftJoin('role_user', 'role_user.user_id', '=', 'users.id')
                   ->leftJoin('roles', 'roles.id', '=', 'role_user.role_id')
                   ->select('users.id as user_id', 'users.name', 'account_user.id', 'account_user.acc_view', 'account_user.acc_edit', 'account_user.acc_delete')
                   ->whereNotIn('roles.name', ['SUPER_ADMIN'])
                   ->where('account_user.account_id', $account_id);

        $second = DB::table('users')
                    ->leftJoin('account_user', 'account_user.user_id', '=', 'users.id')
                    ->leftJoin('role_user', 'role_user.user_id', '=', 'users.id')
                    ->leftJoin('roles', 'roles.id', '=', 'role_user.role_id')
                    ->select('users.id')
                    ->whereNotIn('roles.name', ['SUPER_ADMIN'])
                    ->where('account_user.account_id', $account_id);

       $AccountUsersAccessRights = DB::table('users')
                               ->leftJoin('role_user', 'role_user.user_id', '=', 'users.id')
                               ->leftJoin('roles', 'roles.id', '=', 'role_user.role_id')
                               ->select(DB::raw('users.id as user_id, users.name as name, 0 as account_user_id, 0 as acc_view, 0 as acc_edit, 0 as acc_delete'))
                               ->whereNotIn('roles.name', ['SUPER_ADMIN'])
                               ->whereNotIn('users.id', $second)
                               ->union($first)
                               ->orderBy('name')
                               ->get();
                               //->toSql();
                               //dd($AccountUsersAccessRights);
       return $AccountUsersAccessRights;
   }
}
