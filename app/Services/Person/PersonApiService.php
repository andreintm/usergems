<?php

namespace App\Services\Person;

use App\Services\Person\Data\Person;
use App\Services\Person\Interfaces\PersonApiInterface;
use Illuminate\Support\Facades\Http;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\SimpleCache\InvalidArgumentException;

readonly class PersonApiService implements PersonApiInterface
{
    const KEY = 'person-data-';
    const TTL_30_DAYS = 60 * 60 * 24 * 30;

    public function __construct(
        private string $apiUrl,
        private string $apiKey
    ){
    }

    /**
     * @param string $email
     * @return Person
     * @throws ContainerExceptionInterface
     * @throws InvalidArgumentException
     * @throws NotFoundExceptionInterface
     */
    public function getPerson(string $email): Person
    {
        if ($data = cache()->get(self::KEY . $email)) {
            return Person::from($data);
        }

        $data = [
            'email' => $email,
            ...$this->getFreshPerson($email)
        ];

        cache()->set(
            self::KEY . $email,
            $data,
            self::TTL_30_DAYS
        );

        return Person::from($data);
    }

    public function getFreshPerson(string $email): array
    {
        return Http::withToken($this->apiKey)
            ->get(sprintf('%s/%s', $this->apiUrl, $email))
            ->json();
    }
}
