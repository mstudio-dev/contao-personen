<?php

declare(strict_types=1);

namespace Mstudio\ContaoPersonenBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MstudioContaoPersonenBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
