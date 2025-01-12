<?php

declare(strict_types=1);

namespace App\Entity;

enum FixtureReference: string
{
    case CREATE_ONE = 'create one';
    case CREATE_MANY = 'create many';
    case USING_FAKER = 'using faker';
    case WITH_MANY_TO_ONE = 'with many to one';
}
