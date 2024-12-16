<?php

namespace App\Console\Commands;

use App\Models\Membership;
use App\Notifications\MembershipExpiryReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;

class NotifyMembershipExpiry extends Command
{
    /**
     * @todo add logic to notify periodically
     * In days
     * @var int[]
     */
    const REMIND_INTERVAL = [
        -30,
        -14,
        -7,
        -3,
        -1,
    ];

    const START_REMIND_BEFORE = 14;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-membership-expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify all users about membership expiry';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // collect(static::REMIND_INTERVAL)->each(function ($hours) {
        $remindDate = now()->addDays(static::START_REMIND_BEFORE);

        // Membership::all()->each(function (Membership $membership) use ($remindDate) {
        Membership::where('id', 97)->get()->each(function (Membership $membership) use ($remindDate) {
            $lastReminderSent = $membership->extra?->lastReminderSent
                ? Date::parse($membership->extra?->lastReminderSent)
                : null;
            $isExpireOrWillExpire = $membership->period_end->isPast() || $membership->period_end->betweenIncluded(now(), $remindDate);
            $isReminderSent = $lastReminderSent && $lastReminderSent->isAfter($remindDate);
            $shouldRemind = $isExpireOrWillExpire && !$isReminderSent;

            if ($shouldRemind) {
                $membership->notify(new MembershipExpiryReminder);
                $membership->extra()->updateOrCreate([
                    'data->lastReminderSent' => now(),
                ]);
            }
        });
        // });
    }
}
