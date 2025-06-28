<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\NoteResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function notes(Request $request)
    {
        $user = $request->user();
        $notes = NoteResource::collection($user->notes);

        return ApiResponse::success('Notes fetched successfully', ['notes' => $notes], 200);
    }
}
