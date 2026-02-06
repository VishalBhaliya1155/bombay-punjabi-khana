<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ResUser;
use App\Models\UserMaster;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',     // mobile / email / userloginid
            'password' => 'required'
        ]);

        $login = $request->login;

        // Find user by mobile OR email OR userloginid
        $user = UserMaster::where('mobile', $login)
            ->orWhere('email', $login)
            ->orWhere('userloginid', $login)
            ->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }

        // if (!Hash::check($request->password, $user->userpassword)) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Invalid password'
        //     ], 401);
        // }
if ($request->password !== $user->userpassword) {
    return response()->json([
        'status' => false,
        'message' => 'Invalid password'
    ], 401);
}

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'data' => [
                'userid' => $user->userid,
                'role' => $user->userrole,
                'name' => $user->userfname . ' ' . $user->userlname,
                'email' => $user->email,
                'mobile' => $user->mobile
            ]
        ]);
    }
    public function registerCustomer(Request $request)
{
    $request->validate([
        'userfname' => 'required',
        'userlname' => 'nullable',
        'mobile' => 'required|unique:res_user_master,mobile',
        'email' => 'nullable|email|unique:res_user_master,email',
        'password' => 'required|min:6'
    ]);

    $user = UserMaster::create([
        'userloginid' => 'CUS' . time(),
        // 'userpassword' => Hash::make($request->password),
        'userpassword' => $request->password,
        'userrole' => 'customer',
        'userfname' => $request->userfname,
        'userlname' => $request->userlname,
        'email' => $request->email,
        'mobile' => $request->mobile
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Customer registered successfully',
        'userid' => $user->userid
    ]);
}
public function registerAgent(Request $request)
{
    $request->validate([
        'userfname' => 'required',
        'userlname' => 'nullable',
        'mobile' => 'required|unique:res_user_master,mobile',
        'email' => 'nullable|email|unique:res_user_master,email',
        'password' => 'required|min:6',
        'address' => 'required'
    ]);

    $user = UserMaster::create([
        'userloginid' => 'AGENT' . time(),
        // 'userpassword' => Hash::make($request->password),
        'userpassword' => $request->password,
        'userrole' => 'agent',
        'userfname' => $request->userfname,
        'userlname' => $request->userlname,
        'email' => $request->email,
        'mobile' => $request->mobile,
        'address' => $request->address
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Agent registered successfully (pending approval)',
        'userid' => $user->userid
    ]);
}

}
