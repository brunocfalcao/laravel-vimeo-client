<?php

declare(strict_types=1);

namespace Brunocfalcao\VimeoClient;

use Illuminate\Support\Arr;
use InvalidArgumentException;
use VimeoClient as Vimeo;

class VimeoFactory
{
    /**
     * Make a new Vimeo client.
     *
     * @param  string[]  $config
     */
    public function make(array $config): VimeoClient
    {
        $config = $this->getConfig($config);

        return $this->getClient($config);
    }

    /**
     * Get the configuration data.
     *
     * @param  string[]  $config
     * @return string[]
     *
     * @throws InvalidArgumentException
     */
    protected function getConfig(array $config): array
    {
        $keys = ['client_id', 'client_secret', 'user_id'];

        foreach ($keys as $key) {
            if (! array_key_exists($key, $config)) {
                throw new InvalidArgumentException("Missing configuration key [$key].");
            }
        }

        return Arr::only($config, ['client_id', 'client_secret', 'access_token', 'user_id']);
    }

    protected function getClient(array $auth): VimeoClient
    {
        return new VimeoClient(
            $auth['client_id'],
            $auth['client_secret'],
            $auth['access_token'],
            null,
            $auth['user_id']
        );
    }
}
