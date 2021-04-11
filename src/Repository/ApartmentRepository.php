<?php

namespace App\Repository;

use App\Entity\Apartment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Apartment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Apartment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Apartment[]    findAll()
 * @method Apartment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApartmentRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(
        ManagerRegistry $registry,
        EntityManagerInterface $manager
    )
    {
        parent::__construct($registry, Apartment::class);
        $this->manager = $manager;
    }

    /**
     * @return Apartment[] Returns an array of Apartment objects
     */
    public function findByHotelId($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.hotelId = :val')
            ->setParameter('val', $value)
            ->orderBy('a.number', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findAll()
    {
        return $this->findBy(array(), array('number' => 'ASC'));
    }

    public function saveApartment($data)
    {
        $newApartment = new Apartment();

        $newApartment
            ->setHotelId($data['hotel_id'])
            ->setUrl($data['url'])
            ->setPrice($data['price'])
            ->setGuestsCount($data['guests_count'])
            ->setSquare($data['square'])
            ->setAdditionals($data['additionals'])
            ->setNumber($data['number']);

        $this->manager->persist($newApartment);
        $this->manager->flush();
    }

    public function updateApartment(Apartment $apartment): Apartment
    {
        $this->manager->persist($apartment);
        $this->manager->flush();

        return $apartment;
    }

    public function removeApartment(Apartment $apartment)
    {
        $this->manager->remove($apartment);
        $this->manager->flush();
    }

    // /**
    //  * @return Apartment[] Returns an array of Apartment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Apartment
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
