<?php

namespace Database\Seeders;

use App\Models\Donation;
use Illuminate\Database\Seeder;

class DonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Donation::count() > 0) {
            return;
        }

        $donations = [
            [
                'trx_id'         => 'DG20261115120101',
                'donor_name'     => 'ড. মাহফুজুর রহমান',
                'donor_phone'    => '01712345678',
                'donor_email'    => 'mahfuz.rahman@gmail.com',
                'amount'         => 5000.00,
                'currency'       => 'BDT',
                'payment_method' => 'bKash (DGePay)',
                'gateway_trx_id' => 'BK98234710',
                'status'         => 'success',
                'is_manual'      => false,
                'paid_at'        => now()->subDays(2),
                'notes'          => 'শৈলকুপা শিক্ষা ফান্ডে সাধারণ অনুদান।',
            ],
            [
                'trx_id'         => 'MN20261114002',
                'donor_name'     => 'আলহাজ্ব মোস্তফা কামাল',
                'donor_phone'    => '01911223344',
                'donor_email'    => 'mustafa.kamal@yahoo.com',
                'amount'         => 10000.00,
                'currency'       => 'BDT',
                'payment_method' => 'নগদ (Cash)',
                'gateway_trx_id' => 'REC-2026-0045',
                'status'         => 'success',
                'is_manual'      => true,
                'paid_at'        => now()->subDay(),
                'notes'          => 'অফিসে সরাসরি এসে রসিদ মারফত প্রদানকৃত।',
            ],
            [
                'trx_id'         => 'DG20261115143003',
                'donor_name'     => 'তানভীর আহমেদ',
                'donor_phone'    => '01844556677',
                'donor_email'    => 'tanvir.ahmed@hotmail.com',
                'amount'         => 1000.00,
                'currency'       => 'BDT',
                'payment_method' => 'Nagad (DGePay)',
                'gateway_trx_id' => 'NG77665544',
                'status'         => 'success',
                'is_manual'      => false,
                'paid_at'        => now()->subHours(4),
                'notes'          => 'অনলাইন অনুদান',
            ],
            [
                'trx_id'         => 'DG20261115145504',
                'donor_name'     => 'নাজমুল হুদা',
                'donor_phone'    => '01655667788',
                'donor_email'    => null,
                'amount'         => 2000.00,
                'currency'       => 'BDT',
                'payment_method' => 'DGePay',
                'gateway_trx_id' => null,
                'status'         => 'pending',
                'is_manual'      => false,
                'paid_at'        => null,
                'notes'          => 'পেমেন্ট প্রক্রিয়াধীন রয়েছে।',
            ],
        ];

        foreach ($donations as $item) {
            Donation::create($item);
        }
    }
}

