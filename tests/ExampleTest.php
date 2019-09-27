<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{


    public function getTestData(): array{
        return [
            [
                'email' => 'daniel@he4rt.com',
                'solvedArray' => [3,1,2]
            ],
            [
                'email' => 'gustavo@he4rt.com',
                'solvedArray' => [1,3,2]
            ]
        ];
    }

    public function testExample()
    {
        $expected = $this->getTestData();
        foreach($expected as $key => $test){
            $sended = new \App\Entities\SortCollection($test['email']);
            $this->assertEquals(
                $expected[$key]['solvedArray'], $sended->getResult()
            );
        }


    }
}
