<?php

namespace App\Console\Commands\Traits;

trait PrependsTimestamp
{
    public function line($string, $style = null, $verbosity = null)
    {
        $timestamped = date('[Y-m-d H:i:s] ') . strtoupper($style) . ': ' . $string;

        $styled = $style ? "<$style>$timestamped</$style>" : $timestamped;

        $this->output->writeln($styled, $this->parseVerbosity($verbosity));
    }
}
