<?php

namespace Interface;

interface WalletServiceInterface
{
    /**
     * WalletServiceInterface constructor.
     * @param WalletInterface $wallet
     */
    public function __construct(WalletInterface $wallet);

    /**
     * @param float $amount
     * @param string $note
     * @return bool
     */
    public function deposit(float $amount, string $note) : bool;

    /**
     * @param float $amount
     * @param string $note
     * @return bool
     */
    public function withdraw(float $amount, string $note) : bool;
}