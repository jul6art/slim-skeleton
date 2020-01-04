<?php

namespace App\Application\Twig\Extension;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;
use Slim\Csrf\Guard;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class CsrfExtension
 * @package App\Application\Twig\Extension
 */
class CsrfExtension extends AbstractExtension
{
    /**
     * @var Guard
     */
    private $csrfGenerator;

    /**
     * @var Request
     */
    private $request;

    /**
     * CsrfExtension constructor.
     * @param ContainerInterface $container
     * @param Request $request
     */
    public function __construct(ContainerInterface $container, Request $request)
    {
        $this->csrfGenerator = $container->get('csrf');
        $this->request = $request;
    }

    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('csrf_token', [$this, 'getCsrfToken'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @return string
     */
    public function getCsrfToken(): string
    {
        $nameKey = $this->csrfGenerator->getTokenNameKey();
        $valueKey = $this->csrfGenerator->getTokenValueKey();
        $name = $this->request->getAttribute($nameKey);
        $value = $this->request->getAttribute($valueKey);

        return '<input type="hidden" name="' . $nameKey . '" value="' . $name . '">
       <input type="hidden" name="' . $valueKey . '" value="' . $value . '">';
    }
}
