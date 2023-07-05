<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
			'name' => $this->name,
			'description' => $this->description,
			'slug' => $this->slug,
			'image' => $this->image,
			'post' => PostResource::collection($this->whenLoaded('post')),
			'created_at' => (string) $this->created_at,
			'updated_at' => (string) $this->updated_at,
		];
	}
}