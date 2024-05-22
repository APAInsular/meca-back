<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SubAchievementStoreRequest;
use App\Models\Comment;
use App\Models\MonumentUser;
use App\Models\Rating;
use App\Models\SubAchievement;
use App\Models\User;

class SubAchievementController extends Controller
{
    public function getSubachievementsByKeywords($userId)
    {
        // Palabras clave y categorías
        $keywords = [
            'Visita' => ['Monumentos', 'Autores'],
            'Comenta' => ['Monumentos'],
            'Valora' => ['Monumentos', 'Autores'],
            'Obtiene' => ['Puntos']
        ];

        // Inicializamos el array para almacenar los resultados
        $subachievements = [];

        // Iteramos sobre las palabras clave principales
        foreach ($keywords as $mainKey => $subKeys) {
            $subachievements[$mainKey] = [];
            foreach ($subKeys as $subKey) {
                $subachievements[$mainKey][$subKey] = Subachievement::where('title', 'LIKE', "%$mainKey%")
                    ->where('title', 'LIKE', "%$subKey%")
                    ->get()
                    ->groupBy('achievement_id')
                    ->map(function ($group) use ($userId, $mainKey, $subKey) {
                        $completedCount = 0;
                        $inProgressFound = false; // Bandera para rastrear si se ha encontrado un sublogro en progreso
                        $group = $group->map(function ($subachievement) use ($userId, $mainKey, $subKey, &$completedCount, &$inProgressFound) {
                            // Verificamos el estado del sublogro según el usuario
                            $status = 'pending';
                            if (!$inProgressFound) { // Verificar si ya se encontró un sublogro en progreso
                                if ($mainKey == 'Visita' && $subKey == 'Monumentos') {
                                    $requiredVisits = $this->extractNumberFromTitle($subachievement->title);
                                    $visitedCount = MonumentUser::where('user_id', $userId)->count();
                                    if ($visitedCount >= $requiredVisits) {
                                        $status = 'completed';
                                        $completedCount++;
                                    } elseif ($visitedCount > 0) {
                                        $status = 'in_progress';
                                        $inProgressFound = true; // Marcar que se encontró un sublogro en progreso
                                    }
                                } elseif ($mainKey == 'Valora' && $subKey == 'Monumentos') {
                                    $requiredRatings = $this->extractNumberFromTitle($subachievement->title);
                                    $ratingCount = Rating::where('user_id', $userId)->where('rateable_type', "App\\Models\\Monument")->count();
                                    if ($ratingCount >= $requiredRatings) {
                                        $status = 'completed';
                                        $completedCount++;
                                    } elseif ($ratingCount > 0) {
                                        $status = 'in_progress';
                                        $inProgressFound = true; // Marcar que se encontró un sublogro en progreso
                                    }
                                } elseif ($mainKey == 'Comenta' && $subKey == 'Monumentos') {
                                    $requiredComments = $this->extractNumberFromTitle($subachievement->title);
                                    $commentCount = Comment::where('user_id', $userId)->distinct('commentable_id')->count('commentable_id');
                                    if ($commentCount >= $requiredComments) {
                                        $status = 'completed';
                                        $completedCount++;
                                    } elseif ($commentCount > 0) {
                                        $status = 'in_progress';
                                        $inProgressFound = true; // Marcar que se encontró un sublogro en progreso
                                    }
                                } elseif ($mainKey == 'Obtiene' && $subKey == 'Puntos') {
                                    $requiredPoints = $this->extractNumberFromTitle($subachievement->title);
                                    $userPoints = User::find($userId)->points;
                                    if ($userPoints >= $requiredPoints) {
                                        $status = 'completed';
                                        $completedCount++;
                                    } elseif ($userPoints > 0) {
                                        $status = 'in_progress';
                                        $inProgressFound = true; // Marcar que se encontró un sublogro en progreso
                                    }
                                }
                            }
                            // Agregamos el estado al sublogro
                            $subachievement->status = $status;
                            return $subachievement;
                        });

                        // Verificamos si el logro completo está completo, en progreso o pendiente
                        $status = 'pending';
                        if ($completedCount >= 3) {
                            $status = 'completed';
                        } elseif ($completedCount > 0) {
                            $status = 'in_progress';
                        }

                        // Obtener el título del logro
                        $achievementTitle = '';
                        if ($group->isNotEmpty()) {
                            $firstSubachievement = $group->first();
                            $achievementTitle = $firstSubachievement->achievement->title;
                        }

                        return [
                            'title' => $achievementTitle,
                            'subachievements' => $group,
                            'status' => $status
                        ];
                    });
            }
        }

        return $subachievements;
    }

    // Función para extraer números del título del sublogro
    private function extractNumberFromTitle($title)
    {
        preg_match('/\d+/', $title, $matches);
        return $matches[0] ?? 0;
    }


    public function index()
    {
        $subAchievements = SubAchievement::all();

        if ($subAchievements->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No se encontraron sub-logros.',
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Sub-logros encontrados.',
            'data' => $subAchievements
        ], 200);
    }

    public function store(SubAchievementStoreRequest $request)
    {
        $validated = $request->validated();

        $subAchievement = SubAchievement::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Sub-logro creado exitosamente.',
            'data' => $subAchievement
        ], 201);
    }

    public function show(SubAchievement $subAchievement)
    {
        if (!$subAchievement) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Sub-logro no encontrado.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Detalles del sub-logro.',
            'data' => $subAchievement
        ], 200);
    }

    public function update(SubAchievementStoreRequest $request, SubAchievement $subAchievement)
    {
        if (!$subAchievement) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Sub-logro no encontrado.'
            ], 404);
        }

        $validated = $request->validated();

        $subAchievement->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Sub-logro actualizado.',
            'data' => $subAchievement
        ], 200);
    }

    public function destroy(SubAchievement $subAchievement)
    {
        if (!$subAchievement) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Sub-logro no encontrado.'
            ], 404);
        }

        $subAchievement->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Sub-logro eliminado.'
        ], 204);
    }

    public function error()
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Error en los métodos del controlador para sub-logros.'
        ], 400);
    }
}
