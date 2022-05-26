<?php

/* dashboard routes */
Route::get('/', function () {
    return redirect('/admin/dashboard');
});

/* dashboard */
Route::get('/dashboard', [
    'uses' => '\App\Http\Controllers\AdminDashboardController@index',
    'as' => 'admin.dashboard',
]);
/* dashboard */

/* profile */
Route::get('/profile', [
    'uses' => '\App\Http\Controllers\AdminDashboardController@profile',
    'as' => 'admin.profile',
]);

Route::post('/profile/{id}/update', [
    'uses' => '\App\Http\Controllers\AdminDashboardController@profileUpdate',
    'as' => 'admin.profile.update',
]);

Route::post('/profile/{id}/update_password', [
    'uses' => '\App\Http\Controllers\AdminDashboardController@passwordUpdate',
    'as' => 'admin.profile.update_password',
]);
/* profile */

/* roles */
Route::resource('/roles', 'Admin\RoleController', [
    'as' => 'admin',
    'except' => ['show']
]);
Route::delete('/roles/{id}/delete',
    ['as' => 'admin.roles.delete',
        'uses' => '\App\Http\Controllers\Admin\RoleController@destroy']
);
Route::get('roles/{id}/restore', 'Admin\RoleController@restore')->name('admin.roles.restore');
/* roles */

/* permissions */
Route::resource('/permissions', 'Admin\PermissionController', [
    'as' => 'admin',
    'except' => ['show']
]);

Route::delete('/permissions/{id}/delete',
    ['as' => 'admin.permissions.delete',
        'uses' => '\App\Http\Controllers\Admin\PermissionController@destroy']
);
/* permissions */

/* permission groups */
Route::resource('/permission_groups', 'Admin\PermissionGroupController', [
    'as' => 'admin',
    'except' => ['show']
]);

Route::delete('/permission_groups/{id}/delete',
    ['as' => 'admin.permission_groups.delete',
        'uses' => '\App\Http\Controllers\Admin\PermissionGroupController@destroy']
);
/* permission groups */

/* users */
Route::resource('/users', 'Admin\UserController', [
    'as' => 'admin',
    'except' => ['show']
]);
Route::delete('/users/{id}/delete',
    ['as' => 'admin.users.delete',
        'uses' => '\App\Http\Controllers\Admin\UserController@destroy']
);
Route::get('users/{id}/restore', 'Admin\UserController@restore')->name('admin.users.restore');
/* users */

/* system settings */
Route::resource('/system_settings', 'Admin\SystemSettingController', [
    'as' => 'admin',
    'except' => ['show']
]);
Route::delete('/system_settings/{id}/delete',
    ['as' => 'admin.system_settings.delete',
    'uses' => '\App\Http\Controllers\Admin\SystemSettingController@destroy']
);
Route::get('system_settings/{id}/restore', 'Admin\SystemSettingController@restore')->name('admin.system_settings.restore');
/* system settings */

/* activity logs */
Route::resource('/activity_logs', 'Admin\ActivityLogController', [
    'as' => 'admin',
    'only' => ['index']
]);
/* activity logs */

/* pages */
Route::resource('/pages', 'Admin\PageController', [
    'as' => 'admin',
    'except' => ['show']
]);
Route::delete('/pages/{id}/delete',
    ['as' => 'admin.pages.delete',
        'uses' => '\App\Http\Controllers\Admin\PageController@destroy']
);
Route::get('pages/{id}/restore', 'Admin\PageController@restore')->name('admin.pages.restore');

Route::post('/upload', '\App\Http\Controllers\Admin\PageController@upload')->name('admin.upload');

Route::get('pages/{id}/fetchAttachment', '\App\Http\Controllers\Admin\PageController@fetchAttachment')->name('admin.pages.fetchAttachment');
/* pages */

/* ckeditor image upload */
Route::post('/ckeditor_image_upload',
    ['as' => 'admin.ckeditor_image_upload',
        'uses' => '\App\Http\Controllers\Admin\PageController@ckEditorImageUpload']
);
/* ckeditor image upload */

/* gallery groups */
Route::resource('/gallery_groups', 'Admin\GalleryGroupController', [
    'as' => 'admin',
    'except' => ['show']
]);
Route::delete('/gallery_groups/{id}/delete',
    ['as' => 'admin.gallery_groups.delete',
    'uses' => '\App\Http\Controllers\Admin\GalleryGroupController@destroy']
);
Route::get('gallery_groups/{id}/restore', 'Admin\GalleryGroupController@restore')->name('admin.gallery_groups.restore');
/* gallery groups */

/* gallery images */
Route::resource('/gallery_images', 'Admin\GalleryImageController', [
    'as' => 'admin',
    'except' => ['show']
]);
Route::delete('/gallery_images/{id}/delete',
    ['as' => 'admin.gallery_images.delete',
    'uses' => '\App\Http\Controllers\Admin\GalleryImageController@destroy']
);
Route::get('gallery_images/{id}/restore', 'Admin\GalleryImageController@restore')->name('admin.gallery_images.restore');
/* gallery images */

/* blog categories */
Route::resource('/blog_categories', 'Admin\BlogCategoryController', [
    'as' => 'admin',
    'except' => ['show']
]);
Route::delete('/blog_categories/{id}/delete',
    ['as' => 'admin.blog_categories.delete',
    'uses' => '\App\Http\Controllers\Admin\BlogCategoryController@destroy']
);
Route::get('blog_categories/{id}/restore', 'Admin\BlogCategoryController@restore')->name('admin.blog_categories.restore');
/* blog categories */

/* blogs */
Route::resource('/blogs', 'Admin\BlogController', [
    'as' => 'admin',
    'except' => ['show']
]);
Route::delete('/blogs/{id}/delete',
    ['as' => 'admin.blogs.delete',
    'uses' => '\App\Http\Controllers\Admin\BlogController@destroy']
);
Route::get('blogs/{id}/restore', 'Admin\BlogController@restore')->name('admin.blogs.restore');
/* blogs */

/* contacts */
Route::resource('/contacts', '\App\Http\Controllers\Admin\ContactController', [
    'as' => 'admin'
]);
/* contact */

/* newsletter subscribers */
Route::resource('/newsletters', '\App\Http\Controllers\Admin\NewsletterController', [
    'as' => 'admin'
]);
/* newsletter subscribers */

/* menu */
Route::resource('/menu', 'Admin\MenuController', [
    'as' => 'admin',
    'except' => ['show']
]);
Route::delete('/menu/{id}/delete',
    ['as' => 'admin.menu.delete',
    'uses' => '\App\Http\Controllers\Admin\MenuController@destroy']
);
Route::get('menu/{id}/restore', 'Admin\MenuController@restore')->name('admin.menu.restore');
/* menu */

/* menu dropdown */
Route::resource('/dropdown_menu', 'Admin\MenuDropdownController', [
    'as' => 'admin',
    'except' => ['show']
]);
Route::delete('/dropdown_menu/{id}/delete',
    ['as' => 'admin.dropdown_menu.delete',
    'uses' => '\App\Http\Controllers\Admin\MenuDropdownController@destroy']
);
Route::get('dropdown_menu/{id}/restore', 'Admin\MenuDropdownController@restore')->name('admin.dropdown_menu.restore');
/* menu dropdown */

/* product category */
Route::resource('/product_categories', 'Admin\ProductCategoryController', [
    'as' => 'admin',
    'except' => ['show']
]);
Route::delete('/product_categories/{id}/delete',
    ['as' => 'admin.product_categories.delete',
    'uses' => '\App\Http\Controllers\Admin\ProductCategoryController@destroy']
);
Route::get('product_categories/{id}/restore', 'Admin\ProductCategoryController@restore')->name('admin.product_categories.restore');
/* product category */

/* product */
Route::resource('/products', 'Admin\ProductController', [
    'as' => 'admin',
    'except' => ['show']
]);
Route::delete('/products/{id}/delete',
    ['as' => 'admin.products.delete',
    'uses' => '\App\Http\Controllers\Admin\ProductController@destroy']
);
Route::get('products/{id}/restore', 'Admin\ProductController@restore')->name('admin.products.restore');
Route::post('/products/{id}/gallery/upload', '\App\Http\Controllers\Admin\ProductController@galleryUpload')->name('admin.products.gallery.upload');
Route::delete('/products/{id}/gallery/delete', '\App\Http\Controllers\Admin\ProductController@galleryDelete')->name('admin.products.gallery.delete');
/* product */

/* coupon_codes */
Route::resource('/coupon_codes', 'Admin\CouponCodeController', [
    'as' => 'admin'
]);

Route::delete('/coupon_codes/{id}/delete',[
    'as' => 'admin.coupon_codes.delete',
    'uses' => '\App\Http\Controllers\Admin\CouponCodeController@destroy'
]);
Route::get('coupon_codes/{id}/restore', 'Admin\CouponCodeController@restore')->name('admin.coupon_codes.restore');
/* coupon_codes */

/* taxes */
Route::resource('/taxes', 'Admin\TaxController', [
    'as' => 'admin',
    'except' => 'show'
]);

Route::delete('/taxes/{id}/delete',[
    'as' => 'admin.taxes.delete',
    'uses' => '\App\Http\Controllers\Admin\TaxController@destroy'
]);
Route::get('taxes/{id}/restore', 'Admin\TaxController@restore')->name('admin.taxes.restore');
/* taxes */