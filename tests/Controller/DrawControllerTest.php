<?php

namespace App\Test\Controller;

use App\Entity\Draw;
use App\Repository\DrawRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DrawControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private DrawRepository $repository;
    private string $path = '/draw/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Draw::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Draw index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'draw[nbDraw]' => 'Testing',
            'draw[day]' => 'Testing',
            'draw[date]' => 'Testing',
            'draw[ball1]' => 'Testing',
            'draw[ball2]' => 'Testing',
            'draw[ball3]' => 'Testing',
            'draw[ball4]' => 'Testing',
            'draw[ball5]' => 'Testing',
            'draw[luckyBall]' => 'Testing',
            'draw[winComboAsc]' => 'Testing',
            'draw[nbWinRank1]' => 'Testing',
            'draw[amountRank1]' => 'Testing',
            'draw[nbWinRank2]' => 'Testing',
            'draw[amountRank2]' => 'Testing',
            'draw[nbWinRank3]' => 'Testing',
            'draw[amountRank3]' => 'Testing',
            'draw[nbWinRank4]' => 'Testing',
            'draw[amountRank4]' => 'Testing',
            'draw[nbWinRank5]' => 'Testing',
            'draw[amountRank5]' => 'Testing',
            'draw[nbWinRank6]' => 'Testing',
            'draw[amountRank6]' => 'Testing',
            'draw[nbWinRank7]' => 'Testing',
            'draw[amountRank7]' => 'Testing',
            'draw[nbWinRank8]' => 'Testing',
            'draw[amountRank8]' => 'Testing',
            'draw[nbWinRank9]' => 'Testing',
            'draw[amountRank9]' => 'Testing',
        ]);

        self::assertResponseRedirects('/draw/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Draw();
        $fixture->setNbDraw('My Title');
        $fixture->setDay('My Title');
        $fixture->setDate('My Title');
        $fixture->setBall1('My Title');
        $fixture->setBall2('My Title');
        $fixture->setBall3('My Title');
        $fixture->setBall4('My Title');
        $fixture->setBall5('My Title');
        $fixture->setLuckyBall('My Title');
        $fixture->setWinComboAsc('My Title');
        $fixture->setNbWinRank1('My Title');
        $fixture->setAmountRank1('My Title');
        $fixture->setNbWinRank2('My Title');
        $fixture->setAmountRank2('My Title');
        $fixture->setNbWinRank3('My Title');
        $fixture->setAmountRank3('My Title');
        $fixture->setNbWinRank4('My Title');
        $fixture->setAmountRank4('My Title');
        $fixture->setNbWinRank5('My Title');
        $fixture->setAmountRank5('My Title');
        $fixture->setNbWinRank6('My Title');
        $fixture->setAmountRank6('My Title');
        $fixture->setNbWinRank7('My Title');
        $fixture->setAmountRank7('My Title');
        $fixture->setNbWinRank8('My Title');
        $fixture->setAmountRank8('My Title');
        $fixture->setNbWinRank9('My Title');
        $fixture->setAmountRank9('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Draw');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Draw();
        $fixture->setNbDraw('My Title');
        $fixture->setDay('My Title');
        $fixture->setDate('My Title');
        $fixture->setBall1('My Title');
        $fixture->setBall2('My Title');
        $fixture->setBall3('My Title');
        $fixture->setBall4('My Title');
        $fixture->setBall5('My Title');
        $fixture->setLuckyBall('My Title');
        $fixture->setWinComboAsc('My Title');
        $fixture->setNbWinRank1('My Title');
        $fixture->setAmountRank1('My Title');
        $fixture->setNbWinRank2('My Title');
        $fixture->setAmountRank2('My Title');
        $fixture->setNbWinRank3('My Title');
        $fixture->setAmountRank3('My Title');
        $fixture->setNbWinRank4('My Title');
        $fixture->setAmountRank4('My Title');
        $fixture->setNbWinRank5('My Title');
        $fixture->setAmountRank5('My Title');
        $fixture->setNbWinRank6('My Title');
        $fixture->setAmountRank6('My Title');
        $fixture->setNbWinRank7('My Title');
        $fixture->setAmountRank7('My Title');
        $fixture->setNbWinRank8('My Title');
        $fixture->setAmountRank8('My Title');
        $fixture->setNbWinRank9('My Title');
        $fixture->setAmountRank9('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'draw[nbDraw]' => 'Something New',
            'draw[day]' => 'Something New',
            'draw[date]' => 'Something New',
            'draw[ball1]' => 'Something New',
            'draw[ball2]' => 'Something New',
            'draw[ball3]' => 'Something New',
            'draw[ball4]' => 'Something New',
            'draw[ball5]' => 'Something New',
            'draw[luckyBall]' => 'Something New',
            'draw[winComboAsc]' => 'Something New',
            'draw[nbWinRank1]' => 'Something New',
            'draw[amountRank1]' => 'Something New',
            'draw[nbWinRank2]' => 'Something New',
            'draw[amountRank2]' => 'Something New',
            'draw[nbWinRank3]' => 'Something New',
            'draw[amountRank3]' => 'Something New',
            'draw[nbWinRank4]' => 'Something New',
            'draw[amountRank4]' => 'Something New',
            'draw[nbWinRank5]' => 'Something New',
            'draw[amountRank5]' => 'Something New',
            'draw[nbWinRank6]' => 'Something New',
            'draw[amountRank6]' => 'Something New',
            'draw[nbWinRank7]' => 'Something New',
            'draw[amountRank7]' => 'Something New',
            'draw[nbWinRank8]' => 'Something New',
            'draw[amountRank8]' => 'Something New',
            'draw[nbWinRank9]' => 'Something New',
            'draw[amountRank9]' => 'Something New',
        ]);

        self::assertResponseRedirects('/draw/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNbDraw());
        self::assertSame('Something New', $fixture[0]->getDay());
        self::assertSame('Something New', $fixture[0]->getDate());
        self::assertSame('Something New', $fixture[0]->getBall1());
        self::assertSame('Something New', $fixture[0]->getBall2());
        self::assertSame('Something New', $fixture[0]->getBall3());
        self::assertSame('Something New', $fixture[0]->getBall4());
        self::assertSame('Something New', $fixture[0]->getBall5());
        self::assertSame('Something New', $fixture[0]->getLuckyBall());
        self::assertSame('Something New', $fixture[0]->getWinComboAsc());
        self::assertSame('Something New', $fixture[0]->getNbWinRank1());
        self::assertSame('Something New', $fixture[0]->getAmountRank1());
        self::assertSame('Something New', $fixture[0]->getNbWinRank2());
        self::assertSame('Something New', $fixture[0]->getAmountRank2());
        self::assertSame('Something New', $fixture[0]->getNbWinRank3());
        self::assertSame('Something New', $fixture[0]->getAmountRank3());
        self::assertSame('Something New', $fixture[0]->getNbWinRank4());
        self::assertSame('Something New', $fixture[0]->getAmountRank4());
        self::assertSame('Something New', $fixture[0]->getNbWinRank5());
        self::assertSame('Something New', $fixture[0]->getAmountRank5());
        self::assertSame('Something New', $fixture[0]->getNbWinRank6());
        self::assertSame('Something New', $fixture[0]->getAmountRank6());
        self::assertSame('Something New', $fixture[0]->getNbWinRank7());
        self::assertSame('Something New', $fixture[0]->getAmountRank7());
        self::assertSame('Something New', $fixture[0]->getNbWinRank8());
        self::assertSame('Something New', $fixture[0]->getAmountRank8());
        self::assertSame('Something New', $fixture[0]->getNbWinRank9());
        self::assertSame('Something New', $fixture[0]->getAmountRank9());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Draw();
        $fixture->setNbDraw('My Title');
        $fixture->setDay('My Title');
        $fixture->setDate('My Title');
        $fixture->setBall1('My Title');
        $fixture->setBall2('My Title');
        $fixture->setBall3('My Title');
        $fixture->setBall4('My Title');
        $fixture->setBall5('My Title');
        $fixture->setLuckyBall('My Title');
        $fixture->setWinComboAsc('My Title');
        $fixture->setNbWinRank1('My Title');
        $fixture->setAmountRank1('My Title');
        $fixture->setNbWinRank2('My Title');
        $fixture->setAmountRank2('My Title');
        $fixture->setNbWinRank3('My Title');
        $fixture->setAmountRank3('My Title');
        $fixture->setNbWinRank4('My Title');
        $fixture->setAmountRank4('My Title');
        $fixture->setNbWinRank5('My Title');
        $fixture->setAmountRank5('My Title');
        $fixture->setNbWinRank6('My Title');
        $fixture->setAmountRank6('My Title');
        $fixture->setNbWinRank7('My Title');
        $fixture->setAmountRank7('My Title');
        $fixture->setNbWinRank8('My Title');
        $fixture->setAmountRank8('My Title');
        $fixture->setNbWinRank9('My Title');
        $fixture->setAmountRank9('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/draw/');
    }
}
