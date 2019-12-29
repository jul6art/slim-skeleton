<?php

namespace App\Application\Twig\Extension;

use Psr\Container\ContainerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class AssetExtension
 * @package App\Application\Twig\Extension
 */
class AssetExtension extends AbstractExtension {
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * AssetExtension constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('asset', [$this, 'asset']),
        ];
    }

    /**
     * @param string $path
     * @return string
     */
    public function asset(string $path) : string
    {
        return sprintf(
            '%s%s%s%s',
            DIRECTORY_SEPARATOR,
            'assets',
            DIRECTORY_SEPARATOR,
            $path
        );
    }

}
