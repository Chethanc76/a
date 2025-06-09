// SPDX-License-Identifier: MIT
pragma solidity ^0.8.20;

contract SimpleBlockchain {
    struct Block {
        uint index;
        uint timestamp;
        string data;
        string previousHash;
        string hash;
    }

    Block[] public chain;

    constructor() {
       
        createGenesisBlock();
    }

    function createGenesisBlock() private {
        chain.push(Block({
            index: 0,
            timestamp: block.timestamp,
            data: "Genesis Block",
            previousHash: "0",
            hash: calculateHash(0, block.timestamp, "Genesis Block", "0")
        }));
    }

    function addBlock(string memory data, string memory previousHash) public {
        uint index = chain.length;
        string memory newHash = calculateHash(index, block.timestamp, data, previousHash);
        chain.push(Block({
            index: index,
            timestamp: block.timestamp,
            data: data,
            previousHash: previousHash,
            hash: newHash
        }));
    }

    function getBlock(uint index) public view returns (Block memory) {
        require(index < chain.length, "Invalid index");
        return chain[index];
    }

    function getLatestBlock() public view returns (Block memory) {
        return chain[chain.length - 1];
    }

    function calculateHash(
        uint index,
        uint timestamp,
        string memory data,
        string memory previousHash
    ) private pure returns (string memory) {
        return string(abi.encodePacked(
            keccak256(abi.encodePacked(index, timestamp, data, previousHash))
        ));
    }

    function getChainLength() public view returns (uint) {
        return chain.length;
    }
}
