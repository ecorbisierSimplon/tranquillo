<?php

namespace App\Test\Controller;

use App\Entity\TpaUsers;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TpaUsersControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/users/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(TpaUsers::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('TpaUser index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'tpa_user[email]' => 'Testing',
            'tpa_user[lastname]' => 'Testing',
            'tpa_user[firstname]' => 'Testing',
            'tpa_user[userPassword]' => 'Testing',
            'tpa_user[userCreateAt]' => 'Testing',
            'tpa_user[roles]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new TpaUsers();
        $fixture->setEmail('My Title');
        $fixture->setLastname('My Title');
        $fixture->setFirstname('My Title');
        $fixture->setUserPassword('My Title');
        $fixture->setUserCreateAt('My Title');
        $fixture->setRoles('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('TpaUser');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new TpaUsers();
        $fixture->setEmail('Value');
        $fixture->setLastname('Value');
        $fixture->setFirstname('Value');
        $fixture->setUserPassword('Value');
        $fixture->setUserCreateAt('Value');
        $fixture->setRoles('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'tpa_user[email]' => 'Something New',
            'tpa_user[lastname]' => 'Something New',
            'tpa_user[firstname]' => 'Something New',
            'tpa_user[userPassword]' => 'Something New',
            'tpa_user[userCreateAt]' => 'Something New',
            'tpa_user[roles]' => 'Something New',
        ]);

        self::assertResponseRedirects('/users/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getEmail());
        self::assertSame('Something New', $fixture[0]->getLastname());
        self::assertSame('Something New', $fixture[0]->getFirstname());
        self::assertSame('Something New', $fixture[0]->getUserPassword());
        self::assertSame('Something New', $fixture[0]->getUserCreateAt());
        self::assertSame('Something New', $fixture[0]->getRoles());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new TpaUsers();
        $fixture->setEmail('Value');
        $fixture->setLastname('Value');
        $fixture->setFirstname('Value');
        $fixture->setUserPassword('Value');
        $fixture->setUserCreateAt('Value');
        $fixture->setRoles('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/users/');
        self::assertSame(0, $this->repository->count([]));
    }
}
