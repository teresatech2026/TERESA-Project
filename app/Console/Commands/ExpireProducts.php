<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class ExpireProducts extends Command
{
    protected $signature = 'products:expire';

    protected $description = 'Mark active products as expired once they pass their farmer-given shelf life.';

    public function handle(): int
    {
        $expiredCount = 0;

        Product::where('status', 'active')
            ->whereNotNull('estimated_shelf_life_days')
            ->whereNotNull('harvest_date')
            ->chunkById(100, function ($products) use (&$expiredCount) {
                foreach ($products as $product) {
                    $expiryDate = $product->harvest_date
                        ->copy()
                        ->addDays($product->estimated_shelf_life_days);

                    if ($expiryDate->isPast()) {
                        $product->update(['status' => 'expired']);
                        $expiredCount++;
                    }
                }
            });

        $this->info("Marked {$expiredCount} product(s) as expired.");

        return self::SUCCESS;
    }
}