<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(
    array('prefix' => 'admin', 'middleware' => ['RolesAuth']),
    function () {


        
        
        Route::get('/', 'UserController@dashboard')->name('admin.dashboard');
        Route::get('setting', 'SettingController@index')->name('setting');
        Route::post('setting_submit', 'SettingController@setting_submit')->name('setting_submit');
        
        //=======================PROFILE START===========================//
        Route::get('profile', 'UserController@profile')->name('admin.profile');
        Route::post('profile_submit', 'UserController@profile_submit')->name('profile_submit');
        //=======================PROFILE END===========================//
        
        //=======================ACL START===========================//
        Route::match(['get'], 'role_list', 'PermissionRoleController@role_list')->name('permissionrole.role_list');
        Route::match(['get'], 'permission_update/{id}', 'PermissionRoleController@permission_update')->name('permissionrole.permission_update');
        Route::post('permission_update_submit', 'PermissionRoleController@permission_update_submit')->name('permissionrole.permission_update_submit');
        //=======================ACL END===========================//

        //=======================FOR HTML JQUERY CONTROL CHECK START===========================//
        Route::resource('tablename', 'TableNameController');
        Route::get('tablename_delete', 'TableNameController@multiple_delete')->name('tablename.multiple_delete');
        Route::get('tablename_change_status', 'TableNameController@change_status')->name('tablename.change_status');
        Route::get('tablename_exportExcel', 'TableNameController@exportExcel')->name('tablename.export_excel');
        Route::get('tablename_exportCSV', 'TableNameController@exportCSV')->name('tablename.export_csv');
        Route::post('tablename_import', 'TableNameController@import')->name('tablename.import');
        //=======================FOR HTML JQUERY CONTROL CHECK END===========================//
        
        //=======================CREATE CRUD START===========================//
        Route::get('configuration', 'ConfigurationynsController@bismillah')->name('crud.bismillah');
        Route::post('config_store', 'ConfigurationynsController@store')->name('config.store');
        //=======================CREATE CRUD END===========================//
        

    }
);

Route::group(
    array('prefix' => 'admin', 'middleware' => ['XSS']),
    function () {
        Route::get('unauthorized', 'SettingController@unauthorized')->name('setting.unauthorized');
        
        Route::get('login', 'UserController@login')->name('admin.login');
        Route::match(['get', 'post'], 'forgot_password', 'UserController@forgot_password')->name('admin.forgot_password');
        Route::match(['get', 'post'], 'reset_password/{reset_token_hash?}', 'UserController@reset_password')->name('admin.reset_password');
        Route::post('login_submit', 'UserController@login_submit')->name('admin.login_submit');
        Route::get('logout', 'UserController@logout')->name('admin.logout');
        Route::match(['post', 'put'], 'upload_single_image', 'UploadFileController@single_image')->name('admin.upload_single_image');
        Route::match(['post', 'put'], 'remove_single_image', 'UploadFileController@remove_single_image')->name('admin.remove_single_image');
        Route::match(['post', 'put'], 'upload_single_image_crop_compress', 'UploadFileController@single_image_crop_compress')->name('admin.upload_single_image_crop_compress');
        Route::match(['post', 'put'], 'upload_single_video', 'UploadFileController@single_video')->name('admin.upload_single_video');
        Route::match(['post', 'put'], 'remove_single_video', 'UploadFileController@remove_single_video')->name('admin.remove_single_video');
        Route::match(['post', 'put'], 'upload_single_pdf', 'UploadFileController@single_pdf')->name('admin.upload_single_pdf');
        Route::match(['post', 'put'], 'remove_single_pdf', 'UploadFileController@remove_single_pdf')->name('admin.remove_single_pdf');
    }
);
