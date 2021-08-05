<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function it_test_create_method()
    {
        $data=[];
        $createUser=$this->service->create($data);
        $this->assertInstanceOf();
        $this->assertDatabaseHas();
}

}

