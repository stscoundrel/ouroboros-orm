<?php
use PHPUnit\Framework\TestCase;

// Ouroboros deps.
use Silvanus\Ouroboros\Model;

// Ouroboros exceptions.
use Silvanus\Ouroboros\Exceptions\NoTableSetException;
use Silvanus\Ouroboros\Exceptions\Model\NoAllowedAttributesException;
use Silvanus\Ouroboros\Exceptions\Model\MissingIDException;

final class ModelExceptionsTest extends TestCase
{
    public function testCannotGetMissingTable(): void
    {
        $this->expectException(NoTableSetException::class);

        $model = new Model();
        $model::get_table();
    }

    public function testCannotGetMissingAllowedAttributes(): void
    {
        $this->expectException(NoAllowedAttributesException::class);

        $model = new Model();
        $model::is_allowed('test');
    }

    public function testCannotUpdateModelWithMissingId(): void
    {
        $this->expectException(MissingIDException::class);

        Model::update(array('name' => 'Viking Language 1', 'author' => 'Jesse L. Byock'));
    }
}

