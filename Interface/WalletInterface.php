<?php

namespace Interface;

use Model\User;

interface WalletInterface
{
    /**
     * WalletInterface constructor.
     * @param User $user
     */
    public function __construct(User $user);

    /**
     * @return int
     */
    public function getWalletId() : int;

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