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

use App\Models\Address_type;
use App\Models\Locality;

class Address extends Model
{
    use SoftDeletes;

    protected $table = 'addresses';

    protected $hidden = [

    ];

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    public function address_type(){
        return $this->hasOne(Address_type::class, 'address_type_id');
    }

    public function locality(){
        return $this->hasOne(Locality::class, 'id', 'locality_id');
    }
}
