<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AuthorMonument;
use Illuminate\Http\Request;

class AuthorMonumentController extends Controller
{
    public function index()
    {
        $authorMonuments = AuthorMonument::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Lista de relaciones author-monument obtenida correctamente.',
            'data' => $authorMonuments,
        ], 200);
    }

    // Implementa los demás métodos según las necesidades de tu aplicación
}
