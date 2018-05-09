<?php

namespace App\Http\Resources;

use App\Models\BaseInfo;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DateKlineCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection = $this->collection->groupBy('code')->map(function($item) {
            return $item->map->only(['date', 'open', 'close', 'high', 'low', 'volume']);
        });
        return [
            'open' => $this->collection->map->pluck('open'),
            'close' => $this->collection->map->pluck('close'),
            'high' => $this->collection->map->pluck('high'),
            'low' => $this->collection->map->pluck('low'),
            'names' => BaseInfo::whereIn('code', $this->collection->keys())->pluck('name', 'code'),
            'dates' => $this->collection->map->pluck('date'),
        ];
    }
}
