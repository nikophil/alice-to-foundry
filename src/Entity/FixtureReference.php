<?php

declare(strict_types=1);

namespace App\Entity;

enum FixtureReference: string
{
    case CREATE_ONE = 'create one';
    case CREATE_MANY = 'create many';
    case USING_FAKER = 'using faker';
    case WITH_MANY_TO_ONE = 'with many to one';
    case WITH_ONE_TO_MANY = 'with one to many';
    case WITH_ONE_TO_MANY_RANDOM = 'with one to many random';
    case WITH_GAP = 'with gap in fixture index';
}
