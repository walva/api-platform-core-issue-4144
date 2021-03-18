<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Ranking;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Annotation\ApiFilter;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
#[ApiResource(
    normalizationContext: [
        'skip_null_values' => false,
        'groups'           => ['default'],
    ],
        denormalizationContext: [
        'groups' => ['default'],
    ],
)]
#[ApiFilter(OrderFilter::class, properties: [
    'rankings.trendy' => [
        'nulls_comparison' => OrderFilter::NULLS_LARGEST,
    ],
])]
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['default'])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['default'])]
    private $name;

    /**
     * @ORM\Embedded(class=Ranking::class, columnPrefix = "ranking_")
     */
    #[Groups(['default'])]
    private $rankings;

    public function __construct(){
        $this->rankings = new Ranking();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getRankings() : Ranking
    {
        return $this->rankings;
    }

    public function setRankings($rankings): self
    {
        $this->rankings = $rankings;

        return $this;
    }
    
}
