<?php

namespace App\Application\Twig\Extension;

use App\Application\Services\Traits\DumperTrait;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class DumpExtension
 * @package App\Application\Twig\Extension
 */
class DumpExtension extends AbstractExtension {
    use DumperTrait;

    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('dump', [$this, 'debug']),
        ];
    }

    /**
     * @param $data
     */
    public function debug($data): void
    {
        $this->dump($data);
    }

}
