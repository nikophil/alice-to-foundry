<?php

declare(strict_types=1);

namespace App\Foundry;

use Zenstruck\Foundry\Story as FoundryStory;

final class Story extends FoundryStory
{
    public function build(): void
    {
        BookFactory::createOne(['title' => 'Foundation', 'reference' => 'create one']);
    }
}
