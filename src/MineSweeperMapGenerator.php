<?php


namespace App;


class MineSweeperMapGenerator
{

    private $size;
    private $map;

    public function __construct(int $size = 5)
    {
        $this->size = $size;
        $this->generateMap();
    }

    public function generateMap(): void
    {
        for ($y = 0; $y < $this->getSize(); $y++) {
            for ($x = 0; $x < $this->getSize(); $x++) {
                $mine = 0;
                if (rand(0, 10) == 1) {
                    $mine = 1;
                }
                $map[$x][$y] = $mine;
            }
        }

        $this->setMap($map);
    }

    /**
     * @return mixed
     */
    public function getMap() :array
    {
        return $this->map;
    }

    /**
     * @param mixed $map
     * @return MineSweeperMapGenerator
     */
    public function setMap(array $map)
    {
        $this->map = $map;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     * @return MineSweeperMapGenerator
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

}