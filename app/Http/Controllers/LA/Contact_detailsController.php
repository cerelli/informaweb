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

use App\Models\Contact_detail;

class Contact_detailsController extends Controller
{
    public $show_action = true;

    /**
     * Display a listing of the Contact_Details.
     *
     * @return mixed
     */
    public function index()
    {
        $module = Module::get('Contact_Details');
        if(Module::hasAccess($module->id)) {
            return View('la.contact_details.index', [
                'show_actions' => $this->show_action,
                'listing_cols' => Module::getListingColumns('Contact_Details'),
                'module' => $module
            ]);
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Show the form for creating a new contact_detail.
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    public function add_contact_detail(Request $request, $id)
    {
        // $contact = $request->input();
        // $contact['account_id'] = $id;
        if(Module::hasAccess("Contact_details", "create")) {

            $rules = Module::validateRules("Contact_details", $request);
            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $request->{'contact_id'} = input::get('DetailContactId');
            $insert_id = Module::insert("Contact_details", $request);

            return redirect(config('laraadmin.adminRoute') . '/accounts/' . $id . "#tab-contacts");

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
        if(Module::hasAccess("Contact_details", "edit")) {
            $contactDetail = Contact_detail::find($id);
            if(isset($contactDetail->id)) {
                $module = Module::get('Contact_details');

                $module->row = $contactDetail;

                return response()->json($contactDetail);
            } else {
                return response()->json(['response' => 'error']);
            }
        } else {
            return response()->json(['response' => 'not found']);
        }
    }


    /**
     * Update the specified contact in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id contact ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateModalContactDetail(Request $request, $id)
    {
        // $firstName = Input::get('first_name');
        // $contact_type_id = Input::get('contact_type_id');
        // return response()->json($request);
        //cerca Contacts
        if(Module::hasAccess("Contact_details", "edit")) {

            $contactDetail = Contact_detail::find($id);
            $contact_id = $contactDetail->contact_id;
            $fields = ModuleFields::getModuleFields('Contact_details');

            foreach ($fields as $field => $value) {
                $value_get = Input::get($field);
                if ( $value_get != null ) {
                    $contactDetail->$field = $value_get;
                }else{
                    $contactDetail->$field = "";
                }
            }

            $contactDetail->id = $id;
            $contactDetail->contact_id = $contact_id;
            // $field = 'first_name';
            // $contact->$field = Input::get($field);
            // $contact->last_name = Input::get('last_name');
            // $contact->contact_type_id = Input::get('contact_type_id');
            // $contact->notes = Input::get('notes');
            // $request = $contact->toArray();


            $rules = Module::validateRules("Contact_details", $contactDetail, true);

            $validator = Validator::make($contactDetail->toArray(), $rules);

            if($validator->fails()) {
                return response()->json(['response' => 'noooo']);
            }

            $insert_id = Module::updateRow("Contact_details", $contactDetail, $id);

            if ($contactDetail->contact_detail_type_id > 0) {
                $contact_detail_type = DB::table('contact_detail_types')->select('description','fa_icon')->where('id', $contactDetail->contact_detail_type_id)->first();

                $contactDetail->contact_detail_type_description = $contact_detail_type->description;
                $contactDetail->contact_detail_type_fa_icon = $contact_detail_type->fa_icon;
            }

            if ($contactDetail->communication_type_id > 0) {
                $communication_type = DB::table('communication_types')->select('description','fa_icon')->where('id', $contactDetail->communication_type_id)->first();

                $contactDetail->communication_type_description = $communication_type->description;
                $contactDetail->communication_type_fa_icon = $communication_type->fa_icon;
            }
            return response()->json($contactDetail);

        } else {
            return response()->json(['response' => 'non so']);
        }
    }

    /**
     * Store a newly created contact_detail in database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if(Module::hasAccess("Contact_Details", "create")) {

            $rules = Module::validateRules("Contact_Details", $request);

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $insert_id = Module::insert("Contact_Detail", $request);

            return redirect()->route(config('laraadmin.adminRoute') . '.contact_details.index');

        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Display the specified contact_detail.
     *
     * @param int $id contact_detail ID
     * @return mixed
     */
    public function show($id)
    {
        if(Module::hasAccess("Contact_Details", "view")) {

            $contact_detail = Contact_detail::find($id);
            if(isset($contact_detail->id)) {
                $module = Module::get('Contact_Details');
                $module->row = $contact_detail;

                return view('la.contact_details.show', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                    'no_header' => true,
                    'no_padding' => "no-padding"
                ])->with('contact_detail', $contact_detail);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("contact_detail"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Show the form for editing the specified contact_detail.
     *
     * @param int $id contact_detail ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        if(Module::hasAccess("Contact_Details", "edit")) {
            $contact_detail = Contact_detail::find($id);
            if(isset($contact_detail->id)) {
                $module = Module::get('Contact_Details');

                $module->row = $contact_detail;

                return view('la.contact_details.edit', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                ])->with('contact_detail', $contact_detail);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("contact_detail"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Update the specified contact_detail in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id contact_detail ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if(Module::hasAccess("Contact_Details", "edit")) {

            $rules = Module::validateRules("Contact_Details", $request, true);

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();;
            }

            $insert_id = Module::updateRow("Contact_detail", $request, $id);

            return redirect()->route(config('laraadmin.adminRoute') . '.contact_details.index');

        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Remove the specified contact_detail from storage.
     *
     * @param int $id contact_detail ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if(Module::hasAccess("Contact_Details", "delete")) {
            Contact_detail::find($id)->delete();

            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.contact_details.index');
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Remove the specified contact from storage.
     *
     * @param int $id contact ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete_contact_detail($id)
    {
        if(Module::hasAccess("Contact_details", "delete")) {
            $account_id = Input::get('accountId');
            Contact_detail::find($id)->delete();
            // Redirecting to index() method
            return redirect(config('laraadmin.adminRoute') . '/accounts/' . $account_id . "#tab-contacts");
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
        $module = Module::get('Contact_Details');
        $listing_cols = Module::getListingColumns('Contact_Details');

        $values = DB::table('contact_details')->select($listing_cols)->whereNull('deleted_at');
        $out = Datatables::of($values)->make();
        $data = $out->getData();

        $fields_popup = ModuleFields::getModuleFields('Contact_Details');

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
                    $data->data[$i][$j] = '<a href="' . url(config('laraadmin.adminRoute') . '/contact_details/' . $data->data[$i][0]) . '">' . $data->data[$i][$j] . '</a>';
                }
                // else if($col == "author") {
                //    $data->data[$i][$j];
                // }
            }

            if($this->show_action) {
                $output = '';
                if(Module::hasAccess("Contact_Details", "edit")) {
                    $output .= '<a href="' . url(config('laraadmin.adminRoute') . '/contact_details/' . $data->data[$i][0] . '/edit') . '" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
                }

                if(Module::hasAccess("Contact_Details", "delete")) {
                    $output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.contact_details.destroy', $data->data[$i][0]], 'method' => 'delete', 'style' => 'display:inline']);
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
