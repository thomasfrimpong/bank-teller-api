<?php

namespace App\Http\Controllers;

use App\Classes\Queries;
use App\Classes\Response;
use App\Http\Requests\AddAccountRequest;
use App\Http\Requests\AddCustomerRequest;
use App\Http\Requests\RecordTransactionRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AccountsController extends Controller
{
    //
    public function addCustomer(AddCustomerRequest $request)
    {
        try {
            Queries::insertCustomer($request);
            return Response::response(true, "Customer added successfully");
        } catch (Exception $ex) {
            return Response::response(false, "Something went wrong");
            return $ex->getMessage();
        }
    }

    public function addAccount(AddAccountRequest $request)
    {
        try {
            Queries::createAccount($request);
            return Response::response(true, "Account created successfully");
        } catch (Exception $ex) {
            Log::debug($ex->getMessage());
            return Response::response(false, "Something went wrong");
        }
    }

    public function recordTransaction(RecordTransactionRequest $request)
    {
        try {
            Queries::addTransaction($request);
            return Response::response(true, "Transaction added successfully");
        } catch (Exception $ex) {
            return $ex->getMessage();
            return Response::response(false, "Something went wrong");
        }
    }

    public function transactionRecords()
    {
        return Queries::transactionRecords();
    }

    public function getCustomers()
    {
        return Queries::customerRecords();
    }

    public function getAccounts()
    {
        return Queries::getAcounts();
    }

    public function getCustomerAccounts()
    {
        return Queries::customerAccounts();
    }

    public function countOfCustomers()
    {
        return Queries::countCustomers();
    }

    public function countOfAccounts()
    {
        return Queries::countAccounts();
    }

    public function withdrawalSummary()
    {
        return Queries::withdrawalSum();
    }

    public function depositSummary()
    {
        return Queries::depositSum();
    }
}
