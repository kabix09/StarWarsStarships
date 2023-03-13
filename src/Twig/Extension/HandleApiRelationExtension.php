<?php

namespace App\Twig\Extension;

use App\Service\HttpClient;
use App\Twig\Runtime\HandleApiRelationRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class HandleApiRelationExtension extends AbstractExtension
{
    public const TWIG_EXTENSION_FUNCTION_NAME = 'fetchRelation';

    public function getFunctions(): array
    {
        return [
            new TwigFunction(self::TWIG_EXTENSION_FUNCTION_NAME, [HandleApiRelationRuntime::class, 'fetchApiRelation']),
        ];
    }
}
