<?php

declare(strict_types=1);

namespace AppTest\Handler;

use App\Handler\DefaultHandler;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;
use Slim\Views\Twig;

use function sprintf;

class DefaultHandlerTest extends TestCase
{
    public function testRenderCorrectInformation(): void
    {
        $handler  = new DefaultHandler();
        $response = new Response();
        $request  = $this->createMock(ServerRequestInterface::class);
        $twig     = Twig::create(
            __DIR__ . '/../../templates',
            ['cache' => false]
        );
        $request
            ->expects($this->once())
            ->method("getAttribute")
            ->with("view")
            ->willReturn($twig);

        $body = <<<EOF
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/styles.css" rel="stylesheet">
    <title>The Current Date Where You Are</title>
</head>

<body class="mx-auto flex items-center bg-slate-100 text-stone-900">
    <section class="h-screen font-semibold rounded-md text-7xl flex items-center justify-center w-screen">%s</section>
</body>

</html>
EOF;

        $result = $handler($request, $response, []);
        $this->assertSame(
            sprintf($body, (new DateTimeImmutable())->format("D, F jS, Y")),
            (string) $result->getBody()
        );
        $this->assertSame(200, $result->getStatusCode());
    }
}
