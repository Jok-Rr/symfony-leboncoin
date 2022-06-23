<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column(type: 'integer')]
  private $id;

  #[ORM\Column(type: 'string', length: 255)]
  private $username;

  #[ORM\Column(type: 'string', length: 255)]
  private $password;

  #[ORM\Column(type: 'datetime_immutable')]
  private $created_at;

  #[ORM\Column(type: 'datetime_immutable')]
  private $updated_at;

  #[ORM\OneToMany(mappedBy: 'user', targetEntity: ad::class, orphanRemoval: true)]
  private $ads;

  public function __construct()
  {
      $this->ads = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getUsername(): ?string
  {
    return $this->username;
  }

  public function setUsername(string $username): self
  {
    $this->username = $username;

    return $this;
  }

  public function getPassword(): ?string
  {
    return $this->password;
  }

  public function setPassword(string $password): self
  {
    $this->password = $password;

    return $this;
  }

  public function getCreatedAt(): ?\DateTimeImmutable
  {
    return $this->created_at;
  }

  public function setCreatedAt(\DateTimeImmutable $created_at): self
  {
    $this->created_at = $created_at;

    return $this;
  }

  public function getUpdatedAt(): ?\DateTimeImmutable
  {
    return $this->updated_at;
  }

  public function setUpdatedAt(\DateTimeImmutable $updated_at): self
  {
    $this->updated_at = $updated_at;

    return $this;
  }

  /**
   * @return Collection<int, ad>
   */
  public function getAds(): Collection
  {
      return $this->ads;
  }

  public function addAd(ad $ad): self
  {
      if (!$this->ads->contains($ad)) {
          $this->ads[] = $ad;
          $ad->setUser($this);
      }

      return $this;
  }

  public function removeAd(ad $ad): self
  {
      if ($this->ads->removeElement($ad)) {
          // set the owning side to null (unless already changed)
          if ($ad->getUser() === $this) {
              $ad->setUser(null);
          }
      }

      return $this;
  }
}
