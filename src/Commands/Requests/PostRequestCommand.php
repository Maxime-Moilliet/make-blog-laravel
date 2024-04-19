<?php

namespace MakeBlogLaravel\Commands\Requests;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PostRequestCommand extends GeneratorCommand
{
    protected $name = 'make:model-request';

    protected $type = 'Request';

    protected function getStub(): string
    {
        return __DIR__.'/../../../stubs/Requests/PostRequest.php.stub';
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return "{$rootNamespace}\\Requests\\Blog";
    }

    protected function getPath($name = 'PostRequest'): string
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return $this->laravel['path'].'/'.str_replace('\\', '/', $name).'.php';
    }

    protected function getNameInput(): string
    {
        return 'PostRequest';
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
