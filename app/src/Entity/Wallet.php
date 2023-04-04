<?php

namespace App\Entity;

use App\Repository\WalletRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WalletRepository::class)]
class Wallet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::INTEGER, nullable: false, unique: true)]
    private ?int $userId = null;

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    private ?float $beforeAmount = 0.0;

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    private ?float $effectiveAmount = 0.0;

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    private ?float $AfterAmount = 0.0;

    #[ORM\OneToMany(mappedBy: 'wallet', targetEntity: Transaction::class, orphanRemoval: true)]
    private Collection $transactions;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getBeforeAmount(): ?float
    {
        return $this->beforeAmount;
    }

    public function setBeforeAmount(?float $beforeAmount): self
    {
        $this->beforeAmount = $beforeAmount;

        return $this;
    }

    public function getEffectiveAmount(): ?float
    {
        return $this->effectiveAmount;
    }

    public function setEffectiveAmount(?float $effectiveAmount): self
    {
        $this->effectiveAmount = $effectiveAmount;

        return $this;
    }

    public function getAfterAmount(): ?float
    {
        return $this->AfterAmount;
    }

    public function setAfterAmount(?float $AfterAmount): self
    {
        $this->AfterAmount = $AfterAmount;

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions->add($transaction);
            $transaction->setWallet($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getWallet() === $this) {
                $transaction->setWallet(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
