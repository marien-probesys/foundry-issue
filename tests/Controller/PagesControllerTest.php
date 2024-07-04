<?php

namespace App\Tests\Controller;

use App\Tests\Factory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Zenstruck\Foundry;

class PagesControllerTest extends WebTestCase
{
    use Foundry\Test\Factories;
    use Foundry\Test\ResetDatabase;

    public function testIndexListsPages(): void
    {
        $client = static::createClient();
        Factory\PageFactory::createOne([
            'title' => 'My page',
        ]);

        $client->request(Request::METHOD_GET, '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('li', 'My page');
    }

    public function testShowDisplaysThePage(): void
    {
        $client = static::createClient();
        $page = Factory\PageFactory::createOne([
            'title' => 'My page',
            'slug' => 'my-page',
        ]);

        $client->request(Request::METHOD_GET, "/pages/{$page->getSlug()}");

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'My page');
    }
}
