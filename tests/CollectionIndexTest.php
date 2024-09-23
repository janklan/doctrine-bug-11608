<?php

namespace App\Tests;

use App\Entity\Plan;
use App\Entity\Customer;
use App\Entity\Subscription;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CollectionIndexTest extends KernelTestCase
{
    public function testCollectionIndexes(): void
    {
        $em = static::getContainer()->get(EntityManagerInterface::class);

        $customer = new Customer();
        $plan = new Plan();

        $subscription = Subscription::create($customer, $plan);

        $em->persist($customer);
        $em->persist($plan);
        $em->persist($subscription);

        self::assertTrue($customer->getSubscriptions()->containsKey($plan->getId()->toRfc4122()));
        self::assertTrue($plan->getSubscriptions()->containsKey($customer->getId()->toRfc4122()));

        $em->flush();

        $em->refresh($customer);
        $em->refresh($plan);
        $em->refresh($subscription);

        self::assertTrue($customer->getSubscriptions()->containsKey($plan->getId()->toRfc4122()));
        self::assertTrue($plan->getSubscriptions()->containsKey($customer->getId()->toRfc4122()), 'Index was not set correctly by Doctrine. See Plan.php line 18.');
    }
}
