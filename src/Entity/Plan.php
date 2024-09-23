<?php

namespace App\Entity;

use App\Repository\PlanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlanRepository::class)]
class Plan implements UuidV7EntityInterface
{
    use UuidV7Trait;

    /**
     * @var Collection<string, Subscription>
     */
    #[ORM\OneToMany(mappedBy: 'plan', targetEntity: Subscription::class, indexBy: 'customer')] // <--- THIS IS BROKEN. Change to customer_id and it will work
    private Collection $subscriptions;

    public function __construct()
    {
        $this->subscriptions = new ArrayCollection();
    }

    /**
     * @return Collection<int, Subscription>
     */
    public function getSubscriptions(): Collection
    {
        return $this->subscriptions;
    }

    public function addSubscription(Subscription $subscription): static
    {
        assert(null !== $subscription->getCustomer());

        if (!$this->subscriptions->contains($subscription)) {
            $this->subscriptions->set($subscription->getCustomer()->getId()->toRfc4122(), $subscription);
            $subscription->setPlan($this);
        }

        return $this;
    }

    public function removeSubscription(Subscription $subscription): static
    {
        if ($this->subscriptions->removeElement($subscription)) {
            // set the owning side to null (unless already changed)
            if ($subscription->getPlan() === $this) {
                $subscription->setPlan(null);
            }
        }

        return $this;
    }
}
