<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class userController extends Controller
{
    public function index () {
        $users = User::all();
        if ($users->isEmpty()) {
            $data = [
                'message' => 'Dont users',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        return response()->json($users, 200);
    }

    public function store(Request $request) {

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:12|unique:users,phone,'
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => 'Faild',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $user = User::create([
             'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone

        ]);

        if (!$user) {
            $data = [
                'message' => 'Error creating user',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'user' => $user,
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    public function show($id) {
        $user = User::find($id);

        if (!$user) {
            $data = [
                'message' => 'User not found',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'user' => $user,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function destroy($id) {

        $user = User::find($id);

        if (!$user) {
            $data = [
                'message' => 'User not found',
                'status' => 404
            ];
            return response()->json($data, 404);
        };

        $user->delete();

        $data = [
            'message' => 'User destroyed',
            'status' => 200
        ];
        return response()->json($data, 200);

    }

    public function update(Request $request, $id) {

        $user = User::find($id);

        if (!$user) {
            $data = [
                'message' => 'User not found',
                'status' => 404
            ];
            return response()->json($data, 404);
        };

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|string|max:15'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Validation faild',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        $user->save();

        $data = [
            'message' => 'User update',
            'user' => $user,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $id) {
         $user = User::find($id);

        if (!$user) {
            $data = [
                'message' => 'User not found',
                'status' => 404
            ];
            return response()->json($data, 404);
        };

        $validator = Validator::make($request->all(),[
            'name' => '',
            'email' => 'email',
            'phone' => 'string|max:15'
        ]);

         if ($validator->fails()) {
            $data = [
                'message' => 'Validation faild',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        if ($request->has('phone')) {
            $user->phone = $request->phone;
        }

        $user->save();

        $data = [
            'message' => 'User update',
            'user' => $user,
            'status' => 200
        ];
        return response()->json($data, 200);

    }

}
