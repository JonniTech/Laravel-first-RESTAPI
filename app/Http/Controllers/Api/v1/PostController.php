<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var User $user */
        $user = auth('sanctum')->user();
        return $user->posts()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validateRequest($request);
        /** @var User $user */
        $user = auth('sanctum')->user();
        $data = array_merge($request->all(), ['user_id' => $user->id]);
        $post = Post::create($data);
        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        /** @var User $user */
        $user = auth('sanctum')->user();
        $post = Post::findOrFail($id);

        if ($post->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to access this resource. You can only manage your own posts.',
                'error' => 'Forbidden',
            ], 403);
        }

        return response()->json($post, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validateRequest($request);
        /** @var User $user */
        $user = auth('sanctum')->user();
        $post = Post::findOrFail($id);

        if ($post->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to access this resource. You can only manage your own posts.',
                'error' => 'Forbidden',
            ], 403);
        }

        $post->update($request->all());
        return response()->json($post, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        /** @var User $user */
        $user = auth('sanctum')->user();
        $post = Post::findOrFail($id);

        if ($post->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to access this resource. You can only manage your own posts.',
                'error' => 'Forbidden',
            ], 403);
        }

        $post->delete();
        return response()->json(null, 204);
    }

    private function validateRequest(Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ])->validate();
    }
}
