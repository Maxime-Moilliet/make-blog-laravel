<?php

declare(strict_types=1);

namespace MakeBlogLaravel\Commands\Views;

use Illuminate\Support\Facades\File;

class BlogViewCommand
{
    public function handle(): void
    {
        $sourcePath = base_path('vendor/maxime-moilliet/make-blog-laravel/resources/views/blog');
        $destinationPath = base_path('resources/views/blog');

        if (! File::isDirectory($sourcePath)) {
            return;
        }

        if (! File::isDirectory($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        $files = File::files($sourcePath);
        foreach ($files as $file) {
            File::copy($file->getRealPath(), $destinationPath.'/'.$file->getFilename());
        }
    }
}
