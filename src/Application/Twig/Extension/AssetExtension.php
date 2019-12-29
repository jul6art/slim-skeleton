<?php

namespace App\Application\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class AssetExtension
 * @package App\Application\Twig\Extension
 */
class AssetExtension extends AbstractExtension {
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
