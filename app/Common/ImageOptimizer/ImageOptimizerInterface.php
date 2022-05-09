<?php

namespace App\Common\ImageOptimizer;

interface ImageOptimizerInterface
{
    public function withApiKey($key);
    public function optimize($settings, $from, $to);
}
