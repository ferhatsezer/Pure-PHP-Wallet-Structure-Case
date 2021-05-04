<?php

use Interface\WalletServiceInterface;
use Interface\WalletInterface;
use Core\Controller;
use Model\Log;

class WalletService extends Controller implements WalletServiceInterface
{

    private WalletInterface $wallet;
    public function __construct(WalletInterface $wallet)
    {
        $this->wallet = $wallet;
    }

    public function deposit(float $amount, string $note): bool
    {
        $result = $this->wallet->deposit($amount, $note);

        if ($result) {

            $logText = 'Deposit ' . date('d-m-Y H:i:s') . ' user_id = ' . $this->wallet->user->id . ' - user_name = '. $this->wallet->user->name . ' - note = ' . $note . ' - amount degeri ' . $amount . '  arttirilmistir.';
            return Log::create([
                'user_id' => (int)$this->wallet->user->id,
                'wallet_id' => (int)$this->wallet->getWalletId(),
                'log' => $logText
            ]);

        } else {
            return false;
        }
    }

    public function withdraw(float $amount, string $note): bool
    {
        $result = $this->wallet->withdraw($amount, $note);

        if ($result) {

            $logText = 'Withdraw ' . date('d-m-Y H:i:s') . ' user_id = ' . $this->wallet->user->id . ' - user_name = '. $this->wallet->user->name . ' - note = ' . $note . ' - amount degeri ' . $amount . '  azaltilmistir.';
            return Log::create([
                'user_id' => (int)$this->wallet->user->id,
                'wallet_id' => (int)$this->wallet->getWalletId(),
                'log' => $logText
            ]);

        } else {
            return false;
        }
    }
}