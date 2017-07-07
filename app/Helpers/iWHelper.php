<?php
/**
 * Code generated using LaraAdmin
 * Help: http://laraadmin.com
 * LaraAdmin is open-sourced software licensed under the MIT license.
 * Developed by: Dwij IT Solutions
 * Developer Website: http://dwijitsolutions.com
 */

namespace App\Helpers;

use DB;
use Log;

use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;
use Dwij\Laraadmin\LAFormMaker;

/**
 * Class iWHelpers
  *
 * This is informaWEB Helper class contains methods required for informa functionality.
 */
class iWHelper
{

    /**
     * Print the menu editor view.
     * This needs to be done recursively
     *
     * LAHelper::print_menu_editor($menu)
     *
     * @param $menu menu array from database
     * @return string menu editor html string
     */
    public static function print_modal_editor($moduleName, $data)
    {
        $fields_module = ModuleFields::getModuleFields($moduleName);
        $module = Module::get($moduleName);
        $info = (object)array();
        $editing = '';
        foreach($fields_module as $fieldName=>$field) {
            //exclude id
            if ($fieldName == 'id'){
                $info->id = $data->id;
            }else{
                // Control the access of fields
                if(Module::hasFieldAccess($module->id, $module->fields[$fieldName]['id'], $access_type = "write")) {
                    $info->$fieldName = $data->$fieldName;
                }
            }
        }
        $editing .= '<a id="editModalBtn_'.$info->id.'" class="editModalBtn pull-right btn btn-xs btn-warning btn-hidden" info=\'' . json_encode($info) . '\'><i class="fa fa-edit"></i></a>';
        return $editing;
    }

}
