<?php

namespace App\Entity;

use App\Doctrine\IdGenerator;
use App\Repository\SubscriptionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV7;

#[ORM\Entity(repositoryClass: SubscriptionRepository::class)]
class Subscription implements UuidV7EntityInterface
{
    use UuidV7Trait;

    #[ORM\ManyToOne(inversedBy: 'subscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Customer $customer = null;

    #[ORM\ManyToOne(inversedBy: 'subscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Plan $plan = null;

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): static
    {
        $customer->addSubscription($this);

        $this->customer = $customer;

        return $this;
    }

    public function getPlan(): ?Plan
    {
        return $this->plan;
    }

    public function setPlan(Plan $plan): static
    {
        $plan->addSubscription($this);

        $this->plan = $plan;

        return $this;
    }

    public static function create(Customer $customer, Plan $plan): Subscription
    {
        $self = new self;
        $self->plan = $plan;
        $self->customer = $customer;

        $plan->addSubscription($self);
        $customer->addSubscription($self);

        return $self;
    }
}
