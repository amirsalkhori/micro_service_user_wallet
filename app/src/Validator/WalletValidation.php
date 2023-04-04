<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class WalletValidation implements ValidationInterface
{
    /**
     * @return mixed
     */
    public function getConstraints()
    {
        return new Collection(array(
            'userId' => [
                new NotBlank(),
                new Type([
                    'type' => 'integer',
                ]),
            ],
        ));
    }
}
