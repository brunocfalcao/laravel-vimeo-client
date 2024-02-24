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

    public function getFolders()
    {
        return $this->request('/me/projects');
    }

    public function uploadVideo(string $path, array $metadata = [])
    {
        dd('inside video upload');
    }

    public function upsertFolder(string $name, ?string $uri = null, ?string $id = null)
    {
        /**
         * If there is no id, then it's an insert.
         * If there is an uri, then it will create a sub-folder.
         * If there is an id, then it's a folder name change.
         */
        $url = '/me/folders';
        $params = ['name' => $name];
        $method = 'POST';

        if ($id) {
            $url .= "/{$id}";
            $method = 'PATCH';
        }

        if ($uri) {
            // Then it's a sub-folder creation/replacement.
            $params['parent_folder_uri'] = $uri;
        }

        return $this->request(
            $url,
            $params,
            $method
        );
    }
}
