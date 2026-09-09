<?php

namespace VHosting\ToolsSdk\Types;

use BackedEnum;
use DateTimeInterface;
use Illuminate\Contracts\Support\Arrayable;

abstract class BaseType implements Arrayable
{
    public function toArray(): array
    {
        $data = get_object_vars($this);
        
        array_walk_recursive($data, static function (mixed &$value) {
            match (true) {
                $value instanceof Arrayable => $value = $value->toArray(),
                $value instanceof BackedEnum => $value = $value->value,
                $value instanceof DateTimeInterface => $value = $value->format(DateTimeInterface::ATOM),
                default => null,
            };
        });

        return $data;
    }
}