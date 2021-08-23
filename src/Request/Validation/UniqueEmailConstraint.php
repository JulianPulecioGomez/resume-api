<?php
namespace App\Request\Validation;

use Symfony\Component\Validator\Constraint;

/**
* @Annotation
*/
class UniqueEmailConstraint extends Constraint
{
    public $message = 'The "{{ string }}" is already taken';

    public function getTargets()
    {
        return parent::CLASS_CONSTRAINT;
    }
}