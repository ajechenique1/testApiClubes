<?php

namespace App\Repository;

use App\Entity\Clubes;
use App\Entity\Jugadores;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Clubes[]    save( array $club) 
 * @method Clubes|null update (Decimal $amountBudget)
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

}
