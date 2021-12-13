<?php

namespace App\Repository;

use App\Entity\Entrenadores;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Entrenadores|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entrenadores|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entrenadores[]    findAll()
 * @method Entrenadores[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntrenadoresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Entrenadores::class);
        $this->manager = $manager;
    }

    public function save($arrayTrainer)
    {
        $trainer = new Entrenadores();
        $trainer
            ->setDocumentNumber($arrayTrainer['document_number'])
            ->setName($arrayTrainer['name'])
            ->setLastname($arrayTrainer['lastname'])
            ->setDescription($arrayTrainer['description'])
            ->setEmail($arrayTrainer['email'])
            ->setCodeCountry($arrayTrainer['code_country'])
            ->setPhone($arrayTrainer['phone'])
            ->setSalary($arrayTrainer['salary'])
            ->setEnabled($arrayTrainer['enabled'])
            ->setClub($arrayTrainer['club_id']);
        
        $this->manager->persist($trainer);
        $this->manager->flush();
        
        return $trainer;
    }

    public function update(Entrenadores $entrenadores): Entrenadores
    {
        $this->manager->persist($entrenadores);
        $this->manager->flush();
        
        return $entrenadores;
    }

    public function findByIdClubAndFilter($clubId, $filter, $currentPage = 1)
    {
        return $this->createQueryBuilder('e')
        ->andWhere('e.name LIKE :filt')
        ->orWhere('e.lastname LIKE :filt')
        ->orWhere('e.email LIKE :filt')
        ->andWhere('e.enabled = 1')
        ->andWhere('e.club = :cl')
        ->setParameter('cl', $clubId)
        ->setParameter('filt', '%'.$filter.'%')
        ->orderBy('e.id', 'ASC')
        ->getQuery()
        ->getResult();
    }

    // /**
    //  * @return Entrenadores[] Returns an array of Entrenadores objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Entrenadores
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
