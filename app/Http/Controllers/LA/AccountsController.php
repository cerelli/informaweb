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
use Zizaco\Entrust\EntrustFacade as Entrust;
use App\Repositories\UsersAccessRights\UsersAccessRightsRepositoryContract;


use App\Models\Account;

class AccountsController extends Controller
{
    public $show_action = true;
    protected $usersAccess;

    public function __construct(
        UsersAccessRightsRepositoryContract $usersAccess
    )
    {
        $this->usersAccess = $usersAccess;
    }
    /**
     * Display a listing of the Accounts.
     *
     * @return mixed
     */
    public function index()
    {
        $module = Module::get('Accounts');

        if(Module::hasAccess($module->id)) {
            return View('la.accounts.index', [
                'show_actions' => $this->show_action,
                'listing_cols' => Module::getListingColumns('Accounts'),
                'module' => $module
            ]);
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Show the form for creating a new account.
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created account in database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if(Module::hasAccess("Accounts", "create")) {

            $rules = Module::validateRules("Accounts", $request);

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $insert_id = Module::insert("Accounts", $request);

            return redirect()->route(config('laraadmin.adminRoute') . '.accounts.index');

        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Display the specified account.
     *
     * @param int $id account ID
     * @return mixed
     */
    public function show($id)
    {
        if(Module::hasAccess("Accounts", "view")) {

            $account = Account::find($id);
            if(isset($account->id)) {
                $module = Module::get('Accounts');
                $module->row = $account;

                return view('la.accounts.show', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                    'no_header' => true,
                    'no_padding' => "no-padding"
                ])->with('account', $account)
                ->withUsersAccess($this->usersAccess->getAccountUsersAccessRights($account->id));
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("account"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Show the form for editing the specified account.
     *
     * @param int $id account ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        if(Module::hasAccess("Accounts", "edit")) {
            $account = Account::find($id);
            if(isset($account->id)) {
                $module = Module::get('Accounts');

                $module->row = $account;

                return view('la.accounts.edit', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                ])->with('account', $account);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("account"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Update the specified account in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id account ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if(Module::hasAccess("Accounts", "edit")) {

            $rules = Module::validateRules("Accounts", $request, true);

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();;
            }

            $insert_id = Module::updateRow("Accounts", $request, $id);

            return redirect()->route(config('laraadmin.adminRoute') . '.accounts.index');

        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Remove the specified account from storage.
     *
     * @param int $id account ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if(Module::hasAccess("Accounts", "delete")) {
            Account::find($id)->delete();

            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.accounts.index');
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
        $module = Module::get('Accounts');

        $listing_cols = Module::getListingColumns('Accounts');

        if(Entrust::can('view_all_accounts') || Entrust::hasRole('SUPER_ADMIN')) {
            $values = DB::table('accounts')->select($listing_cols)->whereNull('deleted_at');
        } else {
            $accounts_user = DB::table('account_user')
                                ->select('account_id')
                                ->where('user_id', Auth::user()->id)
                                ->where('acc_view', 1);

            // $values = DB::table('accounts')->select($listing_cols)->whereNull('deleted_at');
            $values = DB::table('accounts')
                        ->select($listing_cols)
                        ->whereNull('deleted_at')
                        ->whereIn('id', $accounts_user);
        }


        $out = Datatables::of($values)->make();
        $data = $out->getData();

        $fields_popup = ModuleFields::getModuleFields('Accounts');

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
                    $data->data[$i][$j] = '<a href="' . url(config('laraadmin.adminRoute') . '/accounts/' . $data->data[$i][0]) . '">' . $data->data[$i][$j] . '</a>';
                }
                // else if($col == "author") {
                //    $data->data[$i][$j];
                // }
            }

            if($this->show_action) {
                $output = '';
                if(Module::hasAccess("Accounts", "edit")) {
                    if(Account::hasAccess($data->data[$i][0], "edit", Auth::user()->id)) {
                        $output .= '<a href="' . url(config('laraadmin.adminRoute') . '/accounts/' . $data->data[$i][0] . '/edit') . '" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
                    }
                }

                if(Module::hasAccess("Accounts", "delete")) {
                    $output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.accounts.destroy', $data->data[$i][0]], 'method' => 'delete', 'style' => 'display:inline']);
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
