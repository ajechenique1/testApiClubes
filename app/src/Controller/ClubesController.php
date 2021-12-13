<?php

namespace App\Controller;

use App\Entity\Clubes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ClubesRepository;
use App\Repository\JugadoresRepository;
use App\Repository\EntrenadoresRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClubesController extends AbstractController
{
    private $clubesRepository;
    private $jugadoresRepository;
    private $entrenadoresRepository;

    public function __construct(ClubesRepository $clubesRepository, JugadoresRepository $jugadoresRepository, EntrenadoresRepository $entrenadoresRepository)
    {
        $this->clubesRepository = $clubesRepository;
        $this->jugadoresRepository = $jugadoresRepository;
        $this->entrenadoresRepository = $entrenadoresRepository;
    }

    #[Route('/api/clubes', name: 'add_club', methods:'POST')]
    public function add(Request $request): JsonResponse
    {
        $dataRequest = json_decode($request->getContent(), true);
        
        $dataClub = [
            'name' => $dataRequest['name'],
            'description' => $dataRequest['description'],
            'total_budget' => $dataRequest['total_budget'],
            'enabled' => $dataRequest['enabled']
        ];

        $club = $this->clubesRepository->save($dataClub);

        return new JsonResponse(['status' => 'success', 'id' => $club->getId()], Response::HTTP_CREATED);
    }

    #[Route('/api/clubes/{id}', name: 'update_club', methods:'PUT')]
    public function update($id, Request $request): JsonResponse
    {
        $club = $this->clubesRepository->find($id);
        $dataRequest = json_decode($request->getContent(), true);
        $newTotalBudget = $dataRequest['total_budget'];
        $players = $this->jugadoresRepository->findBy(['club' => $id, 'enabled' => 1]);
        $traineers = $this->entrenadoresRepository->findBy(['club' => $id, 'enabled' => 1]);
        $sumSalary = 0;

        foreach($players as $player){
            if($player->getEnabled() == true){
                $sumSalary =  (float)$sumSalary + (float)$player->getSalary();
            }
        }

        foreach($traineers as $traineer){
            if($traineer->getEnabled() == true){
                $sumSalary =  (float)$sumSalary + (float)$traineer->getSalary();
            }
        }

        $newDisponibleBudget = (float)$newTotalBudget - (float)$sumSalary;
        if($newDisponibleBudget >= 0){
            $club->setTotalBudget((float)$newTotalBudget);
            $club->setDisponibleBudget((float)$newDisponibleBudget);
            $this->clubesRepository->update($club);
        }else{
            return new JsonResponse([
                'status' => 'error',
                'message' => 'El nuevo presupuesto es menor al presupuesto actual invertido en los Jugadores y/o Entrenadores.',
            ], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['status'=>'success'], Response::HTTP_OK);
    }
    
    #[Route('/api/clubes/{id}', name: 'get_one_club', methods:'GET')]
    public function get($id): JsonResponse
    {
        $club = $this->clubesRepository->findOneBy(['id' => $id]);

        $dataResponse = [
            'id' => $club->getId(),
            'name' => $club->getName(),
            'description' => $club->getDescription(),
            'total_budget' => $club->getTotalBudget(),
            'disponible_budget' => $club->getDisponibleBudget(),
            'enabled' => $club->getEnabled(),
        ];

        return new JsonResponse($dataResponse, Response::HTTP_OK);
    }

    #[Route('/api/clubes', name: 'get_all_clubes', methods:'GET')]
    public function getAll(): JsonResponse
    {
        $clubes = $this->clubesRepository->findAll();
        $dataResponse = [];

        foreach($clubes as $club){
            $dataResponse[] = [
                'id' => $club->getId(),
                'name' => $club->getName(),
                'description' => $club->getDescription(),
                'total_budget' => $club->getTotalBudget(),
                'disponible_budget' => $club->getDisponibleBudget(),
                'enabled' => $club->getEnabled(),
            ];
        }

        return new JsonResponse($dataResponse, Response::HTTP_OK);
    }

}
