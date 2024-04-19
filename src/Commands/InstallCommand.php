<?php

declare(strict_types=1);

namespace MakeBlogLaravel\Commands;

use Illuminate\Console\Command;
use MakeBlogLaravel\Commands\Casts\JsonCastCommand;
use MakeBlogLaravel\Commands\Controllers\AdminBlogControllerCommand;
use MakeBlogLaravel\Commands\Controllers\BlogControllerCommand;
use MakeBlogLaravel\Commands\Enums\PostStatusEnumCommand;
use MakeBlogLaravel\Commands\Models\PostModelCommand;
use MakeBlogLaravel\Commands\Requests\PostRequestCommand;
use MakeBlogLaravel\Commands\Routes\BlogRouteCommand;
use MakeBlogLaravel\Commands\Routes\BlogRouteInWebRouteCommand;
use MakeBlogLaravel\Commands\Views\AdminBlogViewCommand;
use MakeBlogLaravel\Commands\Views\BlogViewCommand;

class InstallCommand extends Command
{
    protected $signature = 'install:blog';

    protected $description = 'install blog package';

    public function handle(): void
    {
        $this->call(PostModelCommand::class);
        $this->call(PostStatusEnumCommand::class);
        $this->call(JsonCastCommand::class);
        $this->call(BlogRouteCommand::class);
        $this->call(BlogControllerCommand::class);
        $this->call(AdminBlogControllerCommand::class);
        $this->call(PostRequestCommand::class);

        (new BlogRouteInWebRouteCommand())->handle();
        (new BlogViewCommand())->handle();
        (new AdminBlogViewCommand())->handle();
    }
}
