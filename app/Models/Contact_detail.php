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
use App\Models\Communication_type;
use App\Models\Contact_detail_type;

class Contact_detail extends Model
{
    use SoftDeletes;

    protected $table = 'contact_details';

    protected $hidden = [

    ];

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    public function contact_detail_type(){
        return $this->belongsTo(Contact_detail_type::class, 'contact_detail_type_id');
    }

    public function communication_type(){
        return $this->belongsTo(Communication_type::class, 'communication_type_id');
    }
}
