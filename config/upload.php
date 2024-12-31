<?php 
    require 'vendor/autoload.php';
    use Cloudinary\Cloudinary;

    function upload_file($file) {
        $cloudinary = new Cloudinary([
            'cloud' => [
                    'cloud_name' => 'dtdkm7cjl',
                    'api_key'    => '885518769471476',
                    'api_secret' => 'BFTJx8cgHgCnzJOTRD4rk2TdrKA'
            ],
            'url' => [
                'secure' => true
            ]
        ]);

        $uploadResult = $cloudinary->uploadApi()->upload($file, [
            'folder' => 'du_an_mau'
        ]);

        return $uploadResult['secure_url'];
    }
?>