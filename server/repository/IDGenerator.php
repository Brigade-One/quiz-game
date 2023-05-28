<?php
namespace Server\Repository;

use Ramsey\Uuid\Uuid;

class IDGenerator
{
    public static function generateID(): string
    {
        return Uuid::uuid4()->toString();
    }
}