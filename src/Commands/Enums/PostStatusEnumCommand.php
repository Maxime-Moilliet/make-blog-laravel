<?php

declare(strict_types=1);

namespace MakeBlogLaravel\Commands\Enums;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PostStatusEnumCommand extends GeneratorCommand
{
    protected $name = 'make:enum-post-status';

    protected $type = 'Enum';

    protected function getStub(): string
    {
        return __DIR__.'/../../../stubs/Enums/PostStatusEnum.php.stub';
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return "{$rootNamespace}\\Enums";
    }

    protected function getPath($name = 'PostStatusEnum'): string
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return $this->laravel['path'].'/'.str_replace('\\', '/', $name).'.php';
    }

    protected function getNameInput(): string
    {
        return 'PostStatusEnum';
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
