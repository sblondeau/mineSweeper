<?php


namespace App;


class MineSweeper
{
    /**
     * @var array
     */
    private $map;
    private $discoveredCoordinates;

    public function __construct(array $map, $discoveredCoordinates = [])
    {
        $this->map = $map;
        $this->discoveredCoordinates = $discoveredCoordinates;
    }

    public function isWin()
    {
        $nbDiscoveredBomb = 0;
        for ($i = 0; $i < count($this->getMap()); $i++) {
            for ($j = 0; $j < count($this->getMap()[$i]); $j++) {
                if (isset($this->discoveredCoordinates[$j][$i])) {
                    $nbDiscoveredBomb++;
                }
            }
        }

        return !($nbDiscoveredBomb - $this->getCaseWithoutBomb());
    }

    /**
     * @return array
     */
    public function getMap(): array
    {
        return $this->map;
    }

    /**
     * @param array $map
     * @return MineSweeper
     */
    public function setMap(array $map): MineSweeper
    {
        $this->map = $map;

        return $this;
    }

    private function getCaseWithoutBomb(): int
    {
        $nbCases = 0;
        for ($i = 0; $i < count($this->getMap()); $i++) {
            for ($j = 0; $j < count($this->getMap()[$i]); $j++) {
                if (isset($this->map[$j][$i]) && $this->map[$j][$i] === 0)
                    $nbCases++;
            }
        }

        return $nbCases;
    }

    public function showAllBombs() :array
    {
        for ($i = 0; $i < count($this->getMap()); $i++) {
            for ($j = 0; $j < count($this->getMap()[0]); $j++) {
                if($this->map[$j][$i]) {
                    $this->discoveredCoordinates[$i][$j] = '*';
                } else {
                    $this->discoveredCoordinates[$i][$j] = $this->discoveredCoordinates[$i][$j] ?? '';
                }
            }
        }
        return $this->discoveredCoordinates;

    }
    public function search(int $x, int $y): array
    {
        if (!isset($this->map[$y][$x])) {
            throw new \OutOfRangeException('Not in the map !');
        }

        if (isset($this->map[$y][$x]) && $this->map[$y][$x]) {
            throw new \LogicException('Boom !');
        }

        $nbBombs = 0;

        for ($i = -1; $i <= 1; $i++) {
            for ($j = -1; $j <= 1; $j++) {
                if (isset($this->map[$y + $j][$x + $i])) {
                    $nbBombs += $this->map[$y + $j][$x + $i] ?? 0;
                }
            }
        }

        $this->discoveredCoordinates[$x][$y] = $nbBombs;

        if ($nbBombs === 0) {
            for ($i = -1; $i <= 1; $i++) {
                for ($j = -1; $j <= 1; $j++) {
                    if (isset($this->map[$y + $j][$x + $i]) && $this->map[$y + $j][$x + $i] === 0 && (!isset($this->discoveredCoordinates[$x+$i][$y+$j]))) {
                        $this->search($x + $i,$y + $j);
                    }
                }
            }
        }

        return $this->discoveredCoordinates;
    }

}