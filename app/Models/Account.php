<?php
/**
 * Model generated using LaraAdmin
 * Help: http://laraadmin.com
 * LaraAdmin is open-sourced software licensed under the MIT license.
 * Developed by: Dwij IT Solutions
 * Developer Website: http://dwijitsolutions.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\User;
use App\Models\Title;
use App\Models\Contact;
use App\Models\Address;
use DB;
use Zizaco\Entrust\EntrustFacade as Entrust;

class Account extends Model
{
    use SoftDeletes;

    protected $table = 'accounts';

    protected $hidden = [

    ];

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    public function users(){
        return $this->belongsToMany(User::class)
            ->withPivot('acc_view','acc_edit','acc_delete');
    }

    public function title(){
        return $this->hasOne(Title::class, 'id', 'title_id');
    }

    public function contacts(){
        return $this->hasMany(Contact::class, 'account_id');
    }

    public function addresses(){
        return $this->hasMany(Address::class, 'account_id');
    }

    
//    public function contact_details(){
//        return $this->hasManyThrough('App\Models\Contact_detail', 'App\Models\Contact');
//    }

    /**
     * Get Specific Account Access for login user or specific user ($user_id)
     *
     * Account::hasAccess($account_id, $access_type, $user_id);
     *
     * @param $account_id Account ID
     * @param string $access_type Access Type - view / create / edit / delete
     * @param int $user_id User id for which Access will be checked
     * @return bool Returns true if access is there or false
     */
    public static function hasAccess($account_id, $access_type = "view", $user_id = 0)
    {
        if (Entrust::hasRole('SUPER_ADMIN')) {
            return true;
        } else {
            if($access_type == null || $access_type == "") {
                $access_type = "view";
            }


            $account_perm = DB::table('account_user')->where('user_id', $user_id)->where('account_id', $account_id)->first();
            if(isset($account_perm->{"acc_" . $access_type}) && $account_perm->{"acc_" . $access_type} == 1) {
                return true;
            } else {
                return false;
            }
        }

    }
}
