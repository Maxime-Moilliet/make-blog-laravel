<?php

declare(strict_types=1);

namespace MakeBlogLaravel\Commands\Routes;

use Illuminate\Support\Facades\File;

class BlogRouteInWebRouteCommand
{
    public function handle(): void
    {
        $appRoutesPath = base_path('routes/web.php');
        $adminRoutesContent = "\nrequire __DIR__ . '/blog.php';\n";

        File::append($appRoutesPath, $adminRoutesContent);
    }
}
