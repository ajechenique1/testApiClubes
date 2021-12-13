<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\JugadoresRepository;
use App\Repository\ClubesRepository;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class JugadoresController extends AbstractController
{
    private $jugadoresRepository;
    private $clubesRepository;

    public function __construct(JugadoresRepository $jugadoresRepository, ClubesRepository $clubesRepository)
    {
        $this->jugadoresRepository = $jugadoresRepository;
        $this->clubesRepository = $clubesRepository;
    }

    #[Route('/api/jugadores', name: 'get_all_players', methods:'GET')]
    public function getAll(): JsonResponse
    {
        $players = $this->jugadoresRepository->findAll();

        $dataResponse = [];

        foreach($players as $player){
            $dataResponse[] = [
                'id' => $player->getId(),
                'document_number' => $player->getDocumentNumber(),
                'name' => $player->getName(),
                'lastname' => $player->getLastname(),
                'email' => $player->getEmail(),
                'code_country' => $player->getCodeCountry(),
                'phone' => $player->getPhone(),
                'number' => $player->getNumber(),
                'position' => $player->getPosition(),
                'salary' => $player->getSalary(),
                'enabled' => $player->getEnabled(),
                'club' => (empty($player->getClub()))? null : $player->getClub()->getName()
            ];
        }

        return new JsonResponse($dataResponse, Response::HTTP_OK);
    }

    #[Route('/api/jugadores', name: 'add_player', methods:'POST')]
    public function add(Request $request): JsonResponse
    {
        $dataRequest = json_decode($request->getContent(), true);

        if(!filter_var($dataRequest['email'], FILTER_VALIDATE_EMAIL)){
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Ingrese un email correcto',
            ], Response::HTTP_BAD_REQUEST);
        }

        $phone  = $dataRequest['code_country'].''.$dataRequest['phone'];
        if(!preg_match("/^\+[1-9]{1}[0-9]{3,14}$/", $phone))
        {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Ingrese un número de telefono valido',
            ], Response::HTTP_BAD_REQUEST);
        }

        $club = null;
        if(!empty($dataRequest['club'])){
            $club = $this->clubesRepository->findOneBy(['id' => $dataRequest['club']]);
            $currentDisponibleBudget = $club->getDisponibleBudget();
            $newDisponibleBudget = (float)$currentDisponibleBudget - (float)$dataRequest['salary'];
            if($newDisponibleBudget >= 0){
                $club->setDisponibleBudget((float)$newDisponibleBudget);
                $this->clubesRepository->update($club);
            }else{
                return new JsonResponse([
                    'status' => 'error',
                    'message' => 'El club no cuenta con suficiente presupuesto para agregar este jugador.',
                ], Response::HTTP_BAD_REQUEST);
            }
        }

        $dataPlayer = [
            'document_number' => $dataRequest['document_number'],
            'name' => $dataRequest['name'],
            'lastname' => $dataRequest['lastname'],
            'email' => $dataRequest['email'],
            'code_country' => $dataRequest['code_country'],
            'phone' => $dataRequest['phone'],
            'number' => $dataRequest['number'],
            'position' => $dataRequest['position'],
            'salary' => $dataRequest['salary'],
            'enabled' => $dataRequest['enabled'],
            'club_id' => $club,
        ];

        $player = $this->jugadoresRepository->save($dataPlayer);
        
        if(!empty($player)){
            $arrayMail = [
                'alta' => true,
                'to' => $player->getEmail(),
                'name' => $player->getName(),
                'number' => $player->getNumber(),
                'phone' => $player->getCodeCountry().''.$player->getPhone(),
                'position' => $player->getPosition(),
            ];
            $this->forward('App\Controller\ComunicacionController::sendEmail',[
                'arrayMail' => $arrayMail
            ]);
            //Envio de SMS
            /*$this->forward('App\Controller\ComunicacionController::sendMessage',[
                'arrayMail' => $arrayMail
            ]);/*
            //Envio de Whatsapp
            /*$this->forward('App\Controller\ComunicacionController::sendWhatsapp',[
                'arrayMail' => $arrayMail
            ]);*/
        }

        return new JsonResponse(['status' => 'success', 'id' => $player->getId()], Response::HTTP_CREATED);
    
    }

    #[Route('/api/jugadores/{id}', name: 'get_one_player', methods:'GET')]
    public function get($id): JsonResponse
    {
        $player = $this->jugadoresRepository->findOneBy(['id' => $id]);

        $dataResponse = [
            'id' => $player->getId(),
            'document_number' => $player->getDocumentNumber(),
            'name' => $player->getName(),
            'lastname' => $player->getLastname(),
            'email' => $player->getEmail(),
            'code_country' => $player->getCodeCountry(),
            'phone' => $player->getPhone(),
            'number' => $player->getNumber(),
            'position' => $player->getPosition(),
            'salary' => $player->getSalary(),
            'enabled' => $player->getEnabled(),
            'club' => (empty($player->getClub()))? null : $player->getClub()->getName()
        ];

        return new JsonResponse($dataResponse, Response::HTTP_OK);
    }

    #[Route('/api/club/jugadores/{idClub}', name: 'get_all_players_by_club', methods:'GET')]
    public function getByIdClub($idClub, Request $request): JsonResponse
    {
        $dataRequest = json_decode($request->getContent(), true);
        $filter = $dataRequest['filter'];
        $page = (empty($dataRequest['page']))? 1 : $dataRequest['page'];
        $limit = (empty($dataRequest['limit']))? 10 : $dataRequest['limit'];
        
        $players = $this->jugadoresRepository->findByIdClubAndFilter($idClub, $filter, $page, $limit);
        $playersResult = $players['paginator'];
        $playersFullResult = $players['query'];
        $maxPages = ceil($players['paginator']->count() / $limit);
        $dataResponse = [];
        $result = [
            'currentPage' => $page,
            'maxPages' => $maxPages
        ];

        foreach($playersResult as $player){
            $dataResponse[] = [
                'id' => $player->getId(),
                'document_number' => $player->getDocumentNumber(),
                'name' => $player->getName(),
                'lastname' => $player->getLastname(),
                'email' => $player->getEmail(),
                'code_country' => $player->getCodeCountry(),
                'phone' => $player->getPhone(),
                'number' => $player->getNumber(),
                'position' => $player->getPosition(),
                'salary' => $player->getSalary(),
                'enabled' => $player->getEnabled(),
                'club' => (empty($player->getClub()))? null : $player->getClub()->getName()
            ];
        }
        $result['data'] = $dataResponse;

        return new JsonResponse($result, Response::HTTP_OK);
    }

    #[Route('/api/club/jugadores/delete/{id}', name: 'delete_player_club', methods:'PUT')]
    public function deletePlayerClub($id): JsonResponse
    {
        $error = false;
        $response = [];

        $player= $this->jugadoresRepository->find($id);
        $club = $player->getClub();
        
        if(empty($club)){
            $error = true;
            $response = [
                'status' => 'error',
                'message' => 'El Jugador no está asociado a un Club',
            ];
        }else{
            $currentDisponibleBudget = $club->getDisponibleBudget();
            $currentTotalBudget = (float)$club->getTotalBudget();
            $newDisponibleBudget = (float)$currentDisponibleBudget + (float)$player->getSalary();
            if($newDisponibleBudget <= $currentTotalBudget){
                $player->setClub(null);
                $this->jugadoresRepository->update($player);
    
                $club->setDisponibleBudget((float)$newDisponibleBudget);
                $this->clubesRepository->update($club);

                if(!empty($player)){
                    $arrayMail = [
                        'alta' => false,
                        'to' => $player->getEmail(),
                        'name' => $player->getName(),
                    ];
                    $this->forward('App\Controller\ComunicacionController::sendEmail',[
                        'arrayMail' => $arrayMail
                    ]);
                }
            }else{
                $error = true;
                $response = [
                    'status' => 'error',
                    'message' => 'Inconsistencia en el presupuesto. Revisar salario del Jugador y Presupuesto Disponible',
                ];
            }
        }
        
        if($error){
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['status' => 'success'], Response::HTTP_OK);
    
    }

    #[Route('/api/club/jugadores/add/{id}/{idClub}', name: 'add_player_club', methods:'PUT')]
    public function addTrainnerClub($id, $idClub): JsonResponse
    {
        $error = false;
        $response = [];

        $player = $this->jugadoresRepository->find($id);
        $club = $this->clubesRepository->find($idClub);

        if(empty($club) || empty($player)){
            $error = true;
            $response = [
                'status' => 'error',
                'message' => 'El Jugador y/o el club no existen',
            ];
        }else{
            $currentDisponibleBudget = $club->getDisponibleBudget();
            $currentTotalBudget = (float)$club->getTotalBudget();
            $newDisponibleBudget = (float)$currentDisponibleBudget - (float)$player->getSalary();
            if($newDisponibleBudget <= $currentTotalBudget){
                $player->setClub($club);
                $this->jugadoresRepository->update($player);
                
                $club->setDisponibleBudget((float)$newDisponibleBudget);
                $this->clubesRepository->update($club);
            }else{
                $error = true;
                $response = [
                    'status' => 'error',
                    'message' => 'Inconsistencia en el presupuesto. Revisar salario del Jugador y Presupuesto Disponible',
                ];
            }
        }

        if($error){
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['status' => 'success'], Response::HTTP_OK);
    }
}

