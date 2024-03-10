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

    // https://developer.vimeo.com/api/reference/folders#add_video_to_project.
    public function addVideoToFolder(string $folderURI, string $videoURI)
    {
        return $this->request($folderURI.$videoURI, [], 'PUT');
    }

    // https://developer.vimeo.com/api/reference/folders#remove_video_from_project.
    public function deleteVideoFromFolder(string $folderURI, string $videoURI)
    {
        return $this->request($folderURI.$videoURI, [], 'DELETE');
    }

    // https://developer.vimeo.com/api/reference/folders#delete_project.
    public function deleteFolder(string $vimeoId)
    {
        return $this->request('/me/projects/'.$vimeoId, [], 'DELETE');
    }

    // https://developer.vimeo.com/api/reference/videos#delete_video.
    public function deleteVideo(string $vimeoURI)
    {
        return $this->request($vimeoURI, [], 'DELETE');
    }

    // https://developer.vimeo.com/api/reference/videos#upload_video.
    public function uploadVideo(string $path, array $metadata = [])
    {
        return $this->upload($path, $metadata);
    }

    // https://developer.vimeo.com/api/reference/videos#edit_video.
    public function updateVideoDetails(string $videoUri, array $data)
    {
        return $this->request($videoUri, $data, 'PATCH');
    }

    // https://developer.vimeo.com/api/reference/folders#edit_project.
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
