<?php

namespace App\Application\Services;

use App\Application\Services\Constants\DumperColor;

/**
 * Class Dumper
 * @package App\Application\Services
 */
class Dumper
{
    /**
     * @param $data
     */
    public function dump($data): void
    {
        $openTag = '<div style="background: ' . DumperColor::DUMPER_COLOR_BACKGROUND . '; padding: 10px 20px;">';
        ini_set("highlight.default", DumperColor::DUMPER_COLOR_DEFAULT . ";  font-weight: bolder");
        ini_set("highlight.keyword", DumperColor::DUMPER_COLOR_KEYWORD . ";  font-weight: bolder");
        ini_set("highlight.string", DumperColor::DUMPER_COLOR_STRING . "; font-weight: lighter; ");
        ini_set("highlight.comment", DumperColor::DUMPER_COLOR_COMMENT . "; font-weight: lighter; ");
        ini_set("highlight.html", DumperColor::DUMPER_COLOR_HTML . "; font-weight: lighter; ");

        ob_start();
        highlight_string("<?php\n" . var_export($data, true) . "?>");
        $output = ob_get_clean();

        $output = str_replace( "&lt;?php", '', $output );
        $output = str_replace( "?&gt;", '', $output );
        $closeTag = '</div>';

        echo "$openTag$output$closeTag";
    }
}
