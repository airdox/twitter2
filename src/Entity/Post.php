<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
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
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=ReTweet::class, mappedBy="post", orphanRemoval=true)
     */
    private $reTweets;

    public function __construct()
    {
        $this->reTweets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getcontent(): ?string
    {
        return $this->content;
    }

    public function setcontent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
            $reTweet->setPost($this);
        }

        return $this;
    }

    public function removeReTweet(ReTweet $reTweet): self
    {
        if ($this->reTweets->removeElement($reTweet)) {
            // set the owning side to null (unless already changed)
            if ($reTweet->getPost() === $this) {
                $reTweet->setPost(null);
            }
        }

        return $this;
    }
}
