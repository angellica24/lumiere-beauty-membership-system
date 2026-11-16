<?php

namespace App\Services;

class PaymentChannelService
{
    /**
     * Demo-only payment channel details for local simulation.
     * Replace these placeholders with secure configuration before any real deployment.
     */
    public function labels(): array
    {
        return [
            'qris' => 'QRIS',
            'bank_transfer' => 'Bank Transfer',
            'e_wallet' => 'E-Wallet',
            'cash' => 'Cash di Klinik',
        ];
    }

    public function label(string $method): string
    {
        return $this->labels()[$method] ?? ucfirst(str_replace('_', ' ', $method));
    }

    public function bankAccounts(): array
    {
        return [
            [
                'bank' => 'BCA',
                'number' => 'DEMO-BCA-ACCOUNT',
                'name' => 'Lumiere Beauty (Demo)',
            ],
            [
                'bank' => 'Mandiri',
                'number' => 'DEMO-MANDIRI-ACCOUNT',
                'name' => 'Lumiere Beauty (Demo)',
            ],
        ];
    }

    public function eWalletAccounts(): array
    {
        return [
            [
                'provider' => 'DANA',
                'number' => 'DEMO-DANA-ACCOUNT',
                'name' => 'Lumiere Beauty (Demo)',
            ],
            [
                'provider' => 'OVO',
                'number' => 'DEMO-OVO-ACCOUNT',
                'name' => 'Lumiere Beauty (Demo)',
            ],
            [
                'provider' => 'GoPay',
                'number' => 'DEMO-GOPAY-ACCOUNT',
                'name' => 'Lumiere Beauty (Demo)',
            ],
        ];
    }

    public function qrisImage(): string
    {
        return 'assets/images/qris-lumiere.png';
    }

    public function methods(): array
    {
        return [
            'qris',
            'bank_transfer',
            'e_wallet',
            'cash',
        ];
    }
}
