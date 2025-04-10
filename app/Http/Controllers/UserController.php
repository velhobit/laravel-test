<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    protected $users;

    public function __construct(UserService $users)
    {
        $this->users = $users;
    }

    public function index()
    {
        return response()->json($this->users->all());
    }

    public function show($id)
    {
        return response()->json($this->users->find($id));
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'role' => 'string',
                'password' => 'required|string|min:6',
                'phone' => 'nullable|string',
                'cpf' => 'nullable|string',
                'rg' => 'nullable|string',
                'address' => 'nullable|string',
                'city' => 'nullable|string',
                'state' => 'nullable|string',
                'birthdate' => 'nullable|date',
            ]);

            $user = $this->users->create($data);

            return response()->json($user, 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error creating user',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'name' => 'sometimes|string',
                'email' => 'sometimes|email|unique:users,email,' . $id,
                'password' => 'sometimes|string|min:6',
                'role' => 'string',
                'phone' => 'nullable|string',
                'cpf' => 'nullable|string',
                'rg' => 'nullable|string',
                'address' => 'nullable|string',
                'city' => 'nullable|string',
                'state' => 'nullable|string',
                'birthdate' => 'nullable|date',
            ]);

            $user = $this->users->update($id, $data);

            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error updating user',
                'message' => $e->getMessage()
            ], 400);
        }
    }


    public function destroy($id)
    {
        $this->users->delete($id);
        return response()->json(['message' => 'User deleted']);
    }
}
