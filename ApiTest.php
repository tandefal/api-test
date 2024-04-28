<?php


use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
    private string $baseUrl = 'http://localhost:8000';

    public function testAddUserToGroup(): void
    {
        $client = new Client(['base_uri' => $this->baseUrl]);

        $response = $client->post('/user/group/add', [
            'body' => json_encode([
                'userId' => 1,
                'groupId' => 1
            ], JSON_THROW_ON_ERROR)
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertEquals('User added to group', $data['message']);
    }

    public function testRemoveUserFromGroup(): void
    {
        $client = new Client(['base_uri' => $this->baseUrl]);

        $response = $client->delete('/user/group/remove', [
            'body' => json_encode([
                'userId' => 1,
                'groupId' => 1
            ], JSON_THROW_ON_ERROR)
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertEquals('User removed from group', $data['message']);
    }

    public function testGetGroupUsers(): void
    {
        $client = new Client(['base_uri' => $this->baseUrl]);

        $response = $client->get('/user/group/list');

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertIsArray($data);
    }

    public function testGetUserPermissions(): void
    {
        $client = new Client(['base_uri' => $this->baseUrl]);

        $response = $client->post('/user/permissions', [
            'body' => json_encode([
                'userId' => 1,
            ], JSON_THROW_ON_ERROR)
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertIsArray($data);
    }

    public function testBlockPermission(): void
    {
        $client = new Client(['base_uri' => $this->baseUrl]);

        $response = $client->post('/user/block/permissions', [
            'body' => json_encode([
                'userId' => 1,
                'permissionName'=> 'send_messages'
            ], JSON_THROW_ON_ERROR)
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertEquals('Permission blocked', $data['message']);
    }

    public function testUnblockPermission(): void
    {
        $client = new Client(['base_uri' => $this->baseUrl]);

        $response = $client->post('/user/unblock/permissions', [
            'body' => json_encode([
                'userId' => 1,
                'permissionName'=> 'send_messages'
            ], JSON_THROW_ON_ERROR)
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertEquals('Permission unblocked', $data['message']);
    }
}