<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Apartment
 *
 * @ORM\Table(name="apartment")
 * @ORM\Entity
 */
class Apartment
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="hotel_id", type="integer", nullable=false)
     */
    private $hotelId;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=false)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="string", length=255, nullable=false)
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="guests_count", type="integer", nullable=false)
     */
    private $guestsCount;

    /**
     * @var string|null
     *
     * @ORM\Column(name="square", type="string", length=50, nullable=true)
     */
    private $square;

    /**
     * @var string|null
     *
     * @ORM\Column(name="additionals", type="text", length=0, nullable=true)
     */
    private $additionals;

    /**
     * @var int
     *
     * @ORM\Column(name="number", type="integer", nullable=false)
     */
    private $number;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHotelId(): ?int
    {
        return $this->hotelId;
    }

    public function setHotelId(int $hotelId): self
    {
        $this->hotelId = $hotelId;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getGuestsCount(): ?int
    {
        return $this->guestsCount;
    }

    public function setGuestsCount(int $guestsCount): self
    {
        $this->guestsCount = $guestsCount;

        return $this;
    }

    public function getSquare(): ?string
    {
        return $this->square;
    }

    public function setSquare(?string $square): self
    {
        $this->square = $square;

        return $this;
    }

    public function getAdditionals(): ?string
    {
        return $this->additionals;
    }

    public function setAdditionals(?string $additionals): self
    {
        $this->additionals = $additionals;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getDataArray() 
    {
        return [
            'id' => $this->getId(),
            'hotel_id' => $this->getHotelId(),
            'url' => $this->getUrl(),
            'price' => $this->getPrice(),
            'guests_count' => $this->getGuestsCount(),
            'square' => $this->getSquare(),
            'additionals' => $this->getAdditionals(),
            'number' => $this->getNumber(),
        ];
    }

}
