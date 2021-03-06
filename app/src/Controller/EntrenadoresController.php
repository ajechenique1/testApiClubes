<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\EntrenadoresRepository;
use App\Repository\ClubesRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class EntrenadoresController extends AbstractController
{
    private $entrenadoresRepository;
    private $clubesRepository;

    public function __construct(EntrenadoresRepository $entrenadoresRepository, ClubesRepository $clubesRepository)
    {
        $this->entrenadoresRepository = $entrenadoresRepository;
        $this->clubesRepository = $clubesRepository;
    }

    #[Route('/api/entrenadores', name: 'get_all_traineers', methods:'GET')]
    public function getAll(): JsonResponse
    {
        $traineers = $this->entrenadoresRepository->findAll();

        $dataResponse = [];

        foreach($traineers as $traineer){
            $dataResponse[] = [
                'id' => $traineer->getId(),
                'document_number' => $traineer->getDocumentNumber(),
                'name' => $traineer->getName(),
                'lastname' => $traineer->getLastname(),
                'description' => $traineer->getDescription(),
                'email' => $traineer->getEmail(),
                'code_country' => $traineer->getCodeCountry(),
                'phone' => $traineer->getPhone(),
                'salary' => $traineer->getSalary(),
                'enabled' => $traineer->getEnabled(),
                'club' => (empty($traineer->getClub()))? null : $traineer->getClub()->getName()
            ];
        }

        return new JsonResponse($dataResponse, Response::HTTP_OK);
    }

    #[Route('/api/entrenadores', name: 'add_traineer', methods:'POST')]
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
                'message' => 'Ingrese un n??mero de telefono valido',
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
                    'message' => 'El club no cuenta con suficiente presupuesto para agregar este entrenador.',
                ], Response::HTTP_BAD_REQUEST);
            }
        }

        $dataTraineer = [
            'document_number' => $dataRequest['document_number'],
            'name' => $dataRequest['name'],
            'lastname' => $dataRequest['lastname'],
            'description' => $dataRequest['description'],
            'email' => $dataRequest['email'],
            'code_country' => $dataRequest['code_country'],
            'phone' => $dataRequest['phone'],
            'salary' => $dataRequest['salary'],
            'enabled' => $dataRequest['enabled'],
            'club_id' => $club,
        ];
        
        $traineer = $this->entrenadoresRepository->save($dataTraineer);
        if(!empty($traineer)){
            $arrayMail = [
                'alta' => true,
                'to' => $traineer->getEmail(),
                'name' => $traineer->getName(),
                'phone' => $traineer->getCodeCountry().''.$traineer->getPhone(),
                'description' => $traineer->getDescription(),
            ];
            $this->forward('App\Controller\ComunicacionController::sendEmail',[
                'arrayMail' => $arrayMail
            ]);
            //Envio de SMS
            /*$this->forward('App\Controller\ComunicacionController::sendMessage',[
                'arrayMail' => $arrayMail
            ]);*/
            //Envio de Whatsapp
            /*$this->forward('App\Controller\ComunicacionController::sendWhatsapp',[
                'arrayMail' => $arrayMail
            ]);*/
        }
        
        return new JsonResponse(['status' => 'success', 'id' => $traineer->getId()], Response::HTTP_CREATED);
    }

    #[Route('/api/entrenadores/{id}', name: 'get_one_traineer', methods:'GET')]
    public function get($id): JsonResponse
    {
        $traineer = $this->entrenadoresRepository->find($id);

        $dataResponse[] = [
            'id' => $traineer->getId(),
            'document_number' => $traineer->getDocumentNumber(),
            'name' => $traineer->getName(),
            'lastname' => $traineer->getLastname(),
            'description' => $traineer->getDescription(),
            'email' => $traineer->getEmail(),
            'code_country' => $traineer->getCodeCountry(),
            'phone' => $traineer->getPhone(),
            'salary' => $traineer->getSalary(),
            'enabled' => $traineer->getEnabled(),
            'club' => (empty($traineer->getClub()))? null : $traineer->getClub()->getName()
        ];

        return new JsonResponse($dataResponse, Response::HTTP_OK);
    }

    #[Route('/api/club/entrenadores/delete/{id}', name: 'delete_traineer_club', methods:'PUT')]
    public function deleteTrainnerClub($id): JsonResponse
    {
        $error = false;
        $response = [];

        $traineer = $this->entrenadoresRepository->find($id);
        $club = $traineer->getClub();

        if(empty($club)){
            $error = true;
            $response = [
                'status' => 'error',
                'message' => 'El Jugador no est?? asociado a un Club',
            ];
        }else{
            $currentDisponibleBudget = $club->getDisponibleBudget();
            $currentTotalBudget = (float)$club->getTotalBudget();
            $newDisponibleBudget = (float)$currentDisponibleBudget + (float)$traineer->getSalary();
            if($newDisponibleBudget <= $currentTotalBudget){
                $traineer->setClub(null);
                $this->entrenadoresRepository->update($traineer);

                $club->setDisponibleBudget((float)$newDisponibleBudget);
                $this->clubesRepository->update($club);

                if(!empty($traineer)){
                    $arrayMail = [
                        'alta' => false,
                        'to' => $traineer->getEmail(),
                        'name' => $traineer->getName(),
                    ];
                    $this->forward('App\Controller\ComunicacionController::sendEmail',[
                        'arrayMail' => $arrayMail
                    ]);
                }
            }else{
                $error = true;
                $response = [
                    'status' => 'error',
                    'message' => 'Inconsistencia en el presupuesto. Revisar salario del Entrenador y Presupuesto Disponible',
                ];
            }
        }

        if($error){
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['status'=>'success'], Response::HTTP_OK);
    }

    #[Route('/api/club/entrenadores/add/{id}/{idClub}', name: 'add_traineer_club', methods:'PUT')]
    public function addTrainnerClub($id, $idClub): JsonResponse
    {
        $error = false;
        $response = [];
        
        $traineer = $this->entrenadoresRepository->find($id);
        $club = $this->clubesRepository->find($idClub);
        
        if(empty($club) || empty($player)){
            $error = true;
            $response = [
                'status' => 'error',
                'message' => 'El Entrenador y/o el club no existen',
            ];
        }else{
            $currentDisponibleBudget = $club->getDisponibleBudget();
            $currentTotalBudget = (float)$club->getTotalBudget();
            $newDisponibleBudget = (float)$currentDisponibleBudget - (float)$traineer->getSalary();
            if($newDisponibleBudget <= $currentTotalBudget){
                $traineer->setClub($club);
                $this->entrenadoresRepository->update($traineer);
                
                $club->setDisponibleBudget((float)$newDisponibleBudget);
                $this->clubesRepository->update($club);
            }else{
                $error = true;
                $response = [
                    'status' => 'error',
                    'message' => 'Inconsistencia en el presupuesto. Revisar salario del Entrenador y Presupuesto Disponible',
                ];
            }
        }

        if($error){
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['status'=>'success'], Response::HTTP_OK);
    }

}
