<?php

namespace App\Common\ImageOptimizer;

use Tinify;

class ImageOptimizer implements ImageOptimizerInterface
{
    public function withApiKey($key)
    {
        \Tinify\setKey($key);
        return $this;
    }

    public function optimize($settings, $source, $to)
    {
        $source = \Tinify\fromBuffer($source);
        $resized = $source->resize($settings);
        return $resized->store(array(
            "service" => "s3",
            "aws_access_key_id" => env('AWS_ACCESS_KEY_ID'),
            "aws_secret_access_key" => env('AWS_SECRET_ACCESS_KEY'),
            "region" => env('AWS_DEFAULT_REGION'),
            "headers" => array("Cache-Control" => "max-age=31536000, public"),
            "path" => env('AWS_BUCKET') .'/'.$to //"example-bucket/my-images/optimized.jpg"
        ));
    }
}
