<?php

declare(strict_types=1);

namespace App\Entity;

enum FixtureReference: string
{
    case CREATE_ONE = 'create one';
    case USING_FAKER = 'using faker';
    case WITH_MANY_TO_ONE = 'with many to one';
    case ESCAPE_ALICE_SPECIAL_CHARS = 'escape alice special chars';

    // https://github.com/nelmio/alice/blob/main/doc/relations-handling.md#multiple-references
    case CREATE_MANY = 'create many';
    case WITH_ONE_TO_MANY = 'with one to many';
    case WITH_ONE_TO_MANY_RANDOM = 'with one to many random';

    // https://github.com/nelmio/alice/blob/main/doc/complete-reference.md#fixture-ranges
    case WITH_GAP = 'with gap in fixture index';

    // https://github.com/nelmio/alice/blob/main/doc/complete-reference.md#fixture-reference
    case WITH_ONE_TO_ONE_REFERENCE = 'with one to one reference';

    // https://github.com/nelmio/alice/blob/main/doc/complete-reference.md#calling-methods
    case WITH_METHOD_CALLS = 'with method calls';
    case WITH_METHOD_CALLS_WITH_FAKER_MODIFIED = 'method calls with faker modifiers';

    // https://github.com/nelmio/alice/blob/main/doc/complete-reference.md#using-a-factory--a-named-constructor
    case USING_NAMED_CONSTRUCTOR = 'using named constructor';
}
