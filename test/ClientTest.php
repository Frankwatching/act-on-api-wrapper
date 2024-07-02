<?php

require(dirname(__DIR__) . "/src/classes/Client.php");

use Dotenv\Dotenv;
use Frankwatching\ActOn\Client;
use PHPUnit\Framework\TestCase;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

final class ClientTest extends TestCase
{
        public function testClientConstructor()
        {
                $config = [
                        "CLIENT_ID" => $_ENV["ACT_ON_CLIENT_ID"],
                        "CLIENT_SECRET" => $_ENV["ACT_ON_CLIENT_SECRET"],
                        "USER" => $_ENV["ACT_ON_USER"],
                        "PASSWORD" => $_ENV["ACT_ON_PASSWORD"]
                ];
                $client = new Client(
                        $config["CLIENT_ID"],
                        $config["CLIENT_SECRET"],
                        $config["USER"],
                        $config["PASSWORD"]
                );
                $this->assertInstanceOf(Client::class, $client);

                $tokens = $client->fetchTokens();
                $this->assertIsArray($tokens);
        }
}
