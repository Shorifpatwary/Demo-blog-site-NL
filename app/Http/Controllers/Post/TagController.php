<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{

		$orderBy = $request->query('orderBy');

		$query = Tag::query()->with('post');


		if ($orderBy) {
			$query->orderBy($orderBy);
		}

		// Retrieve the posts
		$posts = $query->paginate(20);

		return TagResource::collection($posts);
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
	public function show(Tag $tag)
	{
		$tag->load('post');
		return new TagResource($tag);
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Tag $tag)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, Tag $tag)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Tag $tag)
	{
		//
	}
}