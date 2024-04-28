<?php

namespace App\validators;

use Symfony\Component\Validator\Constraints as Assert;

class UserValidator extends AbstractValidator
{
        public function create(array $data): array
        {
            $rules = new Assert\Collection([
                'name' => new Assert\Required([
                    new Assert\Length(['min' => 3, 'max' => 50]),
                ])
            ]);
            return $this->validate($data, $rules);
        }

        public function remove(array $data): array
        {
            $rules = new Assert\Collection([
                'id' => new Assert\Positive()
            ]);
            return $this->validate($data, $rules);
        }
}