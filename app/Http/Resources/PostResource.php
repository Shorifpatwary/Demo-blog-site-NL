<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id' => $this->id,
			'title' => $this->title,
			'slug' => $this->slug,
			'content' => $this->content,
			'status' => $this->status,
			'published_at' => (string) $this->published_at,
			'views' => $this->views,
			'comments_enabled' => $this->comments_enabled,
			'meta_title' => $this->meta_title,
			'meta_description' => $this->meta_description,
			'excerpt' => $this->excerpt,
			'image' => $this->image,
			// 'imagePath' => $this->imagePath,
			// 'user' => UserResource::collection($this->whenLoaded('user')),
			'user' => $this->user,
			'category' => CategoryResource::collection($this->whenLoaded('category')),
			'tag' => TagResource::collection($this->whenLoaded('tag')),
			'comment' => CommentResource::collection($this->whenLoaded('comment')),
			'created_at' => (string) $this->created_at,
			'updated_at' => (string) $this->updated_at,
		];
	}
}