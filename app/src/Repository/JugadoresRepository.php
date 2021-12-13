<?php

namespace App\Repository;

use App\Entity\Jugadores;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method Jugadores|null find($id, $lockMode = null, $lockVersion = null)
 * @method Jugadores|null findOneBy(array $criteria, array $orderBy = null)
 * @method Jugadores[]    findAll()
 * @method Jugadores[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JugadoresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Jugadores::class);
        $this->manager = $manager;
    }

    public function save($arrayPlayer)
    {
        $player = new Jugadores();
        $player
            ->setDocumentNumber($arrayPlayer['document_number'])
            ->setName($arrayPlayer['name'])
            ->setLastname($arrayPlayer['lastname'])
            ->setEmail($arrayPlayer['email'])
            ->setCodeCountry($arrayPlayer['code_country'])
            ->setPhone($arrayPlayer['phone'])
            ->setNumber($arrayPlayer['number'])
            ->setPosition($arrayPlayer['position'])
            ->setSalary($arrayPlayer['salary'])
            ->setEnabled($arrayPlayer['enabled'])
            ->setClub($arrayPlayer['club_id']);
        
        $this->manager->persist($player);
        $this->manager->flush();
        
        return $player;
    }

    public function update(Jugadores $jugadores): Jugadores
    {
        $this->manager->persist($jugadores);
        $this->manager->flush();
        
        return $jugadores;
    }

    public function findByIdClubAndFilter($clubId, $filter, $currentPage,  $limit)
    {
        $query = $this->createQueryBuilder('j')
        ->andWhere('j.name LIKE :filt')
        ->orWhere('j.lastname LIKE :filt')
        ->orWhere('j.email LIKE :filt')
        ->andWhere('j.enabled = 1')
        ->andWhere('j.club = :cl')
        ->setParameter('cl', $clubId)
        ->setParameter('filt', '%'.$filter.'%')
        ->orderBy('j.id', 'ASC')
        ->getQuery();

        $paginator = $this->paginate($query, $currentPage, $limit);

        return array('paginator' => $paginator, 'query' => $query);
    }

    public function paginate($dql, $page, $limit)
    {
        $paginator = new Paginator($dql);

        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit);

        return $paginator;
    }

    

    // /**
    //  * @return Jugadores[] Returns an array of Jugadores objects
    //  */
    
}
