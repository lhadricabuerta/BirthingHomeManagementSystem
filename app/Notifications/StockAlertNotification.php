<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class StockAlertNotification extends Notification
{
    use Queueable;

    protected $item;
    protected $status;
    protected $meta;

    public function __construct($item, $status, array $meta = [])
    {
        $this->item   = $item;
        $this->status = $status;
        $this->meta   = $meta;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $url = route('admin.inventory.medicines'); // default

        switch ($this->item->category_id) {
            case 2: // Medicine
                $url = route('admin.inventory.medicines');
                break;
            case 3: // Supply
                $url = route('admin.inventory.supplies');
                break;
            case 4: // Vaccine
                $url = route('admin.inventory.vaccines');
                break;
        }

        // 🔹 Icon depende sa status
        $icon = match ($this->status) {
            'Out of Stock'   => 'fas fa-exclamation-triangle text-danger',
            'Low Stock'      => 'fas fa-boxes text-warning',
            'Nearing Expiry' => 'fas fa-hourglass-half text-warning',
            'Expired'        => 'fas fa-calendar-times text-danger',
            default          => 'fas fa-info-circle text-muted',
        };

        // 🔹 Message depende sa status
        $expiryDate = $this->item->expiry_date
            ? Carbon::parse($this->item->expiry_date)->format('M d, Y')
            : 'N/A';

        $message = match ($this->status) {
            'Expired'        => "{$this->item->item_name} has expired! (Expiry: {$expiryDate})",
            'Nearing Expiry' => $this->formatNearingExpiryMessage($expiryDate),
            default          => "{$this->item->item_name} is {$this->status}! (Current stock: {$this->item->quantity})",
        };

        $batchSuffix = $this->formatBatchSuffix();
        if ($batchSuffix !== '') {
            $message = trim($message . ' ' . $batchSuffix);
        }
            
        return [
            'message' => $message,
            'icon'    => $icon,
            'url'     => $url,
        ];
    }

    protected function formatNearingExpiryMessage(string $expiryDate): string
    {
        $daysLeft = $this->meta['days_left'] ?? null;
        if (is_numeric($daysLeft)) {
            $daysLeft = (int) round($daysLeft);
        }

        if ($daysLeft === null) {
            return "{$this->item->item_name} is nearing expiry! (Expiry: {$expiryDate})";
        }

        if ($daysLeft <= 0) {
            return "{$this->item->item_name} expires today! (Expiry: {$expiryDate})";
        }

        if ($daysLeft === 1) {
            return "{$this->item->item_name} expires tomorrow! (Expiry: {$expiryDate})";
        }

        return "{$this->item->item_name} expires in {$daysLeft} days! (Expiry: {$expiryDate})";
    }

    protected function formatBatchSuffix(): string
    {
        return $this->item->batch_no
            ? "(Batch #: {$this->item->batch_no})"
            : '';
    }
}
