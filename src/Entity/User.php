<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="user", orphanRemoval=true)
     */
    private $posts;

    /**
     * @ORM\OneToOne(targetEntity=ReTweet::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=ReTweet::class, mappedBy="user", orphanRemoval=true)
     */
    private $reTweets;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="subscribers")
     */
    private $subscribe;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="subscribe")
     */
    private $subscribers;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->reTweets = new ArrayCollection();
        $this->subscribes = new ArrayCollection();
        $this->subscribe = new ArrayCollection();
        $this->subscribers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setUser($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ReTweet[]
     */
    public function getReTweets(): Collection
    {
        return $this->reTweets;
    }

    public function addReTweet(ReTweet $reTweet): self
    {
        if (!$this->reTweets->contains($reTweet)) {
            $this->reTweets[] = $reTweet;
            $reTweet->setUser($this);
        }

        return $this;
    }

    public function removeReTweet(ReTweet $reTweet): self
    {
        if ($this->reTweets->removeElement($reTweet)) {
            // set the owning side to null (unless already changed)
            if ($reTweet->getUser() === $this) {
                $reTweet->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getSubscribe(): Collection
    {
        return $this->subscribe;
    }

    public function addSubscribe(self $subscribe): self
    {
        if (!$this->subscribe->contains($subscribe)) {
            $this->subscribe[] = $subscribe;
        }

        return $this;
    }

    public function removeSubscribe(self $subscribe): self
    {
        $this->subscribe->removeElement($subscribe);

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getSubscribers(): Collection
    {
        return $this->subscribers;
    }

    public function addSubscriber(self $subscriber): self
    {
        if (!$this->subscribers->contains($subscriber)) {
            $this->subscribers[] = $subscriber;
            $subscriber->addSubscribe($this);
        }

        return $this;
    }

    public function removeSubscriber(self $subscriber): self
    {
        if ($this->subscribers->removeElement($subscriber)) {
            $subscriber->removeSubscribe($this);
        }

        return $this;
    }
}
