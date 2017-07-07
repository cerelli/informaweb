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

class Locality extends Model
{
    use SoftDeletes;

    protected $table = 'localities';

    protected $hidden = [

    ];

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    /**
    * @return string
    */
    public function getLocalityString()
    {
        if ( $this->province_code == '') {
            $province = '';
        } else {
            $province = ' ('.$this->province_code.')';
        }

        return $this->postal_code.' '.$this->place_name.$province;
    }
}
