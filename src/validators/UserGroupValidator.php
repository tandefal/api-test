<?php

namespace App\validators;

use Symfony\Component\Validator\Constraints as Assert;

class UserGroupValidator extends AbstractValidator
{
    public function addUserToGroup($data): array
    {
        $rules = new Assert\Collection([
            'userId' => new Assert\Positive(),
            'groupId' => new Assert\Positive()
        ]);
        return $this->validate($data, $rules);
    }

    public function removeUserFromGroup($data): array
    {
        $rules = new Assert\Collection([
            'userId' => new Assert\Positive(),
            'groupId' => new Assert\Positive()
        ]);
        return $this->validate($data, $rules);
    }

    public function userPermissions($data): array
    {
        $rules = new Assert\Collection([
            'userId' => new Assert\Positive(),
        ]);
        return $this->validate($data, $rules);
    }

    public function blockPermission($data): array
    {
        $rules = new Assert\Collection([
            'userId' => new Assert\Positive(),
            'permissionName' => [
                new Assert\Type('string'),
                new Assert\NotBlank(),
            ],
        ]);
        return $this->validate($data, $rules);
    }

    public function unblockPermission($data): array
    {
        $rules = new Assert\Collection([
            'userId' => new Assert\Positive(),
            'permissionName' => [
                new Assert\Type('string'),
                new Assert\NotBlank(),
            ],
        ]);
        return $this->validate($data, $rules);
    }
}