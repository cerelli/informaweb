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
use Illuminate\Support\Facades\Input;

use App\Repositories\Localities\LocalitiesInterface;
use App\Models\Address;

class AddressesController extends Controller
{
    public $show_action = true;
    protected $localities;

    public function __construct(LocalitiesInterface $localities)
    {
        $this->localities = $localities;
        // dd($this->localities->getLocality(1));
        /**dd($this->contactDetails->getAllOfContact(1));**/
    }
    /**
     * Display a listing of the Addresses.
     *
     * @return mixed
     */
    public function index()
    {
        $module = Module::get('Addresses');

        if(Module::hasAccess($module->id)) {
            return View('la.addresses.index', [
                'show_actions' => $this->show_action,
                'listing_cols' => Module::getListingColumns('Addresses'),
                'module' => $module
            ]);
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Show the form for creating a new address.
     *
     * @return mixed
     */
    public function create()
    {
        //
    }


        public function add_address(Request $request, $id)
        {
            // $request->{'account_id'} = $id;
            // $request->{'locality_id'} = input::get('localityIdAdd');

            if(Module::hasAccess("Addresses", "create")) {

                $rules = Module::validateRules("Addresses", $request);

                $validator = Validator::make($request->all(), $rules);
// dd($request->all());
                if($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                $insert_id = Module::insert("Addresses", $request);

                return redirect(config('laraadmin.adminRoute') . '/accounts/' . $id . "#tab-addresses");

            } else {
                return redirect(config('laraadmin.adminRoute') . "/");
            }
        }

    /**
     * Store a newly created address in database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if(Module::hasAccess("Addresses", "create")) {

            $rules = Module::validateRules("Addresses", $request);

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $insert_id = Module::insert("Addresses", $request);

            return redirect()->route(config('laraadmin.adminRoute') . '.addresses.index');

        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Display the specified address.
     *
     * @param int $id address ID
     * @return mixed
     */
    public function show($id)
    {
        if(Module::hasAccess("Addresses", "view")) {

            $address = Address::find($id);
            if(isset($address->id)) {
                $module = Module::get('Addresses');
                $module->row = $address;

                return view('la.addresses.show', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                    'no_header' => true,
                    'no_padding' => "no-padding"
                ])->with('address', $address);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("address"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Show the form for editing the specified address.
     *
     * @param int $id address ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $locality = $this->localities->getLocality(1);
        dd($locality);
        if(Module::hasAccess("Addresses", "edit")) {
            $address = Address::find($id);
            if(isset($address->id)) {
                $module = Module::get('Addresses');

                $module->row = $address;

                return view('la.addresses.edit', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                ])->with('address', $address);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("address"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Show the form for editing the specified contact.
     *
     * @param int $id contact ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editModal($id)
    {
        if(Module::hasAccess("Addresses", "edit")) {
            $address = Address::find($id);
            if(isset($address->id)) {
                $module = Module::get('Addresses');
                $module->row = $address;
                //locality
                $locality = $this->localities->getLocality($address->locality_id);
                $address->locality = $locality;
                return response()->json($address);
            } else {
                return response()->json(['response' => 'error']);
            }
        } else {
            return response()->json(['response' => 'not found']);
        }
    }

    /**
     * Update the specified address in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id address ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if(Module::hasAccess("Addresses", "edit")) {

            $rules = Module::validateRules("Addresses", $request, true);

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $insert_id = Module::updateRow("Addresses", $request, $id);

            return redirect()->route(config('laraadmin.adminRoute') . '.addresses.index');

        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }


        /**
         * Update the specified address in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @param int $id contact ID
         * @return \Illuminate\Http\RedirectResponse
         */
        public function updateModalAddress(Request $request, $id)
        {
            if(Module::hasAccess("Addresses", "edit")) {
                $address = Address::find($id);
                $addressId = $id;
                $fields = ModuleFields::getModuleFields('Addresses');
                foreach ($fields as $field => $value) {
                    $value_get = Input::get($field);
                    if ( $value_get != null ) {
                        $address->$field = $value_get;
                    }else{
                        $address->$field = "";
                    }
                }
                $address->id = $addressId;
                $address->account_id = input::get('account_id');
                $address->locality_id = input::get('localityId');
                $address->localityString = input::get('inputLocalityString');

                $rules = Module::validateRules("Addresses", $address, true);
                // $rules['localityString'] = trim("required", "|");

                // return response()->json($rules);
                $validator = Validator::make($address->toArray(), $rules);
                // return response()->json($validator->fails());
                if($validator->fails()) {
                    return response()->json(['response' => 'noooo']);
                }

                $insert_id = Module::updateRow("Addresses", $address, $id);
                // //add description
                if ($address->address_type_id > 0) {
                    $address_type_description = DB::table('address_types')->select('description')->where('id', $address->address_type_id)->value('description');
                    $address->address_type_description = $address_type_description;
                }
                return response()->json($address);

            } else {
                return response()->json(['response' => 'non so']);
            }
        }

    /**
     * Remove the specified address from storage.
     *
     * @param int $id address ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if(Module::hasAccess("Addresses", "delete")) {
            Address::find($id)->delete();

            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.addresses.index');
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }


        /**
         * Remove the specified address from storage.
         *
         * @param int $id contact ID
         * @return \Illuminate\Http\RedirectResponse
         */
        public function delete_address($id)
        {
            if(Module::hasAccess("Addresses", "delete")) {
                $account_id = Input::get('accountId');
                Address::find($id)->delete();
                // Redirecting to index() method
                return redirect(config('laraadmin.adminRoute') . '/accounts/' . $account_id . "#tab-addresses");
            } else {
                return redirect(config('laraadmin.adminRoute') . '/accounts/' . $account_id);
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
        $module = Module::get('Addresses');
        $listing_cols = Module::getListingColumns('Addresses');

        $values = DB::table('addresses')->select($listing_cols)->whereNull('deleted_at');
        $out = Datatables::of($values)->make();
        $data = $out->getData();

        $fields_popup = ModuleFields::getModuleFields('Addresses');

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
                    $data->data[$i][$j] = '<a href="' . url(config('laraadmin.adminRoute') . '/addresses/' . $data->data[$i][0]) . '">' . $data->data[$i][$j] . '</a>';
                }
                // else if($col == "author") {
                //    $data->data[$i][$j];
                // }
            }

            if($this->show_action) {
                $output = '';
                if(Module::hasAccess("Addresses", "edit")) {
                    $output .= '<a href="' . url(config('laraadmin.adminRoute') . '/addresses/' . $data->data[$i][0] . '/edit') . '" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
                }

                if(Module::hasAccess("Addresses", "delete")) {
                    $output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.addresses.destroy', $data->data[$i][0]], 'method' => 'delete', 'style' => 'display:inline']);
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
