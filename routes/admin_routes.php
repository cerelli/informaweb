<?php

/* ================== Homepage ================== */
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::auth();

/* ================== Access Uploaded Files ================== */
Route::get('files/{hash}/{name}', 'LA\UploadsController@get_file');

/*
|--------------------------------------------------------------------------
| Admin Application Routes
|--------------------------------------------------------------------------
*/

$as = "";
if(\Dwij\Laraadmin\Helpers\LAHelper::is_recent_laravel_version()) {
	$as = config('laraadmin.adminRoute').'.';


	// Routes for Laravel 5.3
	Route::get('/logout', 'Auth\LoginController@logout');
}

Route::group(['as' => $as, 'middleware' => ['auth', 'permission:ADMIN_PANEL']], function () {

	/* ================== Dashboard ================== */

	Route::get(config('laraadmin.adminRoute'), 'LA\DashboardController@index');
	Route::get(config('laraadmin.adminRoute'). '/dashboard', 'LA\DashboardController@index');

	/* ================== Users ================== */
	Route::resource(config('laraadmin.adminRoute') . '/users', 'LA\UsersController');
	Route::get(config('laraadmin.adminRoute') . '/user_dt_ajax', 'LA\UsersController@dtajax');

	/* ================== Uploads ================== */
	Route::resource(config('laraadmin.adminRoute') . '/uploads', 'LA\UploadsController');
	Route::post(config('laraadmin.adminRoute') . '/upload_files', 'LA\UploadsController@upload_files');
	Route::get(config('laraadmin.adminRoute') . '/uploaded_files', 'LA\UploadsController@uploaded_files');
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_caption', 'LA\UploadsController@update_caption');
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_filename', 'LA\UploadsController@update_filename');
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_public', 'LA\UploadsController@update_public');
	Route::post(config('laraadmin.adminRoute') . '/uploads_delete_file', 'LA\UploadsController@delete_file');

	/* ================== Roles ================== */
	Route::resource(config('laraadmin.adminRoute') . '/roles', 'LA\RolesController');
	Route::get(config('laraadmin.adminRoute') . '/role_dt_ajax', 'LA\RolesController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/save_module_role_permissions/{id}', 'LA\RolesController@save_module_role_permissions');

	/* ================== Permissions ================== */
	Route::resource(config('laraadmin.adminRoute') . '/permissions', 'LA\PermissionsController');
	Route::get(config('laraadmin.adminRoute') . '/permission_dt_ajax', 'LA\PermissionsController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/save_permissions/{id}', 'LA\PermissionsController@save_permissions');

	/* ================== Departments ================== */
	Route::resource(config('laraadmin.adminRoute') . '/departments', 'LA\DepartmentsController');
	Route::get(config('laraadmin.adminRoute') . '/department_dt_ajax', 'LA\DepartmentsController@dtajax');

	/* ================== Employees ================== */
	Route::resource(config('laraadmin.adminRoute') . '/employees', 'LA\EmployeesController');
	Route::get(config('laraadmin.adminRoute') . '/employee_dt_ajax', 'LA\EmployeesController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/change_password/{id}', 'LA\EmployeesController@change_password');

	/* ================== Organizations ================== */
	Route::resource(config('laraadmin.adminRoute') . '/organizations', 'LA\OrganizationsController');
	Route::get(config('laraadmin.adminRoute') . '/organization_dt_ajax', 'LA\OrganizationsController@dtajax');

	/* ================== Backups ================== */
	Route::resource(config('laraadmin.adminRoute') . '/backups', 'LA\BackupsController');
	Route::get(config('laraadmin.adminRoute') . '/backup_dt_ajax', 'LA\BackupsController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/create_backup_ajax', 'LA\BackupsController@create_backup_ajax');
	Route::get(config('laraadmin.adminRoute') . '/downloadBackup/{id}', 'LA\BackupsController@downloadBackup');

    /* ================== Titles ================== */
    Route::resource(config('laraadmin.adminRoute') . '/titles', 'LA\TitlesController');
    Route::get(config('laraadmin.adminRoute') . '/title_dt_ajax', 'LA\TitlesController@dtajax');

    /* ================== Account_Types ================== */
    Route::resource(config('laraadmin.adminRoute') . '/account_types', 'LA\Account_TypesController');
    Route::get(config('laraadmin.adminRoute') . '/account_type_dt_ajax', 'LA\Account_TypesController@dtajax');

    /* ================== Accounts ================== */
    Route::resource(config('laraadmin.adminRoute') . '/accounts', 'LA\AccountsController');
    Route::get(config('laraadmin.adminRoute') . '/account_dt_ajax', 'LA\AccountsController@dtajax');
	Route::get(config('laraadmin.adminRoute') . '/account_access_right', 'LA\AccountsController@usersAccessRights');
	Route::post(config('laraadmin.adminRoute') . '/save_account_access_rights/{id}', 'LA\AccountsController@saveAccountAccessRights');
	Route::post(config('laraadmin.adminRoute') . '/accounts/edit_contact', 'LA\AccountsController@edit_contact');
	Route::post(config('laraadmin.adminRoute') . '/update_contact', 'LA\AccountsController@update_contact')->name('updateContact');

    /* ================== Contact_detail_types ================== */
    Route::resource(config('laraadmin.adminRoute') . '/contact_detail_types', 'LA\Contact_detail_typesController');
    Route::get(config('laraadmin.adminRoute') . '/contact_detail_type_dt_ajax', 'LA\Contact_detail_typesController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/add_contact_detail/{id}', 'LA\Contact_detailsController@add_contact_detail');

    /* ================== Communication_types ================== */
    Route::resource(config('laraadmin.adminRoute') . '/communication_types', 'LA\Communication_typesController');
    Route::get(config('laraadmin.adminRoute') . '/communication_type_dt_ajax', 'LA\Communication_typesController@dtajax');

    /* ================== Contact_types ================== */
    Route::resource(config('laraadmin.adminRoute') . '/contact_types', 'LA\Contact_typesController');
    Route::get(config('laraadmin.adminRoute') . '/contact_type_dt_ajax', 'LA\Contact_typesController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/add_contact/{id}', 'LA\ContactsController@add_contact');


    /* ================== Offices ================== */
    Route::resource(config('laraadmin.adminRoute') . '/offices', 'LA\OfficesController');
    Route::get(config('laraadmin.adminRoute') . '/office_dt_ajax', 'LA\OfficesController@dtajax');

    /* ================== Contacts ================== */
    Route::resource(config('laraadmin.adminRoute') . '/contacts', 'LA\ContactsController');
    Route::get(config('laraadmin.adminRoute') . '/contact_dt_ajax', 'LA\ContactsController@dtajax');
    Route::post(config('laraadmin.adminRoute') . '/contact_modal_ajax', 'LA\ContactsController@modalajax');
	Route::post(config('laraadmin.adminRoute') . '/updateModalContact/{id}', 'LA\ContactsController@updateModalContact')->name('updateModalContact');
	Route::get(config('laraadmin.adminRoute') . '/editModalContact/{id}', 'LA\ContactsController@editModal');
	Route::post(config('laraadmin.adminRoute') . '/delete_contact/{id}', 'LA\ContactsController@delete_contact')->name('delete_contact');

    /* ================== ContactDetails ================== */
    Route::resource(config('laraadmin.adminRoute') . '/contact_details', 'LA\Contact_detailsController');
    Route::get(config('laraadmin.adminRoute') . '/contact_detail_dt_ajax', 'LA\Contact_detailsController@dtajax');
	Route::get(config('laraadmin.adminRoute') . '/editModalContactDetail/{id}', 'LA\Contact_detailsController@editModal');
	Route::post(config('laraadmin.adminRoute') . '/updateModalContactDetail/{id}', 'LA\Contact_detailsController@updateModalContactDetail')->name('updateModalContactDetail');
	Route::post(config('laraadmin.adminRoute') . '/delete_contact_detail/{id}', 'LA\Contact_detailsController@delete_contact_detail')->name('delete_contact_detail');

    /* ================== Addresses ================== */
    Route::resource(config('laraadmin.adminRoute') . '/addresses', 'LA\AddressesController');
    Route::get(config('laraadmin.adminRoute') . '/address_dt_ajax', 'LA\AddressesController@dtajax');

    /* ================== Localities ================== */
    Route::resource(config('laraadmin.adminRoute') . '/localities', 'LA\LocalitiesController');
    Route::get(config('laraadmin.adminRoute') . '/locality_dt_ajax', 'LA\LocalitiesController@dtajax');
    Route::get(config('laraadmin.adminRoute') . '/locality_select_dtajax', 'LA\LocalitiesController@select_dtajax');


    /* ================== Address_types ================== */
    Route::resource(config('laraadmin.adminRoute') . '/address_types', 'LA\Address_typesController');
    Route::get(config('laraadmin.adminRoute') . '/address_type_dt_ajax', 'LA\Address_typesController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/delete_address/{id}', 'LA\AddressesController@delete_address')->name('delete_address');
	Route::post(config('laraadmin.adminRoute') . '/updateModalAddress/{id}', 'LA\AddressesController@updateModalAddress')->name('updateModalAddress');
	Route::get(config('laraadmin.adminRoute') . '/editModalAddress/{id}', 'LA\AddressesController@editModal');
	Route::post(config('laraadmin.adminRoute') . '/add_address/{account_id}', 'LA\AddressesController@add_address');
});
