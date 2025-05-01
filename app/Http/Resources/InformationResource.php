<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InformationResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'name' => $this->name,
			'birth' => $this->birth,
			'gender' => $this->gender,
			'phone' => $this->phone,
			'address' => $this->address,
			'citizen_id' => $this->citizen_id
		];
	}
}
