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

use App\Models\Contact;

class ContactsController extends Controller
{
    public $show_action = true;

    /**
     * Display a listing of the Contacts.
     *
     * @return mixed
     */
    public function index()
    {
        $module = Module::get('Contacts');

        if(Module::hasAccess($module->id)) {
            return View('la.contacts.index', [
                'show_actions' => $this->show_action,
                'listing_cols' => Module::getListingColumns('Contacts'),
                'module' => $module
            ]);
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Show the form for creating a new contact.
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    public function add_contact(Request $request, $id)
    {
        // $contact = $request->input();
        // $contact['account_id'] = $id;
        $request->{'account_id'} = $id;

        if(Module::hasAccess("Contacts", "create")) {

            $rules = Module::validateRules("Contacts", $request);

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $insert_id = Module::insert("Contacts", $request);

            return redirect(config('laraadmin.adminRoute') . '/accounts/' . $id . "#tab-contacts");

        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }



    /**
     * Store a newly created contact in database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if(Module::hasAccess("Contacts", "create")) {

            $rules = Module::validateRules("Contacts", $request);

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $insert_id = Module::insert("Contacts", $request);

            return redirect()->route(config('laraadmin.adminRoute') . '.accounts.show');

        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Display the specified contact.
     *
     * @param int $id contact ID
     * @return mixed
     */
    public function show($id)
    {
        if(Module::hasAccess("Contacts", "view")) {

            $contact = Contact::find($id);
            if(isset($contact->id)) {
                $module = Module::get('Contacts');
                $module->row = $contact;

                return view('la.contacts.show', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                    'no_header' => true,
                    'no_padding' => "no-padding"
                ])->with('contact', $contact);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("contact"),
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
    public function edit($id)
    {
        if(Module::hasAccess("Contacts", "edit")) {
            $contact = Contact::find($id);
            if(isset($contact->id)) {
                $module = Module::get('Contacts');

                $module->row = $contact;

                return view('la.contacts.edit', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                ])->with('contact', $contact);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("contact"),
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
        if(Module::hasAccess("Contacts", "edit")) {
            $contact = Contact::find($id);
            if(isset($contact->id)) {
                $module = Module::get('Contacts');

                $module->row = $contact;

                return response()->json($contact);
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
    public function update(Request $request, $id)
    {
        if(Module::hasAccess("Contacts", "edit")) {

            $rules = Module::validateRules("Contacts", $request, true);

            $validator = Validator::make($request->all(), $rules);
            //dd(json_encode($validator->fails()));
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();;
            }

            $insert_id = Module::updateRow("Contacts", $request, $id);

            return redirect()->route(config('laraadmin.adminRoute') . '.contacts.index');


        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }

    /**
     * Update the specified contact in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id contact ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateModalContact(Request $request, $id)
    {
        // $firstName = Input::get('first_name');
        // $contact_type_id = Input::get('contact_type_id');
        // return response()->json($request);
        //cerca Contacts
        if(Module::hasAccess("Contacts", "edit")) {

            $contact = Contact::find($id);
            $fields = ModuleFields::getModuleFields('Contacts');

            foreach ($fields as $field => $value) {
                $value_get = Input::get($field);
                if ( $value_get != null ) {
                    $contact->$field = $value_get;
                }else{
                    $contact->$field = "";
                }
            }

            $contact->account_id = input::get('accountId');
            // $field = 'first_name';
            // $contact->$field = Input::get($field);
            // $contact->last_name = Input::get('last_name');
            // $contact->contact_type_id = Input::get('contact_type_id');
            // $contact->notes = Input::get('notes');
            // $request = $contact->toArray();


            $rules = Module::validateRules("Contacts", $contact, true);

            $validator = Validator::make($contact->toArray(), $rules);

            if($validator->fails()) {
                return response()->json(['response' => 'noooo']);
            }

            $insert_id = Module::updateRow("Contacts", $contact, $id);
            //add office description
            if ($contact->title_id > 0) {
                $title_description = DB::table('titles')->select('description')->where('id', $contact->title_id)->value('description');
                $contact->title_description = $title_description;
            }

            if ($contact->office_id > 0) {
                $office_description = DB::table('offices')->select('description')->where('id', $contact->office_id)->value('description');
                $contact->office_description = $office_description;
            }

            if ($contact->contact_type_id > 0) {
                $contact_type_description = DB::table('contact_types')->select('description')->where('id', $contact->contact_type_id)->value('description');
                $contact->contact_type_description = $contact_type_description;
            }
            return response()->json($contact);

        } else {
            return response()->json(['response' => 'non so']);
        }
        // if(Module::hasAccess("Contacts", "edit")) {
        //
        //     $rules = Module::validateRules("Contacts", $request, true);
        //
        //     $validator = Validator::make($request->all(), $rules);
        //
        //     if($validator->fails()) {
        //         return response()->json(['response' => 'noooo']);
        //     }
        //
        //     $insert_id = Module::updateRow("Contacts", $request, $id);
        //
        //     return response()->json($request);
        //
        // } else {
        //     return response()->json(['response' => 'due']);
        // }

        // if ($request->isMethod('post')){
        //     return response()->json($request);
        // }
        //
        // return response()->json(['response' => 'This is get method']);
    }

    /**
     * Remove the specified contact from storage.
     *
     * @param int $id contact ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        dd($id);
        if(Module::hasAccess("Contacts", "delete")) {
            Contact::find($id)->delete();

            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.contacts.index');
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
    public function delete_contact($id)
    {
        if(Module::hasAccess("Contacts", "delete")) {
            $account_id = Input::get('accountId');
            Contact::find($id)->delete();
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
        $module = Module::get('Contacts');
        $listing_cols = Module::getListingColumns('Contacts');

        $values = DB::table('contacts')->select($listing_cols)->whereNull('deleted_at');
        $out = Datatables::of($values)->make();
        $data = $out->getData();

        $fields_popup = ModuleFields::getModuleFields('Contacts');

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
                    $data->data[$i][$j] = '<a href="' . url(config('laraadmin.adminRoute') . '/contacts/' . $data->data[$i][0]) . '">' . $data->data[$i][$j] . '</a>';
                }
                // else if($col == "author") {
                //    $data->data[$i][$j];
                // }
            }

            if($this->show_action) {
                $output = '';
                if(Module::hasAccess("Contacts", "edit")) {
                    $output .= '<a href="' . url(config('laraadmin.adminRoute') . '/contacts/' . $data->data[$i][0] . '/edit') . '" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
                }

                if(Module::hasAccess("Contacts", "delete")) {
                    $output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.contacts.destroy', $data->data[$i][0]], 'method' => 'delete', 'style' => 'display:inline']);
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
     * Server side Modal fetch via Ajax
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function modalajax(Request $request)
    {
        $contact = Contact::find($request->id);

        return $contact;
        if(Module::hasAccess("Contacts", "edit")) {
            $contact = Contact::find($id);
            if(isset($contact->id)) {
                $module = Module::get('Contacts');

                $module->row = $contact;

                return view('la.contacts.edit', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                ])->with('contact', $contact);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("contact"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }



        $module = Module::get('Contacts');
        return 'OKK';
        $listing_cols = Module::getListingColumns('Contacts');

        $values = DB::table('contacts')->select($listing_cols)->whereNull('deleted_at');
        $out = Datatables::of($values)->make();
        $data = $out->getData();

        $fields_popup = ModuleFields::getModuleFields('Contacts');

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
                    $data->data[$i][$j] = '<a href="' . url(config('laraadmin.adminRoute') . '/contacts/' . $data->data[$i][0]) . '">' . $data->data[$i][$j] . '</a>';
                }
                // else if($col == "author") {
                //    $data->data[$i][$j];
                // }
            }

            if($this->show_action) {
                $output = '';
                if(Module::hasAccess("Contacts", "edit")) {
                    $output .= '<a href="' . url(config('laraadmin.adminRoute') . '/contacts/' . $data->data[$i][0] . '/edit') . '" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
                }

                if(Module::hasAccess("Contacts", "delete")) {
                    $output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.contacts.destroy', $data->data[$i][0]], 'method' => 'delete', 'style' => 'display:inline']);
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
