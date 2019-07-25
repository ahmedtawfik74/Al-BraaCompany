<?php

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]],
    function() {

        Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function () {
            Route::get('/', 'DashboardController@index')->name('welcome');

            //Route Categoryies
            Route::resource('categories','CategoryController')->except(['show']);

            //Route Products
            Route::resource('products','ProductController')->except(['show']);

            //Route clients
            Route::resource('clients','ClientController')->except(['show']);
            Route::resource('clients.orders','Clients\OrderController')->except(['show']);

            //Route orders
            Route::resource('orders','OrderController')->except(['show']);
            Route::get('/orders/{order}/products', 'OrderController@products')->name('orders.products');
            //Route users
             Route::resource('users','UserController')->except(['show']);

        }); //end of dashboard Routes
    });