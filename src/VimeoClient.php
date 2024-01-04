<?php

namespace Brunocfalcao\VimeoClient;

use Vimeo\Upload\TusClientFactory;
use Vimeo\Vimeo;

class VimeoClient extends Vimeo
{
    private $user_id;

    public function __construct(string $client_id, string $client_secret, ?string $access_token, ?TusClientFactory $tus_client_factory, string $user_id)
    {
        $this->user_id = $user_id;

        parent::__construct($client_id, $client_secret, $access_token, $tus_client_factory);
    }

    public function renameFolder(string $name, string $uri)
    {
        $url = "/users/{$this->user_id}/folders/{$uri}";

        return $this->request(
            $url,
            [
                'name' => $name,
                'parent_folder_uri' => $parentUri,
            ],
            'PATCH'
        );
    }

    public function createFolder(string $name, ?string $parentUri = null)
    {
        $url = "/users/{$this->user_id}/folders";

        return $this->request(
            $url,
            [
                'name' => $name,
                'parent_folder_uri' => $parentUri,
            ],
            'POST'
        );
    }
}
