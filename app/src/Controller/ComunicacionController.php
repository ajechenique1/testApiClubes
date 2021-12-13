<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Message;
use \Twilio\Rest\Client;


use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

class ComunicacionController extends AbstractController
{
    public function sendEmail(MailerInterface $mailer, $arrayMail): Response
    {

        $subject = '';
        $html = '';
        $name = $arrayMail['name'];
        if($arrayMail['alta'] == true){
            $subject = 'NOTIFICACION - FELICIDADES!!';
            $html = '<div><h1 style="text-align:center;color:#666;">FELICIDADES!</h1>
            <p style="text-align:center;color:#666;font-size:15pt;">Hola, '.$arrayMail['name'].' nos complace informarte que has sido ingresado a la aplicacion de La LIGA. </p>
            </div>
            <footer>
                <p style="text-align:center;color:#ccc;font-size:10pt;">Este es un correo automatico, por favor no responder.</p>
            </footer>';
        }else{
            $subject = 'NOTIFICACION - LO SENTIMOS...';
            $html = '<div><h1 style="text-align:center;color:#666;">LO SENTIMOS!</h1>
            <p style="text-align:center;color:#666;font-size:15pt;">Hola, '.$arrayMail['name'].' te informamos que te han dado de baja en la aplicacion de La LIGA. </p>
            </div>
            <footer>
                <p style="text-align:center;color:#ccc;font-size:10pt;">Este es un correo automatico, por favor no responder.</p>
            </footer>';
        }

        $email = (new Email())
            //->from(env('MAIL_FROM'))
            ->from('aechenique@dtransforma.com')
            ->to(new Address($arrayMail['to'], $arrayMail['name']))
            ->subject($subject)
            ->html($html);
        
        try {
            $mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            echo $e->getMessage();
        }

        return $this->json([
            'message' => 'ok'
        ]);
    }

    public function sendMessage($arrayMail): Response
    {
        $sid = getenv("TWILIO_SID");
        $token = getenv("TWILIO_TOKEN");
        $message_sid = getenv("TWILIO_MESSAGING_SID");
        $to = $arrayMail['phone'];
        $from =  getenv("TWILIO_NUMBER_FROM");

        $twilio = new Client($sid, $token);
        $message = '';

        if($arrayMail['alta'] == true){
            $message = 'Hola, '.$arrayMail['name'].' nos complace informarte que has sido ingresado a la aplicacion de La LIGA.';
        }else{
            $message = 'Hola, '.$arrayMail['name'].' te informamos que te han dado de baja en la aplicacion de La LIGA.';
        }
        
        $message = $twilio->messages 
                        ->create($to,
                                [ 
                                    "from" => $from, 
                                    "messagingServiceSid" => $message_sid,      
                                    "body" => $message 
                                ]
                        ); 
        
        
        return $this->json([
            'message' => $message->sid
        ]);
    }

    public function sendWhatsapp($arrayMail): Response
    {
        $sid = getenv("TWILIO_SID");
        $token = getenv("TWILIO_TOKEN");
        $message_sid = getenv("TWILIO_MESSAGING_SID");
        $to = $arrayMail['phone'];
        $from =  getenv("TWILIO_NUMBER_WS_FROM");

        $twilio = new Client($sid, $token);
        $message = '';

        if($arrayMail['alta'] == true){
            $message = 'Hola, '.$arrayMail['name'].' nos complace informarte que has sido ingresado a la aplicacion de La LIGA.';
        }else{
            $message = 'Hola, '.$arrayMail['name'].' te informamos que te han dado de baja en la aplicacion de La LIGA.';
        }
        
        $message = $twilio->messages 
                  ->create("whatsapp:".$to,
                           array( 
                               "from" => "whatsapp:".$from,       
                               "body" => $message
                           ) 
                  ); 
        
        
        return $this->json([
            'message' => $message->sid
        ]);
    }
}

