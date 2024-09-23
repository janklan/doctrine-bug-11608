<?php

namespace App\Entity;

use App\Doctrine\IdGenerator;
use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
class Customer implements UuidV7EntityInterface
{
    use UuidV7Trait;

    /**
     * @var Collection<string, Subscription>
     */
    #[ORM\OneToMany(mappedBy: 'customer', targetEntity: Subscription::class, indexBy: 'plan_id')]
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
        assert(null !== $subscription->getPlan());

        if (!$this->subscriptions->contains($subscription)) {
            $this->subscriptions->set($subscription->getPlan()->getId()->toRfc4122(), $subscription);
            $subscription->setCustomer($this);
        }

        return $this;
    }

    public function removeSubscription(Subscription $subscription): static
    {
        if ($this->subscriptions->removeElement($subscription)) {
            // set the owning side to null (unless already changed)
            if ($subscription->getCustomer() === $this) {
                $subscription->setCustomer(null);
            }
        }

        return $this;
    }
}
