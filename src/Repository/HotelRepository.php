<?php

namespace App\Repository;

use App\Entity\Hotel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Hotel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hotel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hotel[]    findAll()
 * @method Hotel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HotelRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(
        ManagerRegistry $registry,
        EntityManagerInterface $manager
    )
    {
        parent::__construct($registry, Hotel::class);
        $this->manager = $manager;
    }

    public function findAll()
    {
        return $this->findBy(array(), array('number' => 'ASC'));
    }

    public function saveHotel($name, $place, $url, $number)
    {
        $newHotel = new Hotel();

        $newHotel
            ->setName($name)
            ->setPlace($place)
            ->setUrl($url)
            ->setNumber($number);

        $this->manager->persist($newHotel);
        $this->manager->flush();
    }

    public function updateHotel(Hotel $hotel): Hotel
    {
        $this->manager->persist($hotel);
        $this->manager->flush();

        return $hotel;
    }

    public function removeHotel(Hotel $hotel)
    {
        $this->manager->remove($hotel);
        $this->manager->flush();
    }

    public function findByFilter($name, $place, $number)
    {
        $query = $this->createQueryBuilder('h');
        if ($name) {
            $query
                ->andWhere('h.name like :name')
                ->setParameter('name', '%' . $name . '%');
        }
        if ($place) {
            $query
                ->andWhere('h.place like :place')
                ->setParameter('place', '%' . $place . '%');
        } 
        if ($number) {
            $query
                ->andWhere('h.number = :num')
                ->setParameter('num', $number);
        }
        
        $query 
            ->orderBy('h.number', 'ASC')
            
            ->getQuery()
            ->getResult();
        return $query;
    }

    // /**
    //  * @return Hotel[] Returns an array of Hotel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Hotel
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
