<?php


namespace Sergeich5\PlayMarketParser\Entities;


class Proxy
{
    /* @var string $host */
    private $host;

    /* @var int $port */
    private $port;

    /* @var ?string $user */
    private $user;

    /* @var ?string $password */
    private $password;

    function __construct(string $host, int $port, ?string $user = null, ?string $password = null)
    {
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->password = $password;
    }

    function getHost(): string
    {
        return $this->host;
    }

    function getPort(): int
    {
        return $this->port;
    }

    function getUser(): ?string
    {
        return $this->user;
    }

    function getPassword(): ?string
    {
        return $this->password;
    }
}
