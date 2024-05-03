<?php

declare(strict_types=1);

namespace MakeBlogLaravel;

use MakeBlogLaravel\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MakeBlogLaravelServiceProvider extends PackageServiceProvider
{
    public function __construct($app)
    {
        parent::__construct($app);
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('make-blog-laravel')
            ->hasMigration('create_posts_table')
            ->hasMigration('create_seo_table')
            ->hasCommand(InstallCommand::class);
    }
}
