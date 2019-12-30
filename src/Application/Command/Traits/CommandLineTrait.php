<?php

namespace App\Application\Command\Traits;

use App\Application\Command\Constants\CommandLineBackgroundColor;
use App\Application\Command\Constants\CommandLineColor;

/**
 * Trait CommandLineTrait
 * @package App\Application\Command\Traits
 */
trait CommandLineTrait
{
    /**
     * @param string $text
     */
    protected function error(string $text): void
    {
        $this->write(
            $text,
            'error',
            CommandLineColor::COMMAND_LINE_COLOR_BLACK,
            CommandLineBackgroundColor::COMMAND_LINE_BACKGROUND_COLOR_RED
        );
    }

    /**
     * @param string $text
     */
    protected function info(string $text): void
    {
        $this->write(
            $text,
            'info',
            CommandLineColor::COMMAND_LINE_COLOR_GREEN,
            null
        );
    }

    /**
     * @param string $text
     */
    protected function success(string $text): void
    {
        $this->write(
            $text,
            'success',
            CommandLineColor::COMMAND_LINE_COLOR_BLACK,
            CommandLineBackgroundColor::COMMAND_LINE_BACKGROUND_COLOR_GREEN
        );
    }

    /**
     * @param string $text
     */
    protected function warning(string $text): void
    {
        $this->write(
            $text,
            'warning',
            CommandLineColor::COMMAND_LINE_COLOR_YELLOW,
            null
        );
    }

    /**
     * @param string $text
     * @param string $type
     * @param string|null $color
     * @param string|null $backgroundColor
     */
    protected function write(string $text, string $type = '', string $color = null, string $backgroundColor = null): void
    {
        $style = '';

        if (null !== $color) {
            $style = "fg=$color";
        }

        if (null !== $backgroundColor) {
            $style = \strlen($style) ? "$style;" : '';
            $style .= "bg=$backgroundColor";
        }

        $style = !\strlen($style) ? '' : "<$style>";

        $tag = \strlen($type) ? "{$type}! " : '';

        echo sprintf(
            '%s%s%s  %s%s%s</>%s',
            $style,
            \strlen($type) ? $this->newLine() : '',
            $this->newLine(),
            strtoupper($tag),
            $text,
            $this->newLine(),
            \strlen($type) ? $this->newLine() : ''
        );
    }

    /**
     * @return string
     */
    protected function newLine(): string
    {
        return PHP_EOL;
    }
}
