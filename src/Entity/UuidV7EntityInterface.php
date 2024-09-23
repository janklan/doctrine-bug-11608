<?php

namespace App\Entity;

use Symfony\Component\Uid\UuidV7;

interface UuidV7EntityInterface
{
    public function getId(): UuidV7;
}
