<?php

// use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminProductAttributeController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminMenuController;
use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\AdminFilemanagerController;
use App\Http\Controllers\Admin\AdminSettingsController;

use App\Http\Controllers\Frontend\FrontendPageController;
use App\Http\Controllers\Frontend\FrontendCartController;
use App\Http\Controllers\Frontend\FrontendOrderController;
use App\Http\Controllers\Frontend\FrontendProductController;
// use App\Livewire\Frontend\FrontendCartController;

use App\Http\Controllers\FrontendController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['middleware' => 'auth'])->group(function () {

    Route::resource('/admin/dashboard', AdminDashboardController::class)->names([
        'index' => 'dashboard.index',
        'create' => 'dashboard.create'
    ]);

    // Products
    Route::get('/admin/products/search', [AdminProductController::class, 'search']);
    Route::post('/admin/products/{id}', [AdminProductController::class, 'setVisibility']);
    Route::get('/admin/products/{id}/delete', [AdminProductController::class, 'delete']);
    Route::resource('/admin/products', AdminProductController::class)->names([
        'index' => 'products.index',
        'create' => 'products.create',
        'update' => 'products.update'
    ]);

    // Products Attributes
    Route::get('/attributes-values/{id}', [AdminProductAttributeController::class, 'getAttributeValues'])->name('ajaxAttributeValues');
    Route::get('/admin/attributes/search', [AdminProductAttributeController::class, 'search']);
    Route::post('/admin/attributes/{id}', [AdminProductAttributeController::class, 'setVisibility']);
    Route::get('/admin/attributes/{id}/delete', [AdminProductAttributeController::class, 'delete'])->name('attributes.delete');
    Route::get('/admin/attribute/value/{id}/delete', [AdminProductAttributeController::class, 'deleteAttributeValue'])->name('attribute_value.delete');
    Route::post('/admin/attribute/value/{id}/delete', [AdminProductAttributeController::class, 'destroyAttributeValue'])->name('attribute_value.destroy');
    Route::resource('/admin/attributes', AdminProductAttributeController::class)->names([
        'index' => 'attributes.index',
        'create' => 'attributes.create',
        'update' => 'attributes.update',
        'destroy' => 'attributes.destroy'
    ]);

    // Orders
    // Route::get('/admin/orders/{id}', [AdminOrderController::class, 'setVisibility']);
    Route::get('/admin/orders/{id}/delete', [AdminOrderController::class, 'delete']);
    Route::resource('/admin/orders', AdminOrderController::class)->names([
        'index' => 'orders.index',
        'create' => 'orders.create',
        'update' => 'orders.update',
    ]);

    // Categories
    Route::get('/admin/category/search', [AdminCategoryController::class, 'search']);
    Route::post('/admin/category/{id}', [AdminCategoryController::class, 'setVisibility']);
    Route::get('/admin/category/{id}/delete', [AdminCategoryController::class, 'delete']);
    Route::resource('/admin/category', AdminCategoryController::class)->names([
        'index' => 'category.index',
        'create' => 'category.create'
    ]);

    // Users
    Route::get('/admin/users/search', [AdminUserController::class, 'search']);
    Route::post('/admin/users/{id}', [AdminUserController::class, 'setVisibility']);
    Route::get('/admin/users/{id}/delete', [AdminUserController::class, 'delete']);
    Route::resource('/admin/users', AdminUserController::class)->names([
        'index' => 'users.index',
        'create' => 'users.create'
    ]);

    // Menu
    Route::get('/admin/menu/search', [AdminMenuController::class, 'search']);
    Route::post('/admin/menu/{id}', [AdminMenuController::class, 'setVisibility']);
    Route::get('/admin/menu/{id}/delete', [AdminMenuController::class, 'delete']);
    Route::resource('/admin/menu', AdminMenuController::class)->names([
        'index' => 'menu.index',
        'create' => 'menu.create'
    ]);

    // Page
    Route::get('/admin/page/search', [AdminPageController::class, 'search']);
    Route::post('/admin/page/{id}', [AdminPageController::class, 'setVisibility']);
    Route::get('/admin/page/{id}/delete', [AdminPageController::class, 'delete']);
    Route::resource('/admin/page', AdminPageController::class)->names([
        'index' => 'page.index',
        'create' => 'page.create'
    ]);

    // Settings
    // Route::get('/admin/orders/{id}', [AdminOrderController::class, 'setVisibility']);
    Route::get('/admin/settings/{id}/delete', [AdminSettingsController::class, 'delete']);
    Route::resource('/admin/settings', AdminSettingsController::class)->names([
        'index' => 'settings.index',
        'create' => 'settings.create',
        'update' => 'settings.update',
    ]);

    // Filemanager
    // Route::get('/admin/file', [AdminFilemanagerController::class, 'index'])->name('admin.media');
    Route::get('/admin/files', [AdminFilemanagerController::class, 'standalone']);
    // Route::get('/admin/files/ckeditor', [AdminFilemanagerController::class, 'ckeditor']);
    // Route::get('/admin/media/connector', [AdminFilemanagerController::class, 'showConnector']);
    // Route::get('/elfinder/connector', [AdminFilemanagerController::class, 'showConnector'])->name('admin.media.connector');

});



// Frontend routes

Route::get('/', [FrontendPageController::class, 'home']);

// Products
Route::get('/p/{id}-{link}', [FrontendProductController::class, 'viewProduct'])->name('viewProduct');

// All products
Route::get('/all', [FrontendProductController::class, 'all'])->name('all');


Route::prefix('/checkout')->group(function () {
    Route::get('/cart', function () {
        return view('frontend/store.cart');
    });

    Route::get('/place-order', function () {
        return view('frontend/store.place-order');
    });
    Route::post('/place-order', [FrontendOrderController::class, 'post_order'])->name('post_order');
    Route::get('/success', [FrontendOrderController::class, 'success'])->name('checkout.success');
    Route::get('/cancel', [FrontendOrderController::class, 'cancel'])->name('checkout.cancel');
});

Route::post('/add-cart', [FrontendCartController::class, 'addCart'])->name('addCart');
Route::get('/cart/remove/{id}', [FrontendCartController::class, 'getRemoveCart'])->name('getRemoveCart');
Route::post('/cart/remove', [FrontendCartController::class, 'postRemoveCart'])->name('postRemoveCart');
Route::get('/cart-destroy', [FrontendCartController::class, 'destroyCart'])->name('destroyCart');

Route::prefix('/pages')->group(function () {
    Route::get('/responsibility', function () {
        return view('frontend/pages.responsibility');
    });
    Route::get('/our-story', function () {
        return view('frontend/pages.our-story');
    });
});

// Route::get('/', [FrontendController::class, 'pages'])->name('home');
// Route::get('{path}/{page}', [FrontendController::class, 'pages_in_dir'])->where('path', '.+');

// Route::get('{page}', [FrontendController::class, 'pages']);



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });


require __DIR__.'/auth.php';
