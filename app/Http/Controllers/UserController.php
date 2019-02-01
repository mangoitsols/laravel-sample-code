<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Hash;
use App\Property;
use App\Http\Controllers\QuickBooksController;
use Mail;
use App\Mail\UserRegistered;

class UserController extends Controller
{

    // user account
    public function account()
    {
      return view('account/account');
    }

    public function user($id)
    {
      $user = User::where([
        ['realm_id', Auth::user()->realm_id],
        ['id', $id]
      ])->first();
      return view('settings/user', compact('user'));
    }

    // edit account page
    public function editAccount()
    {
      return view('account/edit-account');
    }

    // get all users
    public function getUsers()
    {
      $users = User::where([
        ['realm_id', Auth::user()->realm_id]
      ])->get();
      return response()->json(['users' => $users], 200);
    }

    // create new user
    public function create(Request $request)
    {
      // validate request
      $request->validate([
          'name' => 'required|string|max:255',
          'email' => 'required|string|email|max:255|unique:users'
      ]);

      // randorm password
      $password = str_random(8);

      // create new user
      $user = User::create([
          'name' => $request->name,
          'email' => $request->email,
          'password' => Hash::make($password),
          'phone' => $request->phone,
          'qb_sub' => Auth::user()->qb_sub,
          'realm_id' => Auth::user()->realm_id,
          'company_name' => Auth::user()->company_name,
          'company_address' => Auth::user()->company_address,
          'user_type' => 'added',
          'qb_refresh_token' => Auth::user()->qb_refresh_token
      ]);

      // send welcome email to new user
      $data = [
        'name' => $request->email,
        'password' => $password
      ];
      Mail::to($request->email)->send(new UserRegistered($data));

      // return success
      return response()->json([], 200);

    }

    // delete user
    public function delete(Request $request)
    {
      try {
        // get user from DB
        $user = User::where('id', $request->id)->first();
        // delete
        $user->delete();
        // redirect with success
        $request->session()->flash('success', 'User was deleted.');
        return response()->json(['route' => '/users'], 200);
      } catch (\Exception $e) {
        return response()->json(['message' => 'An error occurred, please try again or contact support'], 500);
      }

    }


    // welcome modal
    public function welcomeModal($status) {
      if ($status != 'false') {
        Auth::user()->first_steps_completed = true;
        Auth::user()->update();
      }
    }

}
