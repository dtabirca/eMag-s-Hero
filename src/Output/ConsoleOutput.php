<?php

declare(strict_types=1);

namespace EmagHero\Output;

use Symfony\Component\Console\Output\ConsoleOutput as SymfonyConsole;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\FormatterHelper;

/**
 * outputs to cli
 */
class ConsoleOutput implements Output
{
    public SymfonyConsole $console;
    public function __construct()
    {
        $console = new SymfonyConsole();
        //$console->setFormatter(new OutputFormatter(true));
        $this->console = $console;
    }

    public function display(array $data, string $style = 'table'): void
    {
        switch ($style) {
            case 'table':
            default:
                $table = new Table($this->console);
                $header = array_shift($data);
                $table
                    ->setHeaders($header)
                    ->setRows($data);
                $table->render();
        }
    }
}
