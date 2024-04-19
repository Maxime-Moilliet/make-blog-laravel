<?php

declare(strict_types=1);

namespace MakeBlogLaravel\Commands\Routes;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BlogRouteCommand extends GeneratorCommand
{
    protected $name = 'make:route-blog';

    protected $type = 'Route';

    protected function getStub(): string
    {
        return __DIR__.'/../../../stubs/Routes/blog.php.stub';
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return "{$rootNamespace}";
    }

    protected function getPath($name = 'blog'): string
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return $this->laravel['path'].'/../routes/'.str_replace('\\', '/', $name).'.php';
    }

    protected function getNameInput(): string
    {
        return 'blog';
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
