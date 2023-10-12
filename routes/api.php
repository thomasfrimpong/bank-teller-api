<?php

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post("/login/admin", [AdminController::class, 'loginAdmin']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post("/add/admin", [AdminController::class, 'addAdmin']);

    Route::post("/add/customer", [AccountsController::class, 'addCustomer']);

    Route::post("/add/account", [AccountsController::class, 'addAccount']);

    Route::post("/record/transaction", [AccountsController::class, 'recordTransaction']);

    Route::get("/transaction/records", [AccountsController::class, 'transactionRecords']);

    // Route::get("/transaction/records", [AccountsController::class, 'transactionRecords']);

    Route::get("/get/customers", [AccountsController::class, 'getCustomers']);

    Route::get("/get/accounts", [AccountsController::class, 'getAccounts']);

    Route::get("/get/customer/accounts", [AccountsController::class, 'getCustomerAccounts']);
    //summary

    Route::get("/count/customers", [AccountsController::class, 'countOfCustomers']);

    Route::get("/count/accounts", [AccountsController::class, 'countOfAccounts']);

    Route::get("/withdrawal/summary", [AccountsController::class, 'withdrawalSummary']);

    Route::get("/deposit/summary", [AccountsController::class, 'depositSummary']);
});
