<?php

namespace App\Repository;

use App\Entity\Entrenadores;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Entrenadores[]    save(array $entrenadores) 
 * @method Entrenadores[]    update(object $entrenadores)
 * @method Entrenadores[]    findByIdClubAndFilter(integer $clubId, string $filter, integer $currentPage = 1)
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

    public function findByIdClubAndFilter($clubId, $filter)
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
    

}
