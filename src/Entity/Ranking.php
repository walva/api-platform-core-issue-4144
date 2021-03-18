<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/** @ORM\Embeddable  */
class Ranking
{
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    #[Groups(["default"])]
    private $trendy;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    #[Groups(["default"])]
    private $popular;

    public function getTrendy(): ?int
    {
        return $this->trendy;
    }

    public function setTrendy(?int $trendy): self
    {
        $this->trendy = $trendy;

        return $this;
    }

    public function getPopular(): ?int
    {
        return $this->popular;
    }

    public function setPopular(?int $popular): self
    {
        $this->popular = $popular;

        return $this;
    }
}
