<?php

class Block
{

    private $index;

    private $timestamp;

    private $data;

    private $previousHash;

    private $randomStr;

    private $hash;

    public function __construct($index, $timestamp, $data, $randomStr, $previousHash)
    {
        $this->index = $index;
        $this->timestamp = $timestamp;
        $this->data = $data;
        $this->randomStr = $randomStr;
        $this->previousHash = $previousHash;
        $this->hash = $this->hashBlock();
    }

    public function hashBlock()
    {
        return hash("sha256",
            $this->index . $this->timestamp . $this->data . $this->randomStr . $this->previousHash
        );
    }

    public function hashCheck()
    {
       return !is_numeric($this->hash{0});
    }

    public function verify()
    {
        return true;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function getIndex()
    {
        return $this->index;
    }
}

class BlockHandler
{
    /**
     * 创世区块
     * @return Block
     */
    public function createGenesisBlock()
    {
        return new Block(0, time(), "first block", 0, 0);
    }

    public function dig(Block $lastBlock)
    {
        $randomStr = $lastBlock->getHash() . Util::getRandomStr(32);
        $index = $lastBlock->getIndex() + 1;
        $block = new Block($index, time(), "block {$index}", $randomStr, $lastBlock->getHash());

        return $block->hashCheck() ? $block : null;
    }
}

class Util
{
    public static function getRandomStr($len = 32)
    {
        $str = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $key = "";
        for ($i = 0; $i < $len; $i++) {
            $key .= $str{mt_rand(0, $len)}; //随机数
        }
        return $key;
    }

}