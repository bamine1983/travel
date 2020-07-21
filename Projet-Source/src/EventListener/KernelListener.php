<?php


namespace App\EventListener;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class KernelListener
{


    public function onKernelRequest(GetResponseEvent $event)
    {
        if ($event->getRequestType() !== \Symfony\Component\HttpKernel\HttpKernel::MASTER_REQUEST) {
            return;
        }

        $bannedIps = array('172.16.0.1', '172.16.0.2', '172.16.0.3');
        dump($bannedIps);
        if (in_array($event->getRequest()->getClientIp(), $bannedIps)) {
            $event->setResponse(new Response('Your IP is banned', 403));
        }

    }


}