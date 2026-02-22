<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller
{
    public function authUser(Request $request):JsonResponse{
        $user = $request->user();
        return response()->json($user);
    }
}
