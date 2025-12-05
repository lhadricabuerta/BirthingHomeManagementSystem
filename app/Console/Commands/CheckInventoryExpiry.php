<?php

namespace App\Console\Commands;

use App\Models\InventoryItem;
use App\Models\User;
use App\Notifications\StockAlertNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckInventoryExpiry extends Command
{
    protected $signature = 'inventory:check-expiry';

    protected $description = 'Send daily notifications for inventory items that are expired or nearing expiry';

    public function handle(): int
    {
        $noticeWindow = config('inventory.expiry_notice_days', 30);
        $today = now()->startOfDay();

        $items = InventoryItem::whereNotNull('expiry_date')->get();
        if ($items->isEmpty()) {
            $this->info('No inventory items with expiry dates found.');
            return self::SUCCESS;
        }

        $admins = User::where('role', 'admin')->get();
        if ($admins->isEmpty()) {
            $this->warn('No admin users available to notify.');
            return self::SUCCESS;
        }

        foreach ($items as $item) {
            $expiryDate = Carbon::parse($item->expiry_date)->startOfDay();

            if ($today->greaterThanOrEqualTo($expiryDate)) {
                $this->notifyAdmins($admins, $item, 'Expired');
                continue;
            }

            $daysLeft = $today->diffInDays($expiryDate);
            if ($daysLeft <= $noticeWindow) {
                $this->notifyAdmins($admins, $item, 'Nearing Expiry', ['days_left' => $daysLeft]);
            }
        }

        $this->info('Inventory expiry check complete.');
        return self::SUCCESS;
    }

    protected function notifyAdmins($admins, InventoryItem $item, string $status, array $meta = []): void
    {
        foreach ($admins as $admin) {
            $admin->notify(new StockAlertNotification($item, $status, $meta));
        }
    }
}
