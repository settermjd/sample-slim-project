<?php

declare(strict_types=1);

namespace App\Handler;

use DateTimeImmutable;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

final readonly class DefaultHandler
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'home.html.twig', [
            'date_time' => (new DateTimeImmutable())->format("D, F jS, Y"),
        ]);
    }
}
