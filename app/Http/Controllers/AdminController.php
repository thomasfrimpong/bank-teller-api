<?php

namespace App\Http\Controllers;

use App\Classes\Queries;
use App\Classes\Response;
use App\Http\Requests\AddAdminRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //
    public function addAdmin(AddAdminRequest $request)
    {
        try {
            Queries::addAdmin($request);
            return Response::response(true, "Admin added successfully");
        } catch (Exception $ex) {
            return Response::response(false, "Something went wrong");
        }
    }

    public function loginAdmin(Request $request)
    {
        $admin = Queries::findAdmin($request->email);
        if (!$admin->email) {
            return 'no';
            return null;
        }

        if (!Hash::check($request->password,  $admin->password)) {
            return 'no';
            return null;
        }


        $token = $admin->createToken('tokens')->plainTextToken;


        //Cache::put('user', $user);


        return (object) ['admin' => $admin, 'token' => $token];
    }
}
