<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Ranking;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;

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
// #[ApiFilter(OrderFilter::class, properties: [
//     'rankings.trendy',
// ])]
#[ApiFilter(OrderFilter::class, properties: [
    'rankings.trendy' => [
        'nulls_comparison' => OrderFilter::NULLS_SMALLEST,
    ],
])]
#[ApiFilter(RangeFilter::class, properties: ['dummyInteger'])]
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

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    #[Groups(['default'])]
    private $dummyInteger;

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

    public function getDummyInteger(): ?int
    {
        return $this->dummyInteger;
    }

    public function setDummyInteger(?int $dummyInteger): self
    {
        $this->dummyInteger = $dummyInteger;

        return $this;
    }
    
}
