<?php

interface StorageInterface
{
    public function getSecretKey();
}

class FileStorage implements StorageInterface
{
    public function getSecretKey()
    {
        // Implements getSecretKey() method.
    }
}

class DBStorage implements StorageInterface
{
    public function getSecretKey()
    {
        // Implements getSecretKey() method.
    }
}

class RedisStorage implements StorageInterface
{
    public function getSecretKey()
    {
        // Implements getSecretKey() method.
    }
}

class CloudStorage implements StorageInterface
{
    public function getSecretKey()
    {
        // Implements getSecretKey() method.
    }
}

class Concept {
    private $client;
    private StorageInterface $storage;

    public function __construct(StorageInterface $storage) {
        $this->client = new \GuzzleHttp\Client();
        $this->storage = $storage;
    }

    public function getUserData() {
        $params = [
            'auth' => ['user', 'pass'],
            'token' => $this->getSecretKey()
        ];

        $request = new \Request('GET', 'https://api.method', $params);
        $promise = $this->client->sendAsync($request)->then(function ($response) {
            $result = $response->getBody();
        });

        $promise->wait();
    }

    private function getSecretKey()
    {
        return $this->storage->getSecretKey();
    }
}