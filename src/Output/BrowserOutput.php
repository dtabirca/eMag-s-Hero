<?php

declare(strict_types=1);

namespace EmagHero\Output;

/**
 * barely a rough example showing it outputs in the browser
 */
class BrowserOutput implements Output
{
    public function __construct()
    {
        echo '<html><body>';
    }

    public function display(array $data, string $style = 'table'): void
    {
        switch ($style) {
            case 'table':
            default:
                $rows = array();
                foreach ($data as $row) {
                    $cells = array();
                    foreach ($row as $cell) {
                        $cells[] = "<td>" . nl2br($cell) . "</td>";
                    }
                    $rows[] = "<tr>" . implode('', $cells) . "</tr>";
                }
                echo  "<table border='1'>" . implode('', $rows) . "</table>";
        }
    }

    public function __destruct()
    {
        echo '</body></html>';
    }
}
