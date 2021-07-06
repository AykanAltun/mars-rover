<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Yaml\Yaml;

final class Documentation extends AbstractController
{
    #[Route("/", methods: ["GET"])]
    public function __invoke(): Response
    {
        return $this->render(
            'index.html.twig',
            ['spec' => json_encode(Yaml::parseFile($_SERVER['DOCUMENT_ROOT'] . '/../swagger/swagger.yaml'))]
        );
    }
}