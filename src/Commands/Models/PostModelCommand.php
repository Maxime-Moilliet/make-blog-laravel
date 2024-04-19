<?php

declare(strict_types=1);

namespace MakeBlogLaravel\Commands\Models;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PostModelCommand extends GeneratorCommand
{
    protected $name = 'make:model-post';

    protected $type = 'Model';

    protected function getStub(): string
    {
        return __DIR__.'/../../../stubs/Models/Post.php.stub';
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return "{$rootNamespace}\\Models";
    }

    protected function getPath($name = 'Post'): string
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return $this->laravel['path'].'/'.str_replace('\\', '/', $name).'.php';
    }

    protected function getNameInput(): string
    {
        return 'Post';
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
