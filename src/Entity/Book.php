<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ORM\ChangeTrackingPolicy('DEFERRED_EXPLICIT')] // $bookRepository->save($book) to mark entity as updated
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Assert\Isbn(type: 'isbn13')]
    #[ORM\Column(length: 25)]
    private ?string $isbn = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $author = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $releasedAt = null;

    #[Assert\Length(min: 15)]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $plot = null;

    #[Assert\Unique]
    #[Assert\Valid]
    #[ORM\OneToMany(mappedBy: 'book', targetEntity: Comment::class, cascade: ['persist'], fetch: 'EXTRA_LAZY', orphanRemoval: true)]
    private Collection $comments;

    #[ORM\ManyToMany(targetEntity: BookGenre::class, inversedBy: 'books')]
    private Collection $genres;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->genres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getReleasedAt(): ?\DateTimeImmutable
    {
        return $this->releasedAt;
    }

    public function setReleasedAt(\DateTimeImmutable $releasedAt): self
    {
        $this->releasedAt = $releasedAt;

        return $this;
    }

    public function getPlot(): ?string
    {
        return $this->plot;
    }

    public function setPlot(?string $plot): self
    {
        $this->plot = $plot;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setBook($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getBook() === $this) {
                $comment->setBook(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BookGenre>
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(BookGenre $genre): self
    {
        if (!$this->genres->contains($genre)) {
            $this->genres->add($genre);
        }

        return $this;
    }

    public function removeGenre(BookGenre $genre): self
    {
        $this->genres->removeElement($genre);

        return $this;
    }
}
