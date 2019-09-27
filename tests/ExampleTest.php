<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{


    public function getTestData(): array{
        return [
                'email' => 'daniel@he4rt.com',
                'solvedArray' => [3,1,2]
        ];
    }

    public function testExample()
    {
        $expected = $this->getTestData();
        $sended = new \App\Entities\SortCollection($expected['email']);


        $this->assertEquals(
            $expected['solvedArray'], $sended->getResult()
        );
    }
}
