<?php

namespace App\Service\v1\Handler;

use Symfony\Component\HttpFoundation\Request;

interface ValidationHandlerInterface
{
    /**
     * @param Request $request
     * @param $requestClass
     */
    public function validateRequest(Request $request, $requestClass): void;
}
