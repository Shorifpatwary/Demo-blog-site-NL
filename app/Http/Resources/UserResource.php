<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
			'email' => $this->email,
			'post' => PostResource::collection($this->whenLoaded('post')),
			'email_verified_at' => (string) $this->email_verified_at,
			'created_at' => (string) $this->created_at,
			'updated_at' => (string) $this->updated_at,
		];
	}
}