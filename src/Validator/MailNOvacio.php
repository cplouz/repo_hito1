<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
final class MailNOvacio extends Constraint
{
    public string $message = 'El email "{{ value }}" no puede estar vacio.';

    // You can use #[HasNamedArguments] to make some constraint options required.
    // All configurable options must be passed to the constructor.
    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
