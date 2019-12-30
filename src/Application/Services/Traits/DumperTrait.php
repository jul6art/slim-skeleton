<?php

namespace App\Application\Services\Traits;

use App\Application\Services\Dumper;

/**
 * Trait DumperTrait
 * @package App\Application\Services\Traits
 */
trait DumperTrait
{
    /**
     * @param $data
     */
    protected function dump($data): void
    {
        (new Dumper())->dump($data);
    }

    /**
     * @param $data
     */
    protected function dd($data): void
    {
        (new Dumper())->dump($data);

        die;
    }
}
