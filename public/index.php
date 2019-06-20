<?php

use App\MineSweeper;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require '../vendor/autoload.php';
session_start();

if (!empty($_GET['reset'])) {
    unset($_SESSION['map']);
    unset($_SESSION['discovered']);
}


$loader = new FilesystemLoader('../templates');
$twig = new Environment($loader);

$_SESSION['map'] = $_SESSION['map'] ?? (new \App\MineSweeperMapGenerator(8))->getMap();
$map = $_SESSION['map'];

$mineSweeper = new MineSweeper($map, $_SESSION['discovered'] ?? []);


$x = $_GET['x'] ?? null;
$y = $_GET['y'] ?? null;

if (isset($x) && isset($y)) {
    try {
        $_SESSION['discovered'][$x][$y] = $mineSweeper->search($x, $y);
    } catch (\OutOfRangeException $e) {
        echo $e->getMessage();
    } catch (\LogicException $e) {
        echo $e->getMessage();
        unset($_SESSION['discovered']);
        unset($_SESSION['map']);
    }
}

echo $twig->render('index.html.twig', [
    'map' => $mineSweeper->getMap(),
    'discovered' => $_SESSION['discovered'] ?? null,
    'win' => $mineSweeper->isWin(),
]);
