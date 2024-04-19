<?php

declare(strict_types=1);

namespace MakeBlogLaravel\Commands\Controllers;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AdminBlogControllerCommand extends GeneratorCommand
{
    protected $name = 'make:controller-blog-admin';

    protected $type = 'Controller';

    protected function getStub(): string
    {
        return __DIR__.'/../../../stubs/Controllers/AdminBlogController.php.stub';
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return "{$rootNamespace}\\Http\\Controllers\\Admin";
    }

    protected function getPath($name = 'AdminBlogController'): string
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return $this->laravel['path'].'/'.str_replace('\\', '/', $name).'.php';
    }

    protected function getNameInput(): string
    {
        return 'AdminBlogController';
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        // Do nothing
    }

    protected function getArguments(): array
    {
        return [];
    }
}
