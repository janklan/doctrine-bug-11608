<?php

namespace App\Entity;

use App\Doctrine\IdGenerator;
use App\Repository\PlanRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7;

/**
 * @see UuidV7EntityInterface
 */
trait UuidV7Trait
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: IdGenerator::class)]
    #[ORM\Column(type: 'uuid', unique: true)]
    private UuidV7 $id;

    public function getId(): UuidV7
    {
        return $this->id ??= new UuidV7();
    }
}
