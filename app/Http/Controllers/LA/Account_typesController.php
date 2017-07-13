<?php
/**
 * Controller generated using LaraAdmin
 * Help: http://laraadmin.com
 * LaraAdmin is open-sourced software licensed under the MIT license.
 * Developed by: Dwij IT Solutions
 * Developer Website: http://dwijitsolutions.com test
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

use App\Models\Account_type;

class Account_typesController extends Controller
{
    public $show_action = true;

    /**
     * Display a listing of the Account_types.
     *
     * @return mixed
     */
    public function index()
    {
        $module = Module::get('Account_types');

        if(Module::hasAccess($module->id)) {
            return View('la.account_types.index', [
                'show_actions' => $this->show_action,
                'listing_cols' => Module::getListingColumns('Account_types'),
                'module' => $module
            ]);
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Show the form for creating a new account_type.
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created account_type in database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if(Module::hasAccess("Account_types", "create")) {

            $rules = Module::validateRules("Account_types", $request);

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $insert_id = Module::insert("Account_types", $request);

            return redirect()->route(config('laraadmin.adminRoute') . '.account_types.index');

        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Display the specified account_type.
     *
     * @param int $id account_type ID
     * @return mixed
     */
    public function show($id)
    {
        if(Module::hasAccess("Account_types", "view")) {

            $account_type = Account_type::find($id);
            if(isset($account_type->id)) {
                $module = Module::get('Account_types');
                $module->row = $account_type;

                return view('la.account_types.show', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                    'no_header' => true,
                    'no_padding' => "no-padding"
                ])->with('account_type', $account_type);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("account_type"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Show the form for editing the specified account_type.
     *
     * @param int $id account_type ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        if(Module::hasAccess("Account_types", "edit")) {
            $account_type = Account_type::find($id);
            if(isset($account_type->id)) {
                $module = Module::get('Account_types');

                $module->row = $account_type;

                return view('la.account_types.edit', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                ])->with('account_type', $account_type);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("account_type"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Update the specified account_type in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id account_type ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if(Module::hasAccess("Account_types", "edit")) {

            $rules = Module::validateRules("Account_types", $request, true);

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();;
            }

            $insert_id = Module::updateRow("Account_types", $request, $id);

            return redirect()->route(config('laraadmin.adminRoute') . '.account_types.index');

        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Remove the specified account_type from storage.
     *
     * @param int $id account_type ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if(Module::hasAccess("Account_types", "delete")) {
            Account_types::find($id)->delete();

            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.account_types.index');
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
        $module = Module::get('Account_types');
        $listing_cols = Module::getListingColumns('Account_types');

        $values = DB::table('account_types')->select($listing_cols)->whereNull('deleted_at');
        $out = Datatables::of($values)->make();
        $data = $out->getData();

        $fields_popup = ModuleFields::getModuleFields('Account_types');

        for($i = 0; $i < count($data->data); $i++) {
            for($j = 0; $j < count($listing_cols); $j++) {
                $col = $listing_cols[$j];
                if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
                    $data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
                }
                if($col == $module->view_col) {
                    $data->data[$i][$j] = '<a href="' . url(config('laraadmin.adminRoute') . '/account_types/' . $data->data[$i][0]) . '">' . $data->data[$i][$j] . '</a>';
                }
                // else if($col == "author") {
                //    $data->data[$i][$j];
                // }
            }

            if($this->show_action) {
                $output = '';
                if(Module::hasAccess("Account_types", "edit")) {
                    $output .= '<a href="' . url(config('laraadmin.adminRoute') . '/account_types/' . $data->data[$i][0] . '/edit') . '" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
                }

                if(Module::hasAccess("Account_types", "delete")) {
                    $output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.account_types.destroy', $data->data[$i][0]], 'method' => 'delete', 'style' => 'display:inline']);
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
