<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\Note\StoreNoteRequest;
use App\Http\Requests\Note\UpdateNoteRequest;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    // public function index()
    // {
    //     $notes = NoteResource::collection(Note::all());
    //     return ApiResponse::success('Notes fetched successfully', ['notes' => $notes], 200);
    // }

    public function show(Note $note)
    {
        $notes = NoteResource::make($note);
        return ApiResponse::success('Note fetched successfully', ['note' => $notes], 200);
    }

    public function store(StoreNoteRequest $request)
    {
        $data = $request->validated();
        $note = $request->user()->notes()->create($data);

        return ApiResponse::success('Note created successfully', ['note' => NoteResource::make($note)], 201);
    }

    public function destroy(Request $request, Note $note)
    {
        if ($request->user()->id != $note->user_id) {
            return ApiResponse::error('Unauthorized', null, 401);
        }

        $note->delete();
        return ApiResponse::success('Note deleted successfully', ['note' => NoteResource::make($note)], 200);
    }

    public function update(UpdateNoteRequest $request, Note $note)
    {
        if ($request->user()->id != $note->user_id) {
            return ApiResponse::error('Unauthorized', null, 401);
        }

        $data = $request->validated();
        $note->update($data);

        return ApiResponse::success('Note updated successfully', ['note' => NoteResource::make($note)], 200);
    }
}
