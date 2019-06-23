<?php


namespace Tests;


use App\MineSweeper;
use PHPUnit\Framework\TestCase;

class MineSweeperTest extends TestCase
{
    private $map;

    public function setUp(): void
    {
        $this->map = [
            [0,1,0],
            [0,0,1],
            [1,0,0],
        ];
        $this->bigMap = [
            [1,0,0,0,1],
            [1,1,0,0,1],
            [1,0,0,0,1],
            [1,0,0,0,1],
        ];
    }

    public function testBoom()
    {
        $mineSweeper = new MineSweeper($this->map);
        $this->expectException(\LogicException::class);
        $mineSweeper->search(1, 0);
    }

    public function testNoBombMapCenter()
    {
        $mineSweeper = new MineSweeper($this->map);
        $this->assertEquals([1=>[1=>3]], $mineSweeper->search(1,1));
    }

    public function testNoBombMapBorder()
    {
        $mineSweeper = new MineSweeper($this->map);
        $this->assertEquals([2=>[0=>2]], $mineSweeper->search(2,0));
    }



}