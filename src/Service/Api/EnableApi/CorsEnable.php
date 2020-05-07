<?php

namespace App\Service\Api\EnableApi;

use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpFoundation\RequestStack;

class CorsEnable
{

    private $response;
    private $enableResponseModify;
    protected $requestStack;

    public function __construct(
        $enableCORS,
        RequestStack $requestStack
    )
    {
        $this->enableResponseModify = $enableCORS;
        $this->requestStack = $requestStack;
    }

    public function onKernelResponse(ResponseEvent $responseEvent)
    {
        if ( $this->enableResponseModify ) {

            // Извлечение текущего запроса
            $request = $this->requestStack->getCurrentRequest();

            if ($responseEvent->getRequest()->getMethod() === 'OPTIONS') {
                // Вручную разрешаем CORS для функционирования Api,
                // устанавливая 204 ответ при запросе типа "OPTIONS"
                $responseEvent->setResponse(
                    new Response('', 204, [
                        'Access-Control-Allow-Origin' => '*',
                        'Access-Control-Allow-Credentials' => 'true',
                        'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS, HEAD',
                        'Access-Control-Allow-Headers' => 'DNT, Overwrite, Destination, X-Auth-Token, Keep-Alive, User-Agent, X-Requested-With, X-File-Name, X-File-Size, If-Modified-Since, Cache-Control, Content-Type',
                        'Access-Control-Max-Age' => 1728000,
                        'Content-Type' => 'application/json; charset=UTF-8',
                        'Content-Length' => 0
                    ])
                );
                return;
            }

            $this->response = $responseEvent->getResponse();

            // Вручную разрешаем CORS для функционирования Api
            $this->response->headers->set('Access-Control-Allow-Origin', '*');
            $this->response->headers->set('Access-Control-Allow-Credentials', 'true');
            $this->response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, UPDATE, OPTIONS, HEAD');
            $this->response->headers->set('Access-Control-Allow-Headers', 'DNT, Overwrite, Destination, X-Auth-Token, Keep-Alive, User-Agent, X-Requested-With, X-File-Name, X-File-Size, If-Modified-Since, Cache-Control, Content-Type');
            $this->response->headers->set('Access-Control-Max-Age', 1728000);

        }
    }

}