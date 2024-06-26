<?php
/**
 * Post entity.
 */

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Comment.
 *
 * @psalm-suppress MissingConstructor
 */
#[ORM\Entity(repositoryClass: CommentRepository::class)]
#[ORM\Table(name: 'comments')]
class Comment
{
    private $comments;
    /**
     * Primary key.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;



    /**
     * Email
     */
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $email= null;

    /**
     * Nick
     */
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $nick = null;

    /**
     * Content.
     */
    #[ORM\Column(type: 'string', length: 1000)]
    private ?string $content = null;


    /**
     * Post.
     */
    #[ORM\ManyToOne(targetEntity: Post::class, fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Type(Post::class)]
    private ?Post $post = null;



    /**
     * Constructor.
     */
    public function __construct()
    {


    }

    /**
     * Getter for Id.
     *
     * @return int|null Id
     */
    public function getId(): ?int
    {
        return $this->id;
    }







    /**
     * Getter for email.
     *
     * @return string|null Email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Setter for email.
     *
     * @param string|null $email Email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }
    /**
     * Getter for nick.
     *
     * @return string|null Nick
     */
    public function getNick(): ?string
    {
        return $this->nick;
    }

    /**
     * Setter for nick.
     *
     * @param string|null $nick Nick
     */
    public function setNick(?string $nick): void
    {
        $this->nick = $nick;
    }
    /**
     * Getter for content.
     *
     * @return string|null Content
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Setter for content.
     */
    public function setContent(?string $content): void
    {
        $this->content = $content;
    }




    /**
     * Getter for author.
     *
     * @return Post|null Post
     */
    public function getPost(): ?Post
    {
        return $this->post;
    }

    /**
     * Setter for post
     *
     * @param Post|null $post Post
     */
    public function setPost(?Post $post): static
    {
        $this->post = $post;

        return $this;
    }




}