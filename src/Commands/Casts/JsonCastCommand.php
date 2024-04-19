<?php

declare(strict_types=1);

namespace MakeBlogLaravel\Commands\Casts;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class JsonCastCommand extends GeneratorCommand
{
    protected $name = 'make:cast-json';

    protected $type = 'Cast';

    protected function getStub(): string
    {
        return __DIR__.'/../../../stubs/Casts/Json.php.stub';
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return "{$rootNamespace}\\Casts";
    }

    protected function getPath($name = 'Json'): string
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return $this->laravel['path'].'/'.str_replace('\\', '/', $name).'.php';
    }

    protected function getNameInput(): string
    {
        return 'Json';
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
