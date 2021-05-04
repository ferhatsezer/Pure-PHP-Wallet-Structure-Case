<?php

namespace Core\Wallet;

use Model\User;
use Interface\WalletInterface;
use Model\UserWallet;
use Service\WalletCurl;

class Wallet implements WalletInterface
{

    private string $endPoint = "https://apigateway.localhost/wallet/";
    public User $user;
    protected int $walletId;

    /**
     * BankWallet constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return int
     */
    public function getWalletId(): int
    {
        return $this->walletId;
    }

    /**
     * @param float $amount
     * @param string $note
     * @return bool
     */
    public function deposit(float $amount, string $note): bool
    {
        $result = UserWallet::update(
            [
                'amount' => 'operator:amount + ' . $amount,
            ],
            [
                'user_id' => $this->user->id,
                'wallet_id' => $this->getWalletId()
            ]
        );
        if ($result) {
            $endPoint = $this->endPoint . "deposit?user_id=" . $this->user->id;
            //HTTP Request
            if (WalletCurl::Request($endPoint)) {
                UserWallet::update(
                    [
                        'amount' => 'operator:amount - ' . $amount,
                    ],
                    [
                        'user_id' => $this->user->id,
                        'wallet_id' => $this->getWalletId()
                    ]
                );
            } else {
                return true;
            }
        }
        return false;
    }

    /**
     * @param float $amount
     * @param string $note
     * @return bool
     */
    public function withdraw(float $amount, string $note): bool
    {
        $result = UserWallet::update(
            [
                'amount' => 'operator:amount - ' . $amount,
            ],
            [
                'user_id' => $this->user->id,
                'wallet_id' => $this->getWalletId()
            ]
        );
        if ($result) {
            $endPoint = $this->endPoint . "withdraw?user_id=" . $this->user->id;
            //HTTP Request
            if (WalletCurl::Request($endPoint)) {
                UserWallet::update(
                    [
                        'amount' => 'operator:amount + ' . $amount,
                    ],
                    [
                        'user_id' => $this->user->id,
                        'wallet_id' => $this->getWalletId()
                    ]
                );
            } else {
                return true;
            }
        }
        return false;
    }
}