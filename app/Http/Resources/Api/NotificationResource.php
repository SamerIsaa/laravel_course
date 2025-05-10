<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        dd($this, $this->getRawOriginal('data'));
        return [
            'id' => $this['id'],
            'title' => @$this['data']['title'],
            'content' => @$this['data']['content'],
            'created_at' => Carbon::parse($this['created_at'])->diffForHumans(),
            'read_at' => isset($this['read_at']) ? Carbon::parse($this['read_at'])->diffForHumans() : null,
        ];
    }
}
