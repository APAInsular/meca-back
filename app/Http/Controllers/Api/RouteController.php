<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RatingStoreRequest;
use App\Http\Requests\Api\RouteStoreRequest;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;

class RouteController extends Controller
{

    public function allInfoRoute($id)
    {
        $routeInfo = DB::table('routes')
        ->select(
            'routes.*',
            'stops.*',
            'ratings.*'
        )
        ->leftJoin('stops', 'routes.id', '=', 'stops.route_id')
        ->leftJoin('ratings', function ($join) {
            $join->on('routes.id', '=', 'ratings.rateable_id')
                ->where('ratings.rateable_type', 'Route');
        })
        ->where('routes.id', $id)
        ->groupBy('routes.name', 'routes.id', 'stops.id', 'ratings.id')
        ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Route information retrieved successfully',
            'data' => $routeInfo,
        ], 200);
    }

    public function stopsByRoute($routeId, $page = 1)
    {
        $stops = DB::table('stops')
            ->where('route_id', $routeId)
            ->paginate(20, 'page', $page);

        return response()->json([
            'status' => 'success',
            'message' => 'Stops retrieved successfully',
            'data' => $stops,
        ], 200);
    }

    public function routesGroupedByStatus($page = 1)
    {
        $routes = DB::table('routes')
            ->select('status', DB::raw('JSON_ARRAYAGG(JSON_OBJECT("id", id, "name", name, "city", city, "distance", distance, "time", time)) AS routes'))
            ->groupBy('status')
            ->paginate(20, ['*'], 'page', $page);

        return response()->json([
            'status' => 'success',
            'message' => 'Routes grouped by status retrieved successfully',
            'data' => $routes,
        ], 200);
    }

    public function routesByAuthor($authorId, $page = 1)
    {
        $perPage = 20;
        $offset = ($page - 1) * $perPage;
    
        $routes = DB::select('
            SELECT routes.*
            FROM routes
            JOIN stops ON routes.id = stops.route_id
            JOIN monuments ON stops.stoppable_id = monuments.id AND stops.stoppable_type = "App\Models\Monument"
            JOIN author_monument ON monuments.id = author_monument.monument_id
            JOIN authors ON authors.id = author_monument.author_id
            WHERE authors.id = :authorId
            LIMIT :limit OFFSET :offset', 
            ['authorId' => $authorId, 'limit' => $perPage, 'offset' => $offset]
        );
    
        return response()->json([
            'status' => 'success',
            'message' => 'Routes by author retrieved successfully',
            'data' => $routes,
        ], 200);
    }
    
    

    public function routesByMonument($monumentId, $page = 1)
    {
        $routes = DB::table('routes')
            ->distinct()
            ->join('stops', 'routes.id', '=', 'stops.route_id')
            ->where('stops.stoppable_type', 'Monument')
            ->where('stops.stoppable_id', $monumentId)
            ->paginate(20, ['routes.*'], 'page', $page);

        return response()->json([
            'status' => 'success',
            'message' => 'Routes by monument retrieved successfully',
            'data' => $routes,
        ], 200);
    }

    public function routeRatings($routeId)
    {
        $ratings = DB::table('Routes')
            FROM routes
            ->select(DB::raw('COUNT(*) as total_ratings'), DB::raw('AVG(rating) as average_rating'))
            ->where('rateable_type', 'Route')
            ->where('rateable_id', $routeId)
            ->first();

        return response()->json([
            'status' => 'success',
            'message' => 'Route ratings retrieved successfully',
            'data' => $ratings,
        ], 200);
    }

    public function highlightedRoutes()
    {
        $routes = DB::table('routes')
            ->join('ratings', 'routes.id', '=', 'ratings.rateable_id')
            ->where('ratings.rateable_type', 'Route')
            ->select('routes.*', DB::raw('AVG(ratings.rating) as average_rating'))
            ->groupBy('routes.id')
            ->orderByDesc('average_rating')
            ->limit(2)
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Highlighted routes retrieved successfully',
            'data' => $routes,
        ], 200);
    }

    public function filterRoutes(RouteStoreRequest $request, $page = 1)
    {
        $query = DB::table('routes')
            ->join('stops', 'routes.id', '=', 'stops.route_id')
            ->leftJoin('monuments', function ($join) {
                $join->on('stops.stoppable_id', '=', 'monuments.id')
                    ->where('stops.stoppable_type', 'Monument');
            })
            ->leftJoin('ratings', function ($join) {
                $join->on('routes.id', '=', 'ratings.rateable_id')
                    ->where('ratings.rateable_type', 'Route');
            });

        if ($request->has('city')) {
            $query->where('routes.city', $request->city);
        }
        if ($request->has('monument_id')) {
            $query->where('stops.stoppable_type', 'Monument')
                ->where('stops.stoppable_id', $request->monument_id);
        }
        if ($request->has('style_id')) {
            $query->where('monuments.style_id', $request->style_id);
        }
        if ($request->has('author_id')) {
            $query->where('monuments.author_id', $request->author_id);
        }
        if ($request->has('rating')) {
            $query->where('ratings.rating', $request->rating);
        }

        $routes = $query->distinct()
            ->paginate(20, ['routes.*'], 'page', $page);

        return response()->json([
            'status' => 'success',
            'message' => 'Filtered routes retrieved successfully',
            'data' => $routes,
        ], 200);
    }



    public function index()
    {
        $ratings = Rating::all();

        if ($ratings->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No se encontraron calificaciones.',
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Calificaciones encontradas.',
            'data' => $ratings
        ], 200);
    }

    public function store(RatingStoreRequest $request)
    {
        $validated = $request->validated();

        $rating = Rating::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Calificación creada exitosamente.',
            'data' => $rating
        ], 201);
    }

    public function show(Rating $rating)
    {
        if (!$rating) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Calificación no encontrada.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Detalles de la calificación.',
            'data' => $rating
        ], 200);
    }

    public function update(RatingStoreRequest $request, Rating $rating)
    {
        if (!$rating) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Calificación no encontrada.'
            ], 404);
        }

        $validated = $request->validated();

        $rating->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Calificación actualizada.',
            'data' => $rating
        ], 200);
    }

    public function destroy(Rating $rating)
    {
        if (!$rating) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Calificación no encontrada.'
            ], 404);
        }

        $rating->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Calificación eliminada.'
        ], 204);
    }

    public function error()
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Error en los métodos del controlador para calificaciones.'
        ], 400);
    }
}
