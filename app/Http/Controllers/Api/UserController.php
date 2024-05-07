<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function userAchievements($userId)
    {
        return User::find($userId)
            ->achievements()
            ->select('achievements.id', 'achievements.name', 'achievements.description', 'achievement_user.created_at as achieved_at')
            ->join('achievement_user', 'users.id', '=', 'achievement_user.user_id')
            ->join('achievements', 'achievement_user.achievement_id', '=', 'achievements.id')
            ->get();
    }

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
            'nickname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'first_surname' => 'required|string|max:255',
            'second_surname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'confirm_password' => 'required|string|min:8|confirmed',
            'nationality' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);
    
        $user = User::create([
            'nickname' => $request->nickname,
            'name' => $request->name,
            'first_surname' => $request->first_surname,
            'second_surname' => $request->second_surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'confirm_password' => $request->password,
            'nationality' => $request->nationality,
            'location' => $request->location,
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
            'password' => 'string|min:8|confirmed',
        ]);
    
        $user->update([
            'name' => $request->input('name', $user->name),
            'email' => $request->input('email', $user->email),
            'password' => isset($request->password) ? Hash::make($request->password) : $user->password,
            'nickname' => $request->input('nickname', $user->nickname),
            'first_surname' => $request->input('first_surname', $user->first_surname),
            'second_surname' => $request->input('second_surname', $user->second_surname),
            'nationality' => $request->input('nationality', $user->nationality),
            'location' => $request->input('location', $user->location),
            'confirm_password' => $request->input('password', $user->password), // Add confirm_password field
            'profile_picture' => $request->input('profile_picture', $user->profile_picture),
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
