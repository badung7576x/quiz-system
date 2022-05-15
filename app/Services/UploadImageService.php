<?php 

namespace App\Services;

use GuzzleHttp\Client;

class UploadImageService
{
    public function upload($image): array
    {
        $imageBase64 = base64_encode($image);

        $uploadData = [
            'key' => config('filesystems.image-api.key'),
            'image' => $imageBase64
        ];
        
        $client = new Client(); 
        $response = $client->post(config('filesystems.image-api.url'), ['form_params' => $uploadData]);
        
        $data = json_decode($response->getBody()->getContents());

        return [
            'file_name' => $data->data->image->filename,
            'url' => $data->data->url
        ];
    }
}