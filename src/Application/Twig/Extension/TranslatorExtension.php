<?php

namespace App\Application\Twig\Extension;

use Illuminate\Contracts\Translation\Translator;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class TranslatorExtension
 * @package App\Application\Twig\Extension
 */
class TranslatorExtension extends AbstractExtension {

    /**
     * @var Translator
     */
    private $translator;

    /**
     * TranslatorExtension constructor.
     * @param Translator $translator
     */
    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @return array|TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('trans', [$this, 'trans']),
        ];
    }

    /**
     * @param string $key
     * @param array $replace
     * @param null $locale
     * @return string
     */
    public function trans(string $key, array $replace = [], $locale = null) : string
    {
        return $this->translator->get($key, $replace, $locale);
    }

}
