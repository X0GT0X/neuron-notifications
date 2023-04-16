<?php

declare(strict_types=1);

namespace App;

use App\Infrastructure\Configuration\DependencyInjection\CommandHandlerDecoratorPass;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function boot(): void
    {
        parent::boot();
        \date_default_timezone_set($this->getContainer()->getParameter('timezone')); /** @phpstan-ignore-line */
    }

    protected function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new CommandHandlerDecoratorPass());
    }
}
