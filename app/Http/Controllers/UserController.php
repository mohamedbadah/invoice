<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function register()
    {
        return view('user.register');
    }
    // public function create(Request $request)
    // {
    //     $request->validate([
    //         'username' => 'required',
    //         'email' => 'required|email|unique:users,email',
    //         'password' => 'required|string|min:3|max:20',
    //         'cpassword' => 'required|same:password'
    //     ]);
    //     $user = new User();
    //     $user->name = $request->username;
    //     $user->email = $request->email;
    //     $user->password = $request->password;
    //     $isSaved = $user->save();
    //     if ($isSaved) {
    //         return redirect()->back()->with('sucess', 'success is login');
    //     } else {
    //         return redirect()->back()->with('faild', 'faild is register');
    //     }
    // }
    public function create(Request $request)
    {
        $validator = Validator($request->all(), [
            'username' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:3|max:20',
            'cpassword' => 'required|same:password'
        ]);
        if (!$validator->fails()) {
            $user = new User();
            $user->name = $request->username;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $isSaved = $user->save();
            return response()->json(
                ['message' => $isSaved ? 'success is register' : 'faild success'],
                $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(
                ['message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
    public function login()
    {
        return view('user.login');
    }
    public function check(Request $request)
    {
        $validator = Validator($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);
        if (!$validator->fails()) {
            $cred = $request->only('email', 'password');
            if (Auth::guard('web')->attempt($cred)) {
                return response()->json(['message' => 'the login is successful'], Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'faild'], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }
    public function logout()
    {
        auth('web')->logout();
        return redirect()->route('user.login');
    }
}
