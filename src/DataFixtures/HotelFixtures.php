<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Hotel;

class HotelFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $data = [
            [
                'name' => 'first',
                'place' => 'first',
                'url' => 'https://unsplash.com/photos/rlwE8f8anOc',
                'number' => 1
            ],
            [
                'name' => 'second',
                'place' => 'second',
                'url' => 'https://unsplash.com/photos/Koei_7yYtIo',
                'number' => 2
            ],
            [
                'name' => 'third',
                'place' => 'third',
                'url' => 'https://unsplash.com/photos/DGa0LQ0yDPc',
                'number' => 3
            ],
            [
                'name' => 'forth',
                'place' => 'forth',
                'url' => 'https://unsplash.com/photos/vmIWr0NnpCQ',
                'number' => 4
            ],
            [
                'name' => 'fifth',
                'place' => 'fifth',
                'url' => 'https://unsplash.com/photos/jr3ZPsaQwQo',
                'number' => 5
            ]
        ];

        foreach($data as $row) {
            $hotel = new Hotel();
            $hotel
                ->setName($row['name'])
                ->setPlace($row['place'])
                ->setUrl($row['url'])
                ->setNumber($row['number']);
            $manager->persist($hotel);

            $manager->flush();
        }            
    }
}
