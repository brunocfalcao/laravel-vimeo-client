<?php

declare(strict_types=1);

namespace Brunocfalcao\VimeoClient;

use GrahamCampbell\Manager\AbstractManager;
use Illuminate\Contracts\Config\Repository;

class VimeoManager extends AbstractManager
{
    private $factory;

    public function __construct(Repository $config, VimeoFactory $factory)
    {
        parent::__construct($config);

        $this->factory = $factory;
    }

    public function getFactory(): VimeoFactory
    {
        return $this->factory;
    }

    protected function createConnection(array $config): VimeoClient
    {
        /** @var string[] $config */
        return $this->factory->make($config);
    }

    protected function getConfigName(): string
    {
        return 'vimeo';
    }
}
