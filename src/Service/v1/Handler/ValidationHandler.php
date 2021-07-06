<?php
declare(strict_types=1);

namespace App\Service\v1\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidationHandler implements ValidationHandlerInterface
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @inheritDoc
     */
    public function validateRequest(Request $request, $requestClass): void
    {
        $content = json_decode($request->getContent(), true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            //throw new ValidationException();
        }
        $requestClass->fill($content);
        $errors = $this->validator->validate($requestClass);
        if ($errors->count() > 0) {
            // throw new ValidationException()
        }
    }
}
