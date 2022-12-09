<?php

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
// front-end
Route::get('/trang-chu', 'HomeController@index');
Route::get('/', 'HomeController@index');
Route::post('/tim-kiem', 'HomeController@search');

Route::get('/danh-muc-sach/{id}', 'CategoryProduct@show_category_home');
Route::get('/tac-gia/{id}', 'AuthorController@show_author_home');
Route::get('/chi-tiet-sach/{id}', 'BookController@detail_book');


//back-end
Route::get('/admin', 'AdminController@index');
Route::get('/dashboard', 'AdminController@show_dashboard');
Route::post('/admin-dashboard', 'AdminController@dashboard');
Route::get('/logout', 'AdminController@log_out');

//Category Product
Route::get('/add-category','CategoryProduct@add_category');
Route::get('/all-category','CategoryProduct@all_category');
Route::post('/save-category-product','CategoryProduct@save_category');
Route::get('/active-category-product/{category_id}','CategoryProduct@active_category');
Route::get('/unactive-category-product/{category_id}','CategoryProduct@unactive_category');
Route::get('/edit-category-product/{category_id}','CategoryProduct@edit_category');
Route::post('/update-category-product/{category_id}','CategoryProduct@update_category');
Route::get('/delete-category-product/{category_id}','CategoryProduct@delete_category');

//Auhtor
Route::get('/add-author','AuthorController@add_author');
Route::get('/all-author','AuthorController@all_author');
Route::post('/save-author','AuthorController@save_author');
Route::get('/active-author/{author_id}','AuthorController@active_author');
Route::get('/unactive-author/{author_id}','AuthorController@unactive_author');
Route::get('/edit-author/{author_id}','AuthorController@edit_author');
Route::post('/update-author/{author_id}','AuthorController@update_author');
Route::get('/delete-author/{author_id}','AuthorController@delete_author');

//Book
Route::group(['middleware'=>'auth.roles' ,'auth.roles'=>['admin','author'] ], function(){
    Route::get('/add-book','BookController@add_book');
    Route::get('/edit-book/{book_id}','BookController@edit_book');
});



Route::get('/all-book','BookController@all_book');
Route::post('/save-book','BookController@save_book');
Route::get('/active-book/{book_id}','BookController@active_book');
Route::get('/unactive-book/{book_id}','BookController@unactive_book');
Route::post('/update-book/{book_id}','BookController@update_book');
Route::get('/delete-book/{book_id}','BookController@delete_book');


//Cart
Route::post('/save-cart','CartController@save_cart');
Route::get('/show-cart','CartController@show_cart');
Route::get('/delete-cart/{id}','CartController@delete_cart');
Route::post('/update-cart-quantity','CartController@update_cart_quantity');


//Check
Route::get('/login-checkout','CheckoutController@login_checkout');
Route::get('/logout-checkout','CheckoutController@logout_checkout');
Route::get('/checkout','CheckoutController@checkout');
Route::get('/payment','CheckoutController@payment');
Route::post('/add-customer','CheckoutController@add_customer');
Route::post('/save-checkout-customer','CheckoutController@save_checkout_customer');
Route::post('/login-customer','CheckoutController@login_customer');
Route::post('/order-place','CheckoutController@order_place');
Route::get('/history/{id}','CheckoutController@history');
Route::get('/forget-password','CheckoutController@forget_password');
Route::post('/update-password','CheckoutController@update_password');
Route::get('/update-new-pass','CheckoutController@update_new_pass');
Route::post('/update-new-password','CheckoutController@update_new_password');



//Order
Route::get('/manage-order','CheckoutController@manage_order');
Route::get('/view-order/{id}','CheckoutController@view_order');
Route::get('/all-customer','CheckoutController@all_customer');
Route::get('/cancel-order/{id}','CheckoutController@cancel_order');
Route::get('/history-order-detail/{id}','CheckoutController@history_order_detail');
Route::get('/cancel/{id}','CheckoutController@cancel');
Route::get('/cancel-show-cart','CheckoutController@cancel_show_cart');

//Login facebook
Route::get('/login-facebook','AdminController@login_facebook');
Route::get('/admin/callback','AdminController@callback_facebook');

//Login  google
Route::get('/login-google','AdminController@login_google');
Route::get('/google/callback','AdminController@callback_google');

//Customer Login Google
Route::get('/login-customer-google','AdminController@login_customer_google');
Route::get('/customer/google/callback','AdminController@customer_callback_google');

//Authentication

Route::get('/register-auth','AuthController@register_auth');
Route::post('/register','AuthController@register');
Route::get('/login-auth','AuthController@login_auth');
Route::post('/login','AuthController@login');
Route::get('/logout-auth','AuthController@logout_auth');

//UsersController
Route::group(['middleware'=>'auth.roles' ,'auth.roles'=>['admin','author'] ], function(){
    Route::get('/users','UsersController@index');
   
    Route::post('/assign-roles','UsersController@assign_roles');
    Route::get('/add-user','UsersController@add_user');
    Route::post('/store-user','UsersController@store_user');
    Route::get('/delete-user-roles/{admin_id}','UsersController@delete_user_roles');
});
Route::get('/impersonate/{admin_id}','UsersController@impersonate');
Route::get('/impersonate-destroy','UsersController@impersonate_destroy');