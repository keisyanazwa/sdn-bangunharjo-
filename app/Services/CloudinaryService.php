<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CloudinaryService
{
    protected $cloudName;
    protected $apiKey;
    protected $apiSecret;
    protected $uploadUrl;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cloudName = env('CLOUDINARY_CLOUD_NAME');
        $this->apiKey = env('CLOUDINARY_API_KEY');
        $this->apiSecret = env('CLOUDINARY_API_SECRET');
        $this->uploadUrl = "https://api.cloudinary.com/v1_1/{$this->cloudName}/image/upload";
    }
    
    /**
     * Upload file to Cloudinary
     *
     * @param UploadedFile $file
     * @param string $folder
     * @return array
     */
    public function upload(UploadedFile $file, string $folder = 'sdnbangunharjo')
    {
        // Generate signature
        $timestamp = time();
        $signature = $this->generateSignature([
            'timestamp' => $timestamp,
            'folder' => $folder
        ]);
        
        // Prepare multipart form data
        $response = Http::attach(
            'file', // name of the file field
            file_get_contents($file->getRealPath()), // file contents
            $file->getClientOriginalName() // original filename
        )->post($this->uploadUrl, [
            'api_key' => $this->apiKey,
            'timestamp' => $timestamp,
            'signature' => $signature,
            'folder' => $folder
        ]);
        
        if ($response->successful()) {
            $result = $response->json();
            return [
                'public_id' => $result['public_id'],
                'image_url' => $result['secure_url']
            ];
        }
        
        throw new \Exception('Failed to upload image to Cloudinary: ' . $response->body());
    }
    
    /**
     * Delete file from Cloudinary
     *
     * @param string $publicId
     * @return bool
     */

    public function delete(string $publicId)
    {
        $timestamp = time();
        $signature = $this->generateSignature([
            'public_id' => $publicId,
            'timestamp' => $timestamp
        ]);
        
        $deleteUrl = "https://api.cloudinary.com/v1_1/{$this->cloudName}/image/destroy";
        
        $response = Http::post($deleteUrl, [
            'public_id' => $publicId,
            'api_key' => $this->apiKey,
            'timestamp' => $timestamp,
            'signature' => $signature
        ]);
        
        return $response->successful() && $response->json('result') === 'ok';
    }
    
    /**
     * Generate signature for Cloudinary API
     *
     * @param array $params
     * @return string
     */
    protected function generateSignature(array $params)
    {
        // Sort params by key
        ksort($params);
        
        // Build string to sign
        $stringToSign = '';
        foreach ($params as $key => $value) {
            $stringToSign .= $key . '=' . $value . '&';
        }
        $stringToSign = rtrim($stringToSign, '&');
        
        // Add API secret
        $stringToSign .= $this->apiSecret;
        
        // Generate SHA-1 hash
        return sha1($stringToSign);
    }
}