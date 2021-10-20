<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity(repositoryClass=ProfileRepository::class)
 * @vich\Uploadable
 */
class Profile
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nick;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="Profile", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $avatar;

    /**
     * @Vich\UploadableField(mapping="Profile", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\OneToMany(targetEntity=ShoppingCart::class, mappedBy="profile")
     */
    private $shoppingCarts;

    /**
     * @ORM\OneToMany(targetEntity=Purchase::class, mappedBy="Seller")
     */
    private $selling;

    public function __construct()
    {
        $this->shoppingCarts = new ArrayCollection();
        $this->selling = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNick(): ?string
    {
        return $this->Nick;
    }

    public function setNick(string $Nick): self
    {
        $this->Nick = $Nick;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }
    /**
     * @return string|null
     */

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }
    /**
     * @param string|null $image
     * @return $this
     */
    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }
    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->ImageFile;
    }
    /**
     * @param File|null $imageFile
     */
    public function setImageFile(?File $imageFile = null)
    {
        $this->imageFile = $imageFile;
    }

    /**
     * @return Collection|ShoppingCart[]
     */
    public function getShoppingCarts(): Collection
    {
        return $this->shoppingCarts;
    }

    public function addShoppingCart(ShoppingCart $shoppingCart): self
    {
        if (!$this->shoppingCarts->contains($shoppingCart)) {
            $this->shoppingCarts[] = $shoppingCart;
            $shoppingCart->setProfile($this);
        }

        return $this;
    }

    public function removeShoppingCart(ShoppingCart $shoppingCart): self
    {
        if ($this->shoppingCarts->removeElement($shoppingCart)) {
            // set the owning side to null (unless already changed)
            if ($shoppingCart->getProfile() === $this) {
                $shoppingCart->setProfile(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Purchase[]
     */
    public function getSelling(): Collection
    {
        return $this->selling;
    }

    public function addSelling(Purchase $selling): self
    {
        if (!$this->selling->contains($selling)) {
            $this->selling[] = $selling;
            $selling->setSeller($this);
        }

        return $this;
    }

    public function removeSelling(Purchase $selling): self
    {
        if ($this->selling->removeElement($selling)) {
            // set the owning side to null (unless already changed)
            if ($selling->getSeller() === $this) {
                $selling->setSeller(null);
            }
        }

        return $this;
    }
}
