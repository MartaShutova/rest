<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Apartment;

class ApartmentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $data = [
            [
                'hotel_id' => 1,
                'url' => 'https://unsplash.com/photos/mr0Dp231IEw',
                'price' => '1000.00$',
                'guests_count' => 5,
                'square' => 25,
                'additionals' => '',
                'number' => 8
            ],
            [
                'hotel_id' => 1,
                'url' => 'https://unsplash.com/photos/w72a24brINI',
                'price' => '900.00$',
                'guests_count' => 3,
                'square' => 15,
                'additionals' => 'bicycle',
                'number' => 10
            ],
            [
                'hotel_id' => 3,
                'url' => 'https://unsplash.com/photos/AH8zKXqFITA',
                'price' => '1500.00$',
                'guests_count' => 2,
                'square' => 20,
                'additionals' => 'kingsize',
                'number' => 1
            ],
            [
                'hotel_id' => 3,
                'url' => 'https://unsplash.com/photos/VoEocAfaWG8',
                'price' => '700.00$',
                'guests_count' => 4,
                'square' => 25,
                'additionals' => 'gbsrhrdxgbv',
                'number' => 3
            ],
            [
                'hotel_id' => 4,
                'url' => 'https://unsplash.com/photos/VGs8z60yT2c',
                'price' => '500.00$',
                'guests_count' => 1,
                'square' => 10,
                'additionals' => '11111111111',
                'number' => 6
            ]
        ];

        foreach($data as $row) {
            $apartment = new Apartment();
            $apartment
                ->setHotelId($row['hotel_id'])
                ->setUrl($row['url'])
                ->setPrice($row['price'])
                ->setGuestsCount($row['guests_count'])
                ->setSquare($row['square'])
                ->setAdditionals($row['additionals'])
                ->setNumber($row['number']);
            $manager->persist($apartment);

            $manager->flush();
        }       
    }
}
