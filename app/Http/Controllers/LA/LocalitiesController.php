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

use App\Models\Locality;

class LocalitiesController extends Controller
{
    public $show_action = true;


    /**
     * Display a listing of the Localities.
     *
     * @return mixed
     */
    public function index()
    {
        $module = Module::get('Localities');

        if(Module::hasAccess($module->id)) {
            return View('la.localities.index', [
                'show_actions' => $this->show_action,
                'listing_cols' => Module::getListingColumns('Localities'),
                'module' => $module
            ]);
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Show the form for creating a new locality.
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created locality in database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if(Module::hasAccess("Localities", "create")) {

            $rules = Module::validateRules("Localities", $request);

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $insert_id = Module::insert("Localities", $request);

            return redirect()->route(config('laraadmin.adminRoute') . '.localities.index');

        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Display the specified locality.
     *
     * @param int $id locality ID
     * @return mixed
     */
    public function show($id)
    {
        if(Module::hasAccess("Localities", "view")) {

            $locality = Locality::find($id);
            if(isset($locality->id)) {
                $module = Module::get('Localities');
                $module->row = $locality;

                return view('la.localities.show', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                    'no_header' => true,
                    'no_padding' => "no-padding"
                ])->with('locality', $locality);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("locality"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Show the form for editing the specified locality.
     *
     * @param int $id locality ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        if(Module::hasAccess("Localities", "edit")) {
            $locality = Locality::find($id);
            if(isset($locality->id)) {
                $module = Module::get('Localities');

                $module->row = $locality;

                return view('la.localities.edit', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                ])->with('locality', $locality);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("locality"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Update the specified locality in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id locality ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if(Module::hasAccess("Localities", "edit")) {

            $rules = Module::validateRules("Localities", $request, true);

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();;
            }

            $insert_id = Module::updateRow("Localities", $request, $id);

            return redirect()->route(config('laraadmin.adminRoute') . '.localities.index');

        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Remove the specified locality from storage.
     *
     * @param int $id locality ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if(Module::hasAccess("Localities", "delete")) {
            Locality::find($id)->delete();

            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.localities.index');
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
        $module = Module::get('Localities');
        $listing_cols = Module::getListingColumns('Localities');

        $values = DB::table('localities')->select($listing_cols)->whereNull('deleted_at');
        $out = Datatables::of($values)->make();
        $data = $out->getData();

        $fields_popup = ModuleFields::getModuleFields('Localities');

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
                    $data->data[$i][$j] = '<a href="' . url(config('laraadmin.adminRoute') . '/localities/' . $data->data[$i][0]) . '">' . $data->data[$i][$j] . '</a>';
                }
                // else if($col == "author") {
                //    $data->data[$i][$j];
                // }
            }

            if($this->show_action) {
                $output = '';
                if(Module::hasAccess("Localities", "edit")) {
                    $output .= '<a href="' . url(config('laraadmin.adminRoute') . '/localities/' . $data->data[$i][0] . '/edit') . '" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
                }

                if(Module::hasAccess("Localities", "delete")) {
                    $output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.localities.destroy', $data->data[$i][0]], 'method' => 'delete', 'style' => 'display:inline']);
                    $output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
                    $output .= Form::close();
                }
                $data->data[$i][] = (string)$output;
            }
        }
        $out->setData($data);
        return $out;
    }

    /**
     * Server side Datatable fetch via Ajax
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function select_dtajax(Request $request)
    {
        $module = Module::get('Localities');

        $values = DB::table('localities')->select('localities.id as locality_id', 'localities.postal_code', 'localities.place_name', 'localities.province_code', 'localities.latitude')->whereNull('deleted_at');
        $out = Datatables::of($values)->make();
        $data = $out->getData();
        $out->setData($data);
        return $out;
    }
}
