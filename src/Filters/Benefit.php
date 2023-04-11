<?php

namespace Notabenedev\SiteAlbums\Filters;

use Intervention\Image\Facades\Image;
use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image as File;

class Benefit implements FilterInterface {

    public function applyFilter(File $image)
    {
        $image->orientate();
        $image ->widen(90);
        $image ->heighten(90);

        return $image->resizeCanvas(90, 90, 'center', false, config('site-albums.benefitBgColor'));
    }
}