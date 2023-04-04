<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ValidatorService
 * @package BodoFood\Bundle\Validator
 */
class ValidatorService
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * ValidatorService constructor.
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Validates a value against a validator class by name.
     *
     * If no constraint is passed, the constraint
     * {@link \Symfony\Component\Validator\Constraints\Valid} is assumed.
     *
     * @param ValidationInterface $validation The validation object
     * @param mixed               $data       The value to validate
     * @param array|null          $groups     The validation groups to
     *                                             validate. If none is given,
     *                                             "Default" is assumed
     *
     * @return ConstraintViolationListInterface A list of constraint violations
     *                                          If the list is empty, validation
     *                                          succeeded
     */
    public function validateBy(ValidationInterface $validation, $data, array $groups = null)
    {
        $constraints = $validation->getConstraints();

        return $this->validator->validate($data, $constraints, $groups);
    }

    /**
     * Validates a value against a constraint or a list of constraints.
     *
     * If no constraint is passed, the constraint
     * {@link \Symfony\Component\Validator\Constraints\Valid} is assumed.
     *
     * @param mixed                   $value       The value to validate
     * @param Constraint|Constraint[] $constraints The constraint(s) to validate
     *                                             against
     * @param array|null              $groups      The validation groups to
     *                                             validate. If none is given,
     *                                             "Default" is assumed
     *
     * @return ConstraintViolationListInterface A list of constraint violations
     *                                          If the list is empty, validation
     *                                          succeeded
     */
    public function validate($value, $constraints = null, $groups = null)
    {
        return $this->validator->validate($value, $constraints, $groups);
    }
}
