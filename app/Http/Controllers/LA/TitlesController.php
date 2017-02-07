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

use App\Models\Title;

class TitlesController extends Controller
{
    public $show_action = true;
    
    /**
     * Display a listing of the Titles.
     *
     * @return mixed
     */
    public function index()
    {
        $module = Module::get('Titles');
        
        if(Module::hasAccess($module->id)) {
            return View('la.titles.index', [
                'show_actions' => $this->show_action,
                'listing_cols' => Module::getListingColumns('Titles'),
                'module' => $module
            ]);
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Show the form for creating a new title.
     *
     * @return mixed
     */
    public function create()
    {
        //
    }
    
    /**
     * Store a newly created title in database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if(Module::hasAccess("Titles", "create")) {
            
            $rules = Module::validateRules("Titles", $request);
            
            $validator = Validator::make($request->all(), $rules);
            
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $insert_id = Module::insert("Titles", $request);
            
            return redirect()->route(config('laraadmin.adminRoute') . '.titles.index');
            
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Display the specified title.
     *
     * @param int $id title ID
     * @return mixed
     */
    public function show($id)
    {
        if(Module::hasAccess("Titles", "view")) {
            
            $title = Title::find($id);
            if(isset($title->id)) {
                $module = Module::get('Titles');
                $module->row = $title;
                
                return view('la.titles.show', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                    'no_header' => true,
                    'no_padding' => "no-padding"
                ])->with('title', $title);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("title"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Show the form for editing the specified title.
     *
     * @param int $id title ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        if(Module::hasAccess("Titles", "edit")) {
            $title = Title::find($id);
            if(isset($title->id)) {
                $module = Module::get('Titles');
                
                $module->row = $title;
                
                return view('la.titles.edit', [
                    'module' => $module,
                    'view_col' => $module->view_col,
                ])->with('title', $title);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("title"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Update the specified title in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id title ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if(Module::hasAccess("Titles", "edit")) {
            
            $rules = Module::validateRules("Titles", $request, true);
            
            $validator = Validator::make($request->all(), $rules);
            
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();;
            }
            
            $insert_id = Module::updateRow("Titles", $request, $id);
            
            return redirect()->route(config('laraadmin.adminRoute') . '.titles.index');
            
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    
    /**
     * Remove the specified title from storage.
     *
     * @param int $id title ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if(Module::hasAccess("Titles", "delete")) {
            Title::find($id)->delete();
            
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.titles.index');
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
        $module = Module::get('Titles');
        $listing_cols = Module::getListingColumns('Titles');
        
        $values = DB::table('titles')->select($listing_cols)->whereNull('deleted_at');
        $out = Datatables::of($values)->make();
        $data = $out->getData();
        
        $fields_popup = ModuleFields::getModuleFields('Titles');
        
        for($i = 0; $i < count($data->data); $i++) {
            for($j = 0; $j < count($listing_cols); $j++) {
                $col = $listing_cols[$j];
                if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
                    $data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
                }
                if($col == $module->view_col) {
                    $data->data[$i][$j] = '<a href="' . url(config('laraadmin.adminRoute') . '/titles/' . $data->data[$i][0]) . '">' . $data->data[$i][$j] . '</a>';
                }
                // else if($col == "author") {
                //    $data->data[$i][$j];
                // }
            }
            
            if($this->show_action) {
                $output = '';
                if(Module::hasAccess("Titles", "edit")) {
                    $output .= '<a href="' . url(config('laraadmin.adminRoute') . '/titles/' . $data->data[$i][0] . '/edit') . '" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
                }
                
                if(Module::hasAccess("Titles", "delete")) {
                    $output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.titles.destroy', $data->data[$i][0]], 'method' => 'delete', 'style' => 'display:inline']);
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
