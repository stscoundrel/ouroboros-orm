<?php

namespace Silvanus\Ouroboros\Tests;

use PHPUnit\Framework\TestCase;

// Ouroboros deps.
use Silvanus\Ouroboros\Repository;

// Fixtures.
use Silvanus\Ouroboros\Tests\Fixtures\FakeModel;

final class RepositoryTest extends TestCase
{

    public function testRepositoryCanBeCreatedWithModel()
    {
        $repository = new Repository(new FakeModel());

        $this->assertInstanceOf(
            Repository::class,
            $repository
        );
    }

    public function testRepositoryMethodAllCallsModelAll()
    {
        $repository = new Repository(new FakeModel());
        $result = $repository->all();

        $this->assertEquals(
            count($result),
            3
        );

        $this->assertEquals(
            $result[0]->get('name'),
            'test1'
        );

        $this->assertEquals(
            $result[2]->get('name'),
            'test3'
        );
    }

    public function testRepositoryMethodGetCallsModelGet()
    {
        $repository = new Repository(new FakeModel());
        $result = $repository->get(666);

        $this->assertInstanceOf(
            FakeModel::class,
            $result
        );

        $this->assertEquals(
            'Fake from get',
            $result->get('name')
        );
    }

    public function testRepositoryMethodCreateCallsModelCreate()
    {
        $repository = new Repository(new FakeModel());
        $result = $repository->create(array('name' => 'Fake'));

        $this->assertInstanceOf(
            FakeModel::class,
            $result
        );

        $this->assertEquals(
            'Fake from create',
            $result->get('name')
        );
    }

    public function testRepositoryMethodUpdateCallsModelUpdate()
    {
        $fake = new FakeModel();
        $repository = new Repository($fake);
        $repository->update(array('id' => 1527, 'name' => 'Fake to update'));

        $this->assertContains(
            array('id' => 1527, 'name' => 'Fake to update'),
            FakeModel::$updates
        );
    }

    public function testRepositoryMethodDeleteCallsModelDelete()
    {
        $fake = new FakeModel();
        $repository = new Repository($fake);
        $repository->delete(1527);

        $this->assertContains(
            1527,
            FakeModel::$deletes
        );
    }
}
