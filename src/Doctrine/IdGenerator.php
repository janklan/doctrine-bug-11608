<?php

/*
 * This file is part of Cognetiq.
 *
 * Copyright (c) iTools Pty Ltd
 * Author: Jan Klan <jan@itools.net.au>
 *
 * This source file contains proprietary IP of iTools Pty Ltd.
 * Any distribution or unauthorised disclosure is prohibited.
 */

namespace App\Doctrine;

use App\Entity\UuidV7EntityInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Id\AbstractIdGenerator;
use Symfony\Component\Uid\Uuid;

class IdGenerator extends AbstractIdGenerator
{
    public function generateId(EntityManagerInterface $em, $entity): Uuid
    {
        if ($entity instanceof UuidV7EntityInterface) {
            return $entity->getId();
        }

        return Uuid::v7();
    }
}
