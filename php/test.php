<?php
require dirname(__FILE__) . '/app/Block.php';

$blockHandler = new BlockHandler();

$genesisBlock = $blockHandler->createGenesisBlock();

$blockList = [
    $genesisBlock
];

$previousBlock = $genesisBlock;
for ($i = 0; $i <= 100; $i++) {

    $newBlock = $blockHandler->dig($previousBlock);
    if (is_null($newBlock)) {
        continue;
    }

    $blockList[] = $newBlock;
    $previousBlock = $newBlock;
}

echo 'block info', PHP_EOL;
foreach ($blockList as $block) {
    echo "index：", $block->getIndex(), " hash: ", $block->getHash(), PHP_EOL;
}