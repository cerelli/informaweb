<?php
namespace App\Repositories\Localities;

use App\Repositories\Localities\LocalitiesInterface;
use DB;

/**
* Class Localities
* @package App\Repositories\Localities
*/
class Localities implements LocalitiesInterface
{
    protected $obj;

    public function __construct()
    {
        $this->obj=$this;
    }
   /**
   * @param locality_id
   * @return mixed
   */
   public function getLocality($locality_id)
   {
       $locality = DB::table('localities')
                   ->select('localities.id as locality_id', 'localities.postal_code', 'localities.place_name', 'localities.province_code', 'localities.latitude', 'localities.longitude')
                   ->where('localities.id', $locality_id)
                   ->first();
                   //->toSql();
                //    dd($locality);
                   $formatLocality = "";
                   $formatLocality = $locality->postal_code.' '.$locality->place_name;
                   $province = '('.$locality->province_code.')';
                   if ( $province == '()' ) {

                   } else {
                       $formatLocality .= ' ('.$locality->province_code.')';
                   }
       return $formatLocality;
   }
}
