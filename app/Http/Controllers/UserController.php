<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;

class UserController extends Controller
{
    public function userRead()
    {
        $users = User::all();

        return view('user.user-list', compact('users'));
    }

    public function userCreate(UserRequest $request)
    {
        User::create($request->toModelData());

        return redirect()->back()->with('success', 'User created successfully.');
    }

    public function userEdit($id)
    {
        $users = User::all();
        $userEdit = User::find($id);

        if (! $userEdit) {
            return redirect()->back()->with('error', 'User not found.');
        }

        return view('user.user-list', compact('users', 'userEdit'));
    }

    public function userUpdate(UserRequest $request)
    {
        User::findOrFail($request->validated('uid'))->update($request->toModelData());

        return redirect()->back()->with('success', 'User updated successfully.');
    }

    public function userDelete($id)
    {
        if ((int) $id === auth()->id()) {
            return response()->json([
                'status' => 422,
                'message' => 'You cannot delete your own account.',
            ], 422);
        }

        $user = User::find($id);

        if (! $user) {
            return response()->json([
                'status' => 404,
                'message' => 'User not found',
            ], 404);
        }

        $user->delete();

        return response()->json([
            'status' => 200,
            'uid' => $id,
        ]);
    }
}
