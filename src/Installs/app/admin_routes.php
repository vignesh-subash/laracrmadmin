<?php

/* ================== Homepage ================== */
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::auth();

/* ================== Access Uploaded Files ================== */
Route::get('files/{hash}/{name}', 'LCA\UploadsController@get_file');

/*
|--------------------------------------------------------------------------
| Admin Application Routes
|--------------------------------------------------------------------------
*/

$as = "";
if(\Vignesh\Laracrm\Helpers\LCAHelper::laravel_ver() == 5.5) {
	$as = config('laracrm.adminRoute').'.';

	// Routes for Laravel 5.3
	Route::get('/logout', 'Auth\LoginController@logout');
}

Route::group(['as' => 'admin.', 'middleware' => ['auth', 'permission:ADMIN_PANEL']], function () {

	/* ================== Dashboard ================== */

	Route::get(config('laracrm.adminRoute'), 'LCA\DashboardController@index');
	Route::get(config('laracrm.adminRoute'). '/dashboard', 'LCA\DashboardController@index');

	/* ================== Users ================== */
	Route::resource(config('laracrm.adminRoute') . '/users', 'LCA\UsersController');
	Route::get(config('laracrm.adminRoute') . '/user_dt_ajax', 'LCA\UsersController@dtajax');

	/* ================== Uploads ================== */
	Route::resource(config('laracrm.adminRoute') . '/uploads', 'LCA\UploadsController');
	Route::post(config('laracrm.adminRoute') . '/upload_files', 'LCA\UploadsController@upload_files');
	Route::get(config('laracrm.adminRoute') . '/uploaded_files', 'LCA\UploadsController@uploaded_files');
	Route::post(config('laracrm.adminRoute') . '/uploads_update_caption', 'LCA\UploadsController@update_caption');
	Route::post(config('laracrm.adminRoute') . '/uploads_update_filename', 'LCA\UploadsController@update_filename');
	Route::post(config('laracrm.adminRoute') . '/uploads_update_public', 'LCA\UploadsController@update_public');
	Route::post(config('laracrm.adminRoute') . '/uploads_delete_file', 'LCA\UploadsController@delete_file');

	/* ================== Roles ================== */
	Route::resource(config('laracrm.adminRoute') . '/roles', 'LCA\RolesController');
	Route::get(config('laracrm.adminRoute') . '/role_dt_ajax', 'LCA\RolesController@dtajax');
	Route::post(config('laracrm.adminRoute') . '/save_module_role_permissions/{id}', 'LCA\RolesController@save_module_role_permissions');

	/* ================== Permissions ================== */
	Route::resource(config('laracrm.adminRoute') . '/permissions', 'LCA\PermissionsController');
	Route::get(config('laracrm.adminRoute') . '/permission_dt_ajax', 'LCA\PermissionsController@dtajax');
	Route::post(config('laracrm.adminRoute') . '/save_permissions/{id}', 'LCA\PermissionsController@save_permissions');

	/* ================== Departments ================== */
	Route::resource(config('laracrm.adminRoute') . '/departments', 'LCA\DepartmentsController');
	Route::get(config('laracrm.adminRoute') . '/department_dt_ajax', 'LCA\DepartmentsController@dtajax');

	/* ================== Employees ================== */
	Route::resource(config('laracrm.adminRoute') . '/employees', 'LCA\EmployeesController');
	Route::get(config('laracrm.adminRoute') . '/employee_dt_ajax', 'LCA\EmployeesController@dtajax');
	Route::post(config('laracrm.adminRoute') . '/change_password/{id}', 'LCA\EmployeesController@change_password');

	/* ================== Organizations ================== */
	Route::resource(config('laracrm.adminRoute') . '/organizations', 'LCA\OrganizationsController');
	Route::get(config('laracrm.adminRoute') . '/organization_dt_ajax', 'LCA\OrganizationsController@dtajax');

	/* ================== Backups ================== */
	Route::resource(config('laracrm.adminRoute') . '/backups', 'LCA\BackupsController');
	Route::get(config('laracrm.adminRoute') . '/backup_dt_ajax', 'LCA\BackupsController@dtajax');
	Route::post(config('laracrm.adminRoute') . '/create_backup_ajax', 'LCA\BackupsController@create_backup_ajax');
	Route::get(config('laracrm.adminRoute') . '/downloadBackup/{id}', 'LCA\BackupsController@downloadBackup');
});
