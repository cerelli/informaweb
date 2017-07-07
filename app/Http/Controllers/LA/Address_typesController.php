<?php
/**
 * Controller generated using LaraAdmin
 * Help: http://laraadmin.com
 * LaraAdmin is open-sourced software licensed under the MIT license.
 * Developed by: Dwij IT Solutions
 * Developer Website: http://dwijitsolutions.com
 */

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use Validator;
use Datatables;
use Collective\Html\FormFacade as Form;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;
use Dwij\Laraadmin\Models\ModuleFieldTypes;

use App\Models\Address_type;

class Address_typesController extends Controller
{
    public $show_action = true;

    /**
     * Display a listing of the Address_types.
     *
     * @return mixed
     */
    public function index()
    {
        $module = Module::get('Address_types');

        if(Module::hasAccess($module->id)) {
            return View('la.address_types.index', [
                'show_actions' => $this->show_action,
                'listing_cols' => Module::getListingColumns('Address_types'),
                'module' => $module
            ]);
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Show the form for creating a new address_type.
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created address_type in database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if(Module::hasAccess("Address_types", "create")) {

            $rules = Module::validateRules("Address_types", $request);

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $insert_id = Module::insert("Address_types", $request);

            return redirect()->route(config('laraadmin.adminRoute') . '.address_types.index');

        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Display the specified address_type.
     *
     * @param int $id address_type ID
     * @return mixed
     */
    public function show($id)
    {
        if(Module::hasAccess("Address_types", "view")) {

            $address_type = Address_type::find($id);
            if(isset($address_type->id)) {
                $module = Module::get('Address_types');
                $module->row = $address_type;

                return view('la.address_types.show', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                    'no_header' => true,
                    'no_padding' => "no-padding"
                ])->with('address_type', $address_type);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("address_type"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Show the form for editing the specified address_type.
     *
     * @param int $id address_type ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        if(Module::hasAccess("Address_types", "edit")) {
            $address_type = Address_type::find($id);
            if(isset($address_type->id)) {
                $module = Module::get('Address_types');

                $module->row = $address_type;

                return view('la.address_types.edit', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                ])->with('address_type', $address_type);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("address_type"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Update the specified address_type in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id address_type ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if(Module::hasAccess("Address_types", "edit")) {

            $rules = Module::validateRules("Address_types", $request, true);

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();;
            }

            $insert_id = Module::updateRow("Address_types", $request, $id);

            return redirect()->route(config('laraadmin.adminRoute') . '.address_types.index');

        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Remove the specified address_type from storage.
     *
     * @param int $id address_type ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if(Module::hasAccess("Address_types", "delete")) {
            Address_type::find($id)->delete();

            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.address_types.index');
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Server side Datatable fetch via Ajax
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function dtajax(Request $request)
    {
        $module = Module::get('Address_types');
        $listing_cols = Module::getListingColumns('Address_types');

        $values = DB::table('address_types')->select($listing_cols)->whereNull('deleted_at');
        $out = Datatables::of($values)->make();
        $data = $out->getData();

        $fields_popup = ModuleFields::getModuleFields('Address_types');

        for($i = 0; $i < count($data->data); $i++) {
            for($j = 0; $j < count($listing_cols); $j++) {
                $col = $listing_cols[$j];
                if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
                    //slam_modifie_start
                    $field_type = ModuleFieldTypes::find($fields_popup[$col]->field_type);
                    switch($field_type->name) {
                        case 'Multiselect':
                            $multiValues = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
                            $multiValues = str_replace(['[', ']', '"'], '', $multiValues);
                            $multiValues = explode(",", $multiValues);
                            $value = '';
                            foreach($multiValues as $multiValue) {
                                $value .= " <span class = 'label label-default'>".ModuleFields::getFieldValue($fields_popup[$col], $multiValue)."</span>";
                            }

                            $data->data[$i][$j] = $value;
                            break;
                        default:
                            $data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
                    }
                    //slam_modifie_stop
                }
                if($col == $module->view_col) {
                    $data->data[$i][$j] = '<a href="' . url(config('laraadmin.adminRoute') . '/address_types/' . $data->data[$i][0]) . '">' . $data->data[$i][$j] . '</a>';
                }
                // else if($col == "author") {
                //    $data->data[$i][$j];
                // }
            }

            if($this->show_action) {
                $output = '';
                if(Module::hasAccess("Address_types", "edit")) {
                    $output .= '<a href="' . url(config('laraadmin.adminRoute') . '/address_types/' . $data->data[$i][0] . '/edit') . '" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
                }

                if(Module::hasAccess("Address_types", "delete")) {
                    $output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.address_types.destroy', $data->data[$i][0]], 'method' => 'delete', 'style' => 'display:inline']);
                    $output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
                    $output .= Form::close();
                }
                $data->data[$i][] = (string)$output;
            }
        }
        $out->setData($data);
        return $out;
    }
}
