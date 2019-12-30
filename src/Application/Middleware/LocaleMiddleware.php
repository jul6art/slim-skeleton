<?php
declare(strict_types=1);

namespace App\Application\Middleware;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\UriInterface;
use Illuminate\Contracts\Translation\Translator;
use Slim\Views\Twig;

/**
 * Class LocaleMiddleware
 * @package App\Application\Middleware
 */
class LocaleMiddleware implements Middleware
{
    /**
     * @var Twig
     */
    private $twig;

    /**
     * Translator
     */
    private $translator;

    /**
     * @var string []
     */
    private $availableLocales;

    /**
     * @var string
     */
    private $defaultLocale;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $settings = $container->get('settings');

        $this->twig = $container->get(Twig::class);
        $this->translator = $container->get(Translator::class);
        $this->availableLocales = $settings['available_locales'];
        $this->defaultLocale = $settings['default_locale'];
    }

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, RequestHandler $handler): ResponseInterface
    {
        $locale = $this->getLocaleFromUri($request->getUri());

        $session = (array) $request->getAttribute('session');

        if ($locale === null) {
            // retrieve locale from session if not found in path, otherwise use default locale
            $locale = array_key_exists('locale', $session) ? $session['locale'] : $this->defaultLocale;
        }

        $session['locale'] = $locale;

        $this->translator->setLocale($locale);
        $this->translator->setFallback($locale);

        $twigApp = $this->twig->getEnvironment()->getGlobals()['app'] ?? [];
        $this->twig->getEnvironment()->addGlobal('app', array_replace($twigApp, ['locale' => $locale]));

        return $handler->handle($request->withAttribute('locale', $locale)->withAttribute('session', $session));
    }

    /**
     * Tries to retrieve the locale from the URI.
     *
     * The locale is assumed to be the first part in the path, e.g. "/en/home" yields "en" as result.
     *
     * @param UriInterface $uri
     * @return string|null the locale if found in the url and one of the allowed locales, othwerwise null
     */
    private function getLocaleFromUri(UriInterface $uri): ?string
    {
        $escapedLocales = array_map(function ($locale) {
            return preg_quote($locale);
        }, $this->availableLocales);

        $pattern = sprintf('#^/?(%s)/#', implode('|', $escapedLocales));

        if (preg_match($pattern, $uri->getPath(), $matches)) {
            return $matches[1];
        }

        return null;
    }
}
