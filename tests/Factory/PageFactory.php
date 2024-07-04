<?php

namespace App\Tests\Factory;

use App\Entity\Page;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Page>
 */
final class PageFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Page::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'content' => self::faker()->text(),
            'title' => self::faker()->text(255),
            'slug' => self::faker()->text(255),
        ];
    }

    protected function initialize(): static
    {
        return $this;
    }
}
