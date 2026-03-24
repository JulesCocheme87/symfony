<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

class MessageGenerator
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function getHappyMessage(): string
    {
        $messages = [
            'Bravo vous êtes le meilleur !',
            'Ceci est le meilleur service que j\'ai vu ',
            'Beau travail ! Continuez ! ',
        ];

        $index = array_rand($messages);
        $this->logger->info($messages[$index]);

        return $messages[$index];
    }
}
