<?php

declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

/**
 * Enum to map https://swapi.dev/documentation routes
 *
 * @method static SwApiEnum STARSHIPS()
 * @method static SwApiEnum PEOPLE()
 * @method static SwApiEnum FILMS()
 * @method static SwApiEnum PLANETS()
 * @method static SwApiEnum SPECIES()
 * @method static SwApiEnum VEHICLES()
 */
final class SwApiEnum extends Enum
{
    public const STARSHIPS = 'starships';
    public const PEOPLE = 'people';
    public const FILMS = 'films';
    public const PLANETS = 'planets';
    public const SPECIES = 'species';
    public const VEHICLES = 'vehicles';

    public function __construct($value)
    {
        parent::__construct($value);
    }
}