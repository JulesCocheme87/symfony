<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class Antispam extends Constraint
{
    public $message = "Votre champ est trop court ou contient des caractères interdits";

    // On peut redéfinir le Validator si on veut
    // Ici, par convention, le Validator s'appellera AntispamValidator
}
