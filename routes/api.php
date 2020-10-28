<?php

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Laravue\Faker;
use \App\Laravue\JsonResponse;
use \App\Laravue\Acl;
use Stripe\ApiResource;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Api')->group(function () {
    Route::post('auth/login', 'AuthController@login');
    Route::post('transactions/charge-card', 'TransactionController@chargeCard');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        // Auth routes
        Route::get('auth/user', 'AuthController@user');
        Route::post('auth/logout', 'AuthController@logout');

        Route::get('/user', function (Request $request) {
            return new UserResource($request->user());
        });

        // Api resource routes//
        Route::apiResource('roles', 'RoleController')->middleware('permission:' . Acl::PERMISSION_PERMISSION_MANAGE);
        Route::apiResource('users', 'UserController')->middleware('permission:' . Acl::PERMISSION_USER_MANAGE);
        Route::apiResource('permissions', 'PermissionController')->middleware('permission:' . Acl::PERMISSION_PERMISSION_MANAGE);

        // Custom routes
        Route::put('users/{user}', 'UserController@update');
        Route::get('users/{user}/permissions', 'UserController@permissions')->middleware('permission:' . Acl::PERMISSION_PERMISSION_MANAGE);
        Route::put('users/{user}/permissions', 'UserController@updatePermissions')->middleware('permission:' . Acl::PERMISSION_PERMISSION_MANAGE);
        Route::get('roles/{role}/permissions', 'RoleController@permissions')->middleware('permission:' . Acl::PERMISSION_PERMISSION_MANAGE);

        // Order routes
        Route::get('orders-deleted/', 'OrderController@getAllDeleted')->middleware('permission:manage order');
        Route::put('orders/{order}/status', 'OrderController@processOrder')->middleware('permission:manage order');
        Route::put('transactions/{transaction}', 'TransactionController@processTransaction')->middleware('permission:manage order');
        Route::apiResource('orders', 'OrderController')->except(['update'])->middleware('permission:manage order');;

         // Api Blogs resource routes
         Route::apiResource('blog-categories', 'BlogCategoryController');
         Route::apiResource('blog-items', 'BlogItemController');

         // custom Blog Category routes
         Route::get('trashed/blog-categories', 'BlogCategoryController@trashed');
         Route::put('restore/blog-categories/{blog_category}', 'BlogCategoryController@restore');

         // custom Blog Item routes
         Route::get('trashed/blog-items', 'BlogItemController@trashed');
         Route::put('restore/blog-items/{blog_item}', 'BlogItemController@restore');

         Route::put('deactivate/blog-items/{blog_item}', 'BlogItemController@deactivate');
         Route::put('activate/blog-items/{blog_item}', 'BlogItemController@activate');

        // Category routes
        Route::apiResource('categories', 'CategoryController')->middleware('permission:manage category');
        Route::get('categories-with-trash', 'CategoryController@getListWithTrash')->middleware('permission:view category|manage category');
        Route::get('categories-only-trash-paginate', 'CategoryController@getListOnlyTrash')->middleware('permission:view category|manage category');
        Route::put('categories/restore/{unique_id}', 'CategoryController@restore')->middleware('permission:manage category');
        // Product routes
        Route::apiResource('products', 'ProductController')->middleware('permission:manage product');
        Route::get('products-only-trash-paginate', 'ProductController@getListOnlyTrash')->middleware('permission:view product|manage product');
        Route::put('products/restore/{unique_id}', 'ProductController@restore')->middleware('permission:manage product');
        // contact routes
        Route::apiResource('contact', 'ContactController')->middleware('permission:manage contact');
        Route::get('contact', 'ContactController@index')->middleware('permission:view contact');
        Route::get('contact-only-trash-paginate', 'ContactController@getListOnlyTrash')->middleware('permission:manage contact');
        Route::put('contact/restore/{unique_id}', 'ContactController@restore')->middleware('permission:manage product');

    });
});

// Fake APIs
Route::get('/table/list', function () {
    $rowsNumber = mt_rand(20, 30);
    $data = [];
    for ($rowIndex = 0; $rowIndex < $rowsNumber; $rowIndex++) {
        $row = [
            'author' => Faker::randomString(mt_rand(5, 10)),
            'display_time' => Faker::randomDateTime()->format('Y-m-d H:i:s'),
            'id' => mt_rand(100000, 100000000),
            'pageviews' => mt_rand(100, 10000),
            'status' => Faker::randomInArray(['deleted', 'published', 'draft']),
            'title' => Faker::randomString(mt_rand(20, 50)),
        ];

        $data[] = $row;
    }

    return response()->json(new JsonResponse(['items' => $data]));
});

// Route::get('/orders', function () {
//     $rowsNumber = 8;
//     $data = [];
//     for ($rowIndex = 0; $rowIndex < $rowsNumber; $rowIndex++) {
//         $row = [
//             'order_no' => 'LARAVUE' . mt_rand(1000000, 9999999),
//             'price' => mt_rand(10000, 999999),
//             'status' => Faker::randomInArray(['success', 'pending']),
//         ];

//         $data[] = $row;
//     }

//     return response()->json(new JsonResponse(['items' => $data]));
// });

Route::get('/articles', function () {
    $rowsNumber = 10;
    $data = [];
    for ($rowIndex = 0; $rowIndex < $rowsNumber; $rowIndex++) {
        $row = [
            'id' => mt_rand(100, 10000),
            'display_time' => Faker::randomDateTime()->format('Y-m-d H:i:s'),
            'title' => Faker::randomString(mt_rand(20, 50)),
            'author' => Faker::randomString(mt_rand(5, 10)),
            'comment_disabled' => Faker::randomBoolean(),
            'content' => Faker::randomString(mt_rand(100, 300)),
            'content_short' => Faker::randomString(mt_rand(30, 50)),
            'status' => Faker::randomInArray(['deleted', 'published', 'draft']),
            'forecast' => mt_rand(100, 9999) / 100,
            'image_uri' => 'https://via.placeholder.com/400x300',
            'importance' => mt_rand(1, 3),
            'pageviews' => mt_rand(10000, 999999),
            'reviewer' => Faker::randomString(mt_rand(5, 10)),
            'timestamp' => Faker::randomDateTime()->getTimestamp(),
            'type' => Faker::randomInArray(['US', 'VI', 'JA']),

        ];

        $data[] = $row;
    }

    return response()->json(new JsonResponse(['items' => $data, 'total' => mt_rand(1000, 10000)]));
});

Route::get('articles/{id}', function ($id) {
    $article = [
        'id' => $id,
        'display_time' => Faker::randomDateTime()->format('Y-m-d H:i:s'),
        'title' => Faker::randomString(mt_rand(20, 50)),
        'author' => Faker::randomString(mt_rand(5, 10)),
        'comment_disabled' => Faker::randomBoolean(),
        'content' => Faker::randomString(mt_rand(100, 300)),
        'content_short' => Faker::randomString(mt_rand(30, 50)),
        'status' => Faker::randomInArray(['deleted', 'published', 'draft']),
        'forecast' => mt_rand(100, 9999) / 100,
        'image_uri' => 'https://via.placeholder.com/400x300',
        'importance' => mt_rand(1, 3),
        'pageviews' => mt_rand(10000, 999999),
        'reviewer' => Faker::randomString(mt_rand(5, 10)),
        'timestamp' => Faker::randomDateTime()->getTimestamp(),
        'type' => Faker::randomInArray(['US', 'VI', 'JA']),
    ];

    return response()->json(new JsonResponse($article));
});

Route::get('articles/{id}/pageviews', function ($id) {
    $pageviews = [
        'PC' => mt_rand(10000, 999999),
        'Mobile' => mt_rand(10000, 999999),
        'iOS' => mt_rand(10000, 999999),
        'android' => mt_rand(10000, 999999),
    ];
    $data = [];
    foreach ($pageviews as $device => $pageview) {
        $data[] = [
            'key' => $device,
            'pv' => $pageview,
        ];
    }

    return response()->json(new JsonResponse(['pvData' => $data]));
});
Route::namespace('Api')->group(function () {
    // get all product
    Route::get('all-products', 'ProductController@getAllProduct');
    // get list product paginate
    Route::get('products', 'ProductController@index');   
    // get detail product  
    Route::get('products/{product}', 'ProductController@show');  
    //get product belong to category paginate
    Route::get('products-with-category/{category_unique_id}', 'ProductController@getProductWithCategory');
    //get all category
    Route::get('all-categories', 'CategoryController@getAllCategory');

    // get all blog-category
    Route::get('all-blog-categories', 'BlogCategoryController@getAllBlogCategory');
    // get list blog-items paginate
    Route::get('blog-items', 'BlogItemController@index');
    // get all blog-items
    Route::get('all-blog-items', 'BlogItemController@getAllBlogItem');
    // get detail blog-items
    Route::get('blog-items/{blog_item}', 'BlogItemController@show');
    // get blog-item belongs to blog-category paginate
    Route::get('paginate-blog-category/{blog_category_id}', 'BlogItemController@getPaginateBlogCategory');

    //Api create contact
    Route::post("contact","ContactController@store");
});