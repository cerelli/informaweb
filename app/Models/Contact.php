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
use App\Models\Account;
use App\Models\Title;
use App\Models\Contact_detail;

class Contact extends Model
{
    use SoftDeletes;

    protected $table = 'contacts';

    protected $hidden = [

    ];

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    public function accounts(){
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function title(){
        return $this->belongsTo(Title::class, 'title_id');
    }

    public function contact_details(){
        return $this->hasMany(Contact_detail::class, 'contact_id');
    }
}
