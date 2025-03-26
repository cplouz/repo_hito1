<?php

namespace App\Validator;

use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class MailNOvacioValidator extends ConstraintValidator
{

    public function __construct(private UserRepository $userRepository){

    }
  
    public function validate($user, Constraint $constraint): void


    {
        /* @var MailNOvacio $constraint */

        $email=$user->getEmail();

        if (null === $email || '' === $email) {
            return;
        }

        $emailrepe=$this->userRepository->// FALTA AQUI
        // TODO: implement the validation here
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $email)
            ->addViolation()
        ;
    }
}
