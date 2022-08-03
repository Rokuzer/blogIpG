<?php

namespace App\Entity;

use App\Repository\BlogRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use JsonSerializable;

#[ORM\Entity(repositoryClass: BlogRepository::class)]
class Blog implements JsonSerializable
{
    #[ORM\Column(type: 'integer')]
    #[ORM\Id, ORM\GeneratedValue()]
    private $id;

    #[ORM\Column(length: 255, nullable: true)]
    private $codigo;

    #[ORM\Column(length: 255)]
    private $title;

    #[ORM\Column(type: Types::TEXT)]
    private $body;

    #[ORM\Column(length: 255)]
    private $autor;


    #[ORM\Column(type: 'datetime', nullable: true)]
    protected $created_at;

    #[ORM\Column(type: 'datetime', nullable: true)]
    protected $update_at;

    /**
     * @var datetime $updated
     *
     * @ORM\Column(type="datetime", nullable = true)
     */
    protected $updated_at;

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

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getAutor(): ?string
    {
        return $this->autor;
    }

    public function setAutor(string $autor): self
    {
        $this->autor = $autor;

        return $this;
    }

    public function geCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->update_at;
    }

    public function setUpdateAt($update_at): self
    {
        $this->update_at = $update_at;

        return $this;
    }

    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'codigo' => $this->codigo,
            'title' => $this->title,
            'body'=> $this->body,
        );
    }
}
