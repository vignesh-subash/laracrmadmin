<?php

$as = "";
if(\Kipl\Laracrm\Helpers\LCAHelper::laravel_ver() == 5.5) {
	$as = config('laracrm.adminRoute').'.';
}

Route::group([
    'namespace'  => 'Kipl\Laracrm\Controllers',
	'as' => 'admin.',
    'middleware' => ['web', 'auth', 'permission:ADMIN_PANEL', 'role:SUPER_ADMIN']
], function () {

	/* ================== Modules ================== */
	Route::resource(config('laracrm.adminRoute') . '/modules', 'ModuleController');
	Route::resource(config('laracrm.adminRoute') . '/module_fields', 'FieldController');
	Route::get(config('laracrm.adminRoute') . '/module_generate_crud/{model_id}', 'ModuleController@generate_crud');
	Route::get(config('laracrm.adminRoute') . '/module_generate_migr/{model_id}', 'ModuleController@generate_migr');
	Route::get(config('laracrm.adminRoute') . '/module_generate_update/{model_id}', 'ModuleController@generate_update');
	Route::get(config('laracrm.adminRoute') . '/module_generate_migr_crud/{model_id}', 'ModuleController@generate_migr_crud');
	Route::get(config('laracrm.adminRoute') . '/modules/{model_id}/set_view_col/{column_name}', 'ModuleController@set_view_col');
	Route::post(config('laracrm.adminRoute') . '/save_role_module_permissions/{id}', 'ModuleController@save_role_module_permissions');
	Route::get(config('laracrm.adminRoute') . '/save_module_field_sort/{model_id}', 'ModuleController@save_module_field_sort');
	Route::post(config('laracrm.adminRoute') . '/check_unique_val/{field_id}', 'FieldController@check_unique_val');
	Route::get(config('laracrm.adminRoute') . '/module_fields/{id}/delete', 'FieldController@destroy');
	Route::post(config('laracrm.adminRoute') . '/get_module_files/{module_id}', 'ModuleController@get_module_files');

	/* ================== Code Editor ================== */
	Route::get(config('laracrm.adminRoute') . '/lcacodeeditor', function () {
		if(file_exists(resource_path("views/lca/editor/index.blade.php"))) {
			return redirect(config('laracrm.adminRoute') . '/lcaeditor');
		} else {
			// show install code editor page
			return View('lca.editor.install');
		}
	});

	/* ================== Menu Editor ================== */
	Route::resource(config('laracrm.adminRoute') . '/lca_menus', 'MenuController');
	Route::post(config('laracrm.adminRoute') . '/lca_menus/update_hierarchy', 'MenuController@update_hierarchy');

	/* ================== Configuration ================== */
  	Route::resource(config('laracrm.adminRoute') . '/lca_configs', '\App\Http\Controllers\LCA\LCAConfigController');

    Route::group([
        'middleware' => 'role'
    ], function () {
		/*
		Route::get(config('laracrm.adminRoute') . '/menu', [
            'as'   => 'menu',
            'uses' => 'LCAController@index'
        ]);
		*/
    });
});
