<?php

namespace App\Repository;

use App\Entity\Clubes;
use App\Entity\Jugadores;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Clubes[]    save()
 * @method Clubes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Clubes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Clubes[]    findAll()
 * @method Clubes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClubesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Clubes::class);
        $this->manager = $manager;
    }

    public function save($arrayClub)
    {
        $club = new Clubes();
        $club
            ->setName($arrayClub['name'])
            ->setDescription($arrayClub['description'])
            ->setTotalBudget($arrayClub['total_budget'])
            ->setDisponibleBudget($arrayClub['total_budget'])
            ->setEnabled($arrayClub['enabled']);
        
        $this->manager->persist($club);
        $this->manager->flush();
        
        return $club;
    }
    
    public function update(Clubes $club): Clubes
    {
        $this->manager->persist($club);
        $clubCreated = $this->manager->flush();
        
        return $club;
    }

    /**
    * @return Clubes[] Returns an array of a Clube objects
    */
    /*
    public function findByOne($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    

    // /**
    //  * @return Clubes[] Returns an array of Clubes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Clubes
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
