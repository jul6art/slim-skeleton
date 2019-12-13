<?php


namespace App\Application\Middleware;

use Psr\Http\Message\UriInterface;
use Slim\Interfaces\RouteCollectorInterface;
use Slim\Routing\RouteCollector;
use Slim\Views\Twig;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

/**
 * Class TwigExtensionsMiddleware
 * @package App\Application\Middleware
 */
class TwigExtensionsMiddleware implements Middleware {
    /**
     * @var Twig
     */
    private $twig;

    /**
     * TwigExtensionsMiddleware constructor.
     * @param Twig $twig
     */
    public function __construct(Twig $twig)
    {
        $this->twig   = $twig;
    }

    /**
     * @param Request $request
     * @param RequestHandler $handler
     * @return Response
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        $this->twig->addExtension(new class () extends AbstractExtension {
            /**
             * @return array|TwigFunction[]
             */
            public function getFunctions()
            {
                return [
                    new TwigFunction('asset', function (string $path) : string {
                        return sprintf(
                            '%s%s%s%s',
                            DIRECTORY_SEPARATOR,
                            'assets',
                            DIRECTORY_SEPARATOR,
                            $path
                        );
                    }),
                    new TwigFunction('dump', function ($data) : void {
                        $openTag = '<div style="background: #000; padding: 10px 20px;">';
                        ini_set("highlight.default", "#56db3a;  font-weight: bolder");
                        ini_set("highlight.keyword", "#ff8400;  font-weight: bolder");
                        ini_set("highlight.string", "#ffffff; font-weight: lighter; ");
                        ini_set("highlight.comment", "#b729d9; font-weight: lighter; ");
                        ini_set("highlight.html", "#b729d9; font-weight: lighter; ");

                        ob_start();
                        highlight_string("<?php\n" . var_export($data, true) . "?>");
                        $highlighted_output = ob_get_clean();

                        $highlighted_output = str_replace( "&lt;?php", '', $highlighted_output );
                        $highlighted_output = str_replace( "?&gt;", '', $highlighted_output );
                        $closeTag = '</div>';

                        echo "$openTag$highlighted_output$closeTag";
                    }),
                ];
            }

        });
        return $handler->handle($request);
    }
}