<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DetailNoteController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IngredientsController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitsController;
use App\Models\DetailNote;
use App\Models\Supplier;
use Illuminate\Support\Facades\Route;

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
//Trang quan ly
Route::prefix('admin')->group(function(){
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/sign-in', [AdminController::class, 'signIn'])->name('admin.signIn');
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    //Chức vụ
    Route::prefix('role')->group(function(){
        Route::get('/list',[RoleController::class, 'list'])->name('role.list');
        Route::group(['middleware' => 'auth.roles'],function(){
            Route::post('/insert',[RoleController::class, 'insert'])->name('role.insert');
            Route::post('/update',[RoleController::class, 'update'])->name('role.update');
            Route::post('/delete',[RoleController::class, 'delete'])->name('role.delete');
            Route::post('/delete-all',[RoleController::class, 'deleteAll'])->name('role.deleteAll');
        });
    });
    //Tài khoản
    Route::prefix('account')->group(function(){
        Route::get('/list',[AccountController::class, 'list'])->name('account.list');
        Route::get('/setting',[AccountController::class, 'setting'])->name('account.setting');
        Route::post('/update',[AccountController::class, 'updateInfo'])->name('account.update');
        Route::group(['middleware' => 'auth.roles'],function(){
            Route::post('/insert',[AccountController::class, 'insert'])->name('account.insert');
            Route::post('/assign',[AccountController::class, 'assign'])->name('account.assign'); // cap mat khau
            Route::post('/delete', [AccountController::class, 'delete'])->name('account.delete');
            Route::post('/deleteAll',[AccountController::class, 'deleteAll'])->name('account.deleteAll');
        });
    });
    //Danh muc san pham
    Route::prefix('category')->group(function(){
        Route::get('/list',[CategoryController::class, 'list'])->name('category.list');
        Route::post('/insert',[CategoryController::class, 'insert'])->name('category.insert');
        Route::post('/update',[CategoryController::class, 'update'])->name('category.update');
        Route::post('/delete',[CategoryController::class, 'delete'])->name('category.delete');
        Route::post('/delete-all',[CategoryController::class, 'deleteAll'])->name('category.deleteAll');
        
    });
    //San pham
    Route::prefix('product')->group(function(){
        Route::get('/list',[ProductController::class, 'list'])->name('product.list');
        Route::post('/insert',[ProductController::class, 'insert'])->name('product.insert');
        Route::post('/update',[ProductController::class, 'update'])->name('product.update');
        Route::post('/delete',[ProductController::class, 'delete'])->name('product.delete');
        Route::post('/delete-all',[ProductController::class, 'deleteAll'])->name('product.deleteAll');
    });
    //Danh muc anh san pham
    Route::prefix('gallery')->group(function(){
        Route::get('/list',[GalleryController::class, 'list'])->name('gallery.list');
        Route::post('/insert',[GalleryController::class, 'insert'])->name('gallery.insert');
        Route::post('/update',[GalleryController::class, 'update'])->name('gallery.update');
        Route::post('/delete',[GalleryController::class, 'delete'])->name('gallery.delete');
        Route::post('/delete-all',[GalleryController::class, 'deleteAll'])->name('gallery.deleteAll');
    });
    //Nguyen lieu
    Route::prefix('ingredients')->group(function(){
        Route::get('/list',[IngredientsController::class, 'list'])->name('ingredients.list');
        Route::post('/update',[IngredientsController::class, 'update'])->name('ingredients.update');
        Route::post('/delete',[IngredientsController::class, 'delete'])->name('ingredients.delete');
        Route::post('/delete-all',[IngredientsController::class, 'deleteAll'])->name('ingredients.deleteAll');
    });
    //Cong thuc
    Route::prefix('recipe')->group(function(){
        Route::get('/list',[RecipeController::class, 'list'])->name('recipe.list');
        Route::get('/check',[RecipeController::class, 'check'])->name('recipe.check');
        Route::group(['middleware' => 'auth.roles'],function(){
            Route::post('/insert',[RecipeController::class, 'insert'])->name('recipe.insert');
            Route::post('/update',[RecipeController::class, 'update'])->name('recipe.update');
            Route::post('/delete',[RecipeController::class, 'delete'])->name('recipe.delete');
            Route::post('/delete-all',[RecipeController::class, 'deleteAll'])->name('recipe.deleteAll');
        });
    });
    //Don vi
    Route::prefix('units')->group(function(){
        Route::get('/list',[UnitsController::class, 'list'])->name('units.list');
        Route::post('/insert',[UnitsController::class, 'insert'])->name('units.insert');
        Route::post('/update',[UnitsController::class, 'update'])->name('units.update');
        Route::post('/delete',[UnitsController::class, 'delete'])->name('units.delete');
        Route::post('/delete-all',[UnitsController::class, 'deleteAll'])->name('units.deleteAll');
    });
    //Quang cao
    Route::prefix('slide')->group(function(){
        Route::get('/list',[SlideController::class, 'list'])->name('slide.list');
        Route::post('/insert',[SlideController::class, 'insert'])->name('slide.insert');
        Route::post('/update',[SlideController::class, 'update'])->name('slide.update');
        Route::post('/delete',[SlideController::class, 'delete'])->name('slide.delete');
        Route::post('/delete-all',[SlideController::class, 'deleteAll'])->name('slide.deleteAll');
    });
    //Phi van chuyen
    Route::prefix('fee')->group(function(){
        Route::get('/list',[FeeController::class, 'list'])->name('fee.list');
        Route::group(['middleware' => 'auth.roles'],function(){
            Route::post('/insert',[FeeController::class, 'insert'])->name('fee.insert');
            Route::post('/update',[FeeController::class, 'update'])->name('fee.update');
            Route::post('/delete',[FeeController::class, 'delete'])->name('fee.delete');
            Route::post('/delete-all',[FeeController::class, 'deleteAll'])->name('fee.deleteAll');
        });
    });
    //Nha cung cap
    Route::prefix('supplier')->group(function(){
        Route::get('/list',[SupplierController::class, 'list'])->name('supplier.list');
        Route::group(['middleware' => 'auth.roles'],function(){
            Route::post('/insert',[SupplierController::class, 'insert'])->name('supplier.insert');
            Route::post('/update',[SupplierController::class, 'update'])->name('supplier.update');
            Route::post('/delete',[SupplierController::class, 'delete'])->name('supplier.delete');
            Route::post('/delete-all',[SupplierController::class, 'deleteAll'])->name('supplier.deleteAll');
        });
    });
    //Khach hang
    Route::prefix('customer')->group(function(){
        Route::get('/list',[CustomerController::class, 'list'])->name('customer.list');
    });
    //Phieu hang
    Route::prefix('notes')->group(function(){
        Route::get('/list',[NotesController::class, 'list'])->name('notes.list');
        Route::post('/insert',[NotesController::class, 'insert'])->name('notes.insert');
        Route::post('/update',[NotesController::class, 'update'])->name('notes.update');
        Route::post('/delete',[NotesController::class, 'delete'])->name('notes.delete');
        Route::post('/delete-all',[NotesController::class, 'deleteAll'])->name('notes.deleteAll');
    });
    //Chi tiet phieu hang
    Route::prefix('detail')->group(function(){
        Route::get('/list',[DetailNoteController::class, 'list'])->name('detail.list');
        Route::post('/insert',[DetailNoteController::class, 'insert'])->name('detail.insert');
        Route::post('/update',[DetailNoteController::class, 'update'])->name('detail.update');
        Route::post('/delete',[DetailNoteController::class, 'delete'])->name('detail.delete');
        Route::post('/delete-all',[DetailNoteController::class, 'deleteAll'])->name('detail.deleteAll');
        Route::get('/print-pdf',[DetailNoteController::class, 'printPDF'])->name('detail.pdf');
        Route::get('/export',[DetailNoteController::class, 'export'])->name('detail.export');
    });
    //Don dat hang
    Route::prefix('order')->group(function(){
        Route::get('/list',[OrderController::class, 'list'])->name('order.list');
        Route::get('/detail/{code}',[OrderController::class, 'adminDetail'])->name('order.adDetail');
        Route::get('/change',[OrderController::class,'change'])->name('order.change');
        Route::post('/search',[OrderController::class,'search'])->name('order.search');
        Route::post('/filter',[OrderController::class,'filter'])->name('order.filter');
        Route::post('/draw',[OrderController::class,'draw'])->name('order.draw');
        Route::get('/export',[OrderController::class,'export'])->name('order.export');
        Route::get('/check',[OrderController::class,'check'])->name('order.check');
        Route::post('/updateQuantity',[OrderController::class,'updateQuantityAfterOrder'])->name('order.update');
    });
    //Ma khuyen mai
    Route::prefix('coupon')->group(function(){
        Route::get('/list',[CouponController::class, 'list'])->name('coupon.list');
        Route::group(['middleware' => 'auth.roles'],function(){
            Route::post('/insert',[CouponController::class, 'insert'])->name('coupon.insert');
            Route::post('/update',[CouponController::class, 'update'])->name('coupon.update');
            Route::post('/delete',[CouponController::class, 'delete'])->name('coupon.delete');
            Route::post('/delete-all',[CouponController::class, 'deleteAll'])->name('coupon.deleteAll');
        });
    });
    //Danh gia
    Route::prefix('review')->group(function(){
        Route::get('/list',[ReviewController::class, 'list'])->name('review.list');
        Route::post('/reply',[ReviewController::class, 'reply'])->name('review.reply');
        Route::post('/update',[ReviewController::class, 'update'])->name('review.update');
    });
    //Tin tuc
    Route::prefix('news')->group(function(){
        Route::get('/list',[NewsController::class, 'list'])->name('news.list');
        Route::group(['middleware' => 'auth.roles'],function(){
            Route::post('/insert',[NewsController::class, 'insert'])->name('news.insert');
            Route::post('/update',[NewsController::class, 'update'])->name('news.update');
            Route::post('/delete',[NewsController::class, 'delete'])->name('news.delete');
            Route::post('/delete-all',[NewsController::class, 'deleteAll'])->name('news.deleteAll');
        });
    });
    //Thong bao
    Route::prefix('notification')->group(function(){
        Route::post('/one',[NotificationController::class, 'one'])->name('notification.one');
        Route::post('/load',[NotificationController::class, 'load'])->name('notification.load');
    });
});
//Trang nguoi dung
Route::prefix('page')->group(function(){
    Route::get('/',[HomeController::class,'home'])->name('page.home');
    //danh muc
    Route::prefix('category')->group(function(){
        Route::get('/{parent}/{child}',[CategoryController::class,'home'])->name('category.home');
        Route::post('/search',[CategoryController::class,'search'])->name('category.search');
    });
    //san pham
    Route::prefix('product')->group(function(){
        Route::get('/menu',[ProductController::class,'menu'])->name('product.menu');
        Route::get('/{slug}',[ProductController::class,'detail'])->name('product.detail');
    });
    //danh gia 
    Route::prefix('review')->group(function(){
        Route::post('/evalute',[ReviewController::class,'evalute'])->name('review.evalute');
    });
    //khach hang
    Route::prefix('customer')->group(function(){
        Route::post('/register',[CustomerController::class,'register'])->name('customer.register');
        Route::post('/login',[CustomerController::class,'login'])->name('customer.login');
        Route::post('/logout',[CustomerController::class,'logout'])->name('customer.logout');
        Route::post('/forgot',[CustomerController::class,'forgot'])->name('customer.forgot');
        Route::get('/home',[CustomerController::class,'home'])->name('customer.home');
        Route::post('/update',[CustomerController::class,'update'])->name('customer.update');
        Route::post('/updatePassword',[CustomerController::class,'updatePassword'])->name('customer.updatePassword');
    }); 
    //gio hang
    Route::prefix('cart')->group(function(){
        Route::get('/',[CartController::class,'home'])->name('cart.home');
        Route::get('/delete',[CartController::class,'delete'])->name('cart.delete');
        Route::post('/insert',[CartController::class,'insert'])->name('cart.insert');
        Route::post('/update',[CartController::class,'update'])->name('cart.update');
        Route::post('/updateNote',[CartController::class,'updateNote'])->name('cart.updateNote');
    });
    //tin tuc
    Route::prefix('blog')->group(function(){
        Route::get('/',[NewsController::class,'home'])->name('news.home');
        Route::get('/{slug}',[NewsController::class,'detail'])->name('blog.detail');
    });
    //phi van chuyen
    Route::prefix('fee')->group(function(){
        Route::post('/search',[FeeController::class,'search'])->name('fee.search');
    });
    //ma khuyen mai
    Route::prefix('coupon')->group(function(){
        Route::post('/apply',[CouponController::class,'apply'])->name('coupon.apply');
        Route::get('/',[CouponController::class,'home'])->name('coupon.home');
    });
    //dat hang
    Route::prefix('order')->group(function(){
        Route::get('/',[OrderController::class,'home'])->name('order.home');
        Route::post('/apply',[OrderController::class,'apply'])->name('order.apply');
        Route::post('/order',[OrderController::class,'order'])->name('order.order');
        Route::get('/history',[OrderController::class,'history'])->name('order.history');
        Route::get('/detail/{code}',[OrderController::class,'detail'])->name('order.detail');
    });
});
