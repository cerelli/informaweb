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
    public static function print_contact_editor($moduleName, $data)
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
                    // $info->$fieldName = $module->fields[$fieldName]['id'];
                    $info->$fieldName = $data->$fieldName;
                }
            }
        }
        // $editing .= '<a id="editModalBtn_'.$info->id.'" class="editModalBtn pull-right btn btn-xs btn-warning btn-hidden" info=\'' . json_encode($info) . '\'><i class="fa fa-edit"></i></a>';
        $editing .= '<a id="editModalBtn_'.$info->id.'" class="editModalBtn pull-right btn btn-xs btn-warning btn-hidden" info=\'' . json_encode($info) . '\'><i class="fa fa-edit"></i></a>';
        return $editing;
        // dd($editing);
        // $editing = \Collective\Html\FormFacade::open(['route' => [config('laraadmin.adminRoute') . '.la_menus.destroy', $menu->id], 'method' => 'delete', 'style' => 'display:inline']);
        // $editing .= '<button class="btn btn-xs btn-danger pull-right"><i class="fa fa-times"></i></button>';
        // $editing .= \Collective\Html\FormFacade::close();

        // if($menu->type != "module") {
            // $info = (object)array();
            // $info->id = $contact->id;
            // $info->name = $menu->name;
            // $info->url = $menu->url;
            // $info->type = $menu->type;
            // $info->icon = $menu->icon;
            //
            // $editing .= '<a class="editMenuBtn btn btn-xs btn-success pull-right" info=\'' . json_encode($info) . '\'><i class="fa fa-edit"></i></a>';
        // }
        // $str = '<li class="dd-item dd3-item" data-id="' . $menu->id . '">
		// 	<div class="dd-handle dd3-handle"></div>
		// 	<div class="dd3-content"><i class="fa ' . $menu->icon . '"></i> ' . $menu->name . ' ' . $editing . '</div>';
        //
        // $childrens = \Dwij\Laraadmin\Models\Menu::where("parent", $menu->id)->orderBy('hierarchy', 'asc')->get();
        //
        // if(count($childrens) > 0) {
        //     $str .= '<ol class="dd-list">';
        //     foreach($childrens as $children) {
        //         $str .= LAHelper::print_menu_editor($children);
        //     }
        //     $str .= '</ol>';
        // }
        // $str .= '</li>';
        //
    }

}
