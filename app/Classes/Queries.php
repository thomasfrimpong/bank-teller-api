<?php

namespace App\Classes;

use App\Models\Account;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class Queries
{

    public static function insertCustomer($data)
    {
        $customer = new Customer;
        $customer->first_name = $data->first_name;
        $customer->last_name = $data->last_name;
        $customer->email = $data->email;
        $customer->address = $data->address;
        $customer->phone_number = $data->phone_number;
        $customer->save();
    }

    public static function createAccount($data)
    {
        $account = new Account;
        $account->type_of_account = $data->type_of_account;
        $account->customer_id = $data->customer_id;
        $account->account_number = uniqid();
        $account->save();
    }
    public static function addTransaction($data)
    {
        $transaction = new Transaction;
        $transaction->customer_id = $data->customer_id;
        $transaction->account_id = $data->account_id;
        $transaction->amount = $data->type_of_transaction == 'withdrawal' ? -$data->amount : $data->amount;
        $transaction->type_of_transaction = $data->type_of_transaction;
        $transaction->save();
    }

    public static function transactionRecords()
    {
        return Transaction::join('customers', 'customers.id', '=', 'transactions.customer_id')
            ->join('accounts', 'accounts.id', '=', 'transactions.account_id')
            ->select(
                'transactions.id',
                "transactions.created_at as date_of_transaction",
                'customers.first_name',
                'customers.last_name',
                'customers.phone_number',
                'customers.address',
                'transactions.amount',
                'transactions.type_of_transaction',
                'accounts.type_of_account',
                'accounts.account_number',
                'accounts.type_of_account'
            )
            ->orderBy('transactions.created_at', 'desc')
            ->get();
    }

    public static function customerRecords()
    {
        return Customer::all();
    }

    public static function addAdmin($data)
    {
        $admin = new Admin;
        $admin->first_name = $data->first_name;
        $admin->last_name = $data->last_name;
        $admin->email = $data->email;
        $admin->password =  Hash::make('changemenow');
        $admin->save();
    }

    public static function findAdmin($email)
    {
        return Admin::where('email', $email)->first();
    }

    public static function getAcounts()
    {
        return Account::orderBy('accounts.created_at', 'desc')->get();
    }

    public static function customerAccounts()
    {
        return Account::join('customers', 'customers.id', '=', 'accounts.customer_id')
            ->select('*', 'accounts.created_at as account_created_at')
            ->orderBy('accounts.created_at', 'desc')
            ->get();
    }

    public static function countCustomers()
    {
        return Customer::count();
    }

    public static function countAccounts()
    {
        return Account::count();
    }

    public static function withdrawalSum()
    {
        $date =  Carbon::now()->format('Y-m-d');
        $sum = Transaction::where('type_of_transaction', 'withdrawal')
            ->where('created_at', 'like', '%' . $date . '%')

            ->sum('amount');
        return abs($sum);
    }

    public static function depositSum()
    {
        $date =  Carbon::now()->format('Y-m-d');

        $sum = Transaction::where('type_of_transaction', 'deposit')
            ->where('created_at', 'like', '%' . $date . '%')
            ->sum('amount');
        return abs($sum);
    }
}
