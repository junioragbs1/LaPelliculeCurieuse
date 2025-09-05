<?php

namespace App\Entity;

use App\Repository\AvisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvisRepository::class)]
class Avis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $note = null;

    #[ORM\ManyToOne(inversedBy: 'utilisateur_avis')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $id_utilisateur = null;

    #[ORM\ManyToOne(inversedBy: 'serie_avis')]
    private ?Series $id_serie = null;

    #[ORM\ManyToOne(inversedBy: 'film_avis')]
    #[ORM\JoinColumn(nullable: false)]
    private ?films $id_film = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getIdUtilisateur(): ?Users
    {
        return $this->id_utilisateur;
    }

    public function setIdUtilisateur(?Users $id_utilisateur): static
    {
        $this->id_utilisateur = $id_utilisateur;

        return $this;
    }

    public function getIdSerie(): ?Series
    {
        return $this->id_serie;
    }

    public function setIdSerie(?Series $id_serie): static
    {
        $this->id_serie = $id_serie;

        return $this;
    }

    public function getIdFilm(): ?films
    {
        return $this->id_film;
    }

    public function setIdFilm(?films $id_film): static
    {
        $this->id_film = $id_film;

        return $this;
    }
}
