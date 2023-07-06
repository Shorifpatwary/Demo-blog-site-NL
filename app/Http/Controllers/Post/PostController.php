<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{
		try {
			// $category = $request->query('category');
			$limit = $request->query('limit');
			$offset = $request->query('offset');
			$orderBy = $request->query('orderBy');

			$query = Post::query()->with('user')->with('category')->with('tag')->with('comment');

			// Apply additional conditions based on the query parameters

			// if ($category) {
			// 	$query->whereRelation('category', 'name', $category);
			// }

			if ($limit) {
				$query->limit($limit);
			}
			if ($offset) {
				$query->offset($offset);
			}
			if ($orderBy) {
				$query->orderBy($orderBy);
			}

			// Retrieve the posts
			$posts = $query->paginate(20);

			// Log something
			Log::info("posts api index ::success");

			// return respose 
			return PostResource::collection($posts);

		} catch (\Exception $e) {
			$errorMessage = 'Failed to fetch the data.';
			$statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

			// Log the error if needed
			Log::info('posts api index :: error');
			Log::error($e);

			return response()->json(['error' => $errorMessage], $statusCode);
		}
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Post $post)
	{
		$post->load('user', 'category', 'tag', 'comment');
		return new PostResource($post);
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Post $post)
	{
		return "This is edit method";
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, Post $post)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Post $post)
	{
		//
	}
}