<?php

namespace App\Entity;

use App\Repository\SeriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeriesRepository::class)]
class Series
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $genre = null;

    #[ORM\Column(length: 255)]
    private ?string $affiche = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateDeSortie = null;

    #[ORM\Column]
    private ?int $duree = null;

    /**
     * @var Collection<int, Avis>
     */
    #[ORM\OneToMany(targetEntity: Avis::class, mappedBy: 'id_serie')]
    private Collection $serie_avis;

    #[ORM\Column(length: 100)]
    private ?string $realisateurs = null;

    public function __construct()
    {
        $this->serie_avis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getAffiche(): ?string
    {
        return $this->affiche;
    }

    public function setAffiche(string $affiche): static
    {
        $this->affiche = $affiche;

        return $this;
    }

    public function getDateDeSortie(): ?\DateTime
    {
        return $this->dateDeSortie;
    }

    public function setDateDeSortie(\DateTime $dateDeSortie): static
    {
        $this->dateDeSortie = $dateDeSortie;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getSerieAvis(): Collection
    {
        return $this->serie_avis;
    }

    public function addSerieAvi(Avis $serieAvi): static
    {
        if (!$this->serie_avis->contains($serieAvi)) {
            $this->serie_avis->add($serieAvi);
            $serieAvi->setIdSerie($this);
        }

        return $this;
    }

    public function removeSerieAvi(Avis $serieAvi): static
    {
        if ($this->serie_avis->removeElement($serieAvi)) {
            // set the owning side to null (unless already changed)
            if ($serieAvi->getIdSerie() === $this) {
                $serieAvi->setIdSerie(null);
            }
        }

        return $this;
    }

    public function getRealisateurs(): ?string
    {
        return $this->realisateurs;
    }

    public function setRealisateurs(string $realisateurs): static
    {
        $this->realisateurs = $realisateurs;

        return $this;
    }
}
