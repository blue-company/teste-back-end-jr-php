<?php

namespace App\Entity;

use App\Repository\HospitalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HospitalRepository::class)]
class Hospital
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Column(length: 255)]
    private ?string $endereco = null;

    /**
     * @var Collection<int, Medico>
     */
    #[ORM\OneToMany(targetEntity: Medico::class, mappedBy: 'hospital')]
    private Collection $medicos;

    public function __construct()
    {
        $this->medicos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }

    public function getEndereco(): ?string
    {
        return $this->endereco;
    }

    public function setEndereco(string $endereco): static
    {
        $this->endereco = $endereco;

        return $this;
    }

    /**
     * @return Collection<int, Medico>
     */
    public function getMedicos(): Collection
    {
        return $this->medicos;
    }

    public function addMedico(Medico $medico): static
    {
        if (!$this->medicos->contains($medico)) {
            $this->medicos->add($medico);
            $medico->setHospital($this);
        }

        return $this;
    }

    public function removeMedico(Medico $medico): static
    {
        if ($this->medicos->removeElement($medico)) {
            // set the owning side to null (unless already changed)
            if ($medico->getHospital() === $this) {
                $medico->setHospital(null);
            }
        }

        return $this;
    }
}
