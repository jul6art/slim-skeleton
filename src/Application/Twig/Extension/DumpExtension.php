<?php

namespace App\Application\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class DumpExtension
 * @package App\Application\Twig\Extension
 */
class DumpExtension extends AbstractExtension {
    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('dump', [$this, 'dump']),
        ];
    }

    /**
     * @param $data
     */
    public function dump($data): void
    {
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
    }

}
