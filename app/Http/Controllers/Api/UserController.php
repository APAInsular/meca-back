<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function getUsersByPointsCategory()
    {
        $users = User::select('id', 'name', 'last_name', 'second_last_name', 'profile_picture', 'points')
            ->get()
            ->groupBy(function ($user) {
                if ($user->points > 125000) {
                    return 'top';
                } elseif ($user->points > 100000) {
                    return 'platino';
                } elseif ($user->points > 50000) {
                    return 'oro';
                } elseif ($user->points > 30000) {
                    return 'plata';
                } elseif ($user->points > 10000) {
                    return 'bronce';
                } else {
                    return 'otros';
                }
            })
            ->map(function ($group) {
                return $group->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'last_name' => $user->last_name,
                        'second_last_name' => $user->second_last_name,
                        'profile_picture' => $user->profile_picture,
                        'points' => $user->points,
                    ];
                })->toArray();
            });

        return $users;
    }


    public function index()
    {
        $users = User::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Usuarios encontrados.',
            'data' => $users
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Usuario creado exitosamente.',
            'data' => $user
        ], 201);
    }

    public function show(User $user)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Detalles del usuario.',
            'data' => $user
        ], 200);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'string|max:255',
            'email' => [
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => 'string|min:8',
        ]);

        $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'password' => isset($request->password) ? Hash::make($request->password) : $user->password,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Usuario actualizado exitosamente.',
            'data' => $user
        ], 200);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Usuario eliminado.'
        ], 204);
    }
}
