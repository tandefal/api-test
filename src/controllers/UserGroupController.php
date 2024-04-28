<?php

namespace App\controllers;

use App\services\UserGroupService;
use App\validators\UserGroupValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserGroupController extends AbstractController
{
    public function addUserToGroup(Request $request): JsonResponse
    {
        $data = $request->toArray();
        $validator = new UserGroupValidator();
        if ($err = $validator->addUserToGroup($data)) {
            return $this->json($err, 400);
        }

        try {
            $userGroupService = new UserGroupService();
            $userGroupService->addUserToGroup($data['userId']);
            return $this->json(['message' => 'User added to group']);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }

    }

    public function removeUserFromGroup(Request $request): JsonResponse
    {
        $data = $request->toArray();
        $validator = new UserGroupValidator();
        if ($err = $validator->removeUserFromGroup($data)) {
            return $this->json($err, 400);
        }

        try {

            $userGroupService = new UserGroupService();
            $userGroupService->removeUserFromGroup($data['userId']);
            return $this->json(['message' => 'User removed from group']);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }
    }

    public function listGroups(): JsonResponse
    {
        $userGroupService = new UserGroupService();
        $groups = $userGroupService->listGroups();
        return $this->json(['groups' => $groups]);
    }

    public function userPermissions(Request $request): JsonResponse
    {
        $data = $request->toArray();
        $validator = new UserGroupValidator();
        if ($err = $validator->userPermissions($data)) {
            return $this->json($err, 400);
        }

        try {
            $userGroupService = new UserGroupService();
            $result = $userGroupService->userPermissions($data['userId']);
            return $this->json($result);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }
    }

    public function blockPermission(Request $request): JsonResponse
    {
        $data = $request->toArray();
        $validator = new UserGroupValidator();
        if ($err = $validator->blockPermission($data)) {
            return $this->json($err, 400);
        }

        try {
            $userGroupService = new UserGroupService();
            $userGroupService->blockPermission($data['userId'], $data['permissionName']);
            return $this->json(['message' => 'Permission blocked']);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }

    }

    public function unblockPermission(Request $request): JsonResponse
    {
        $data = $request->toArray();
        $validator = new UserGroupValidator();
        if ($err = $validator->unblockPermission($data)) {
            return $this->json($err, 400);
        }

        try {
            $userGroupService = new UserGroupService();
            $userGroupService->unblockPermission($data['userId'], $data['permissionName']);
            return $this->json(['message' => 'Permission unblocked']);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }
    }
}