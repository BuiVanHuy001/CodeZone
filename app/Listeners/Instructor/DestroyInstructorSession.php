<?php

namespace App\Listeners\Instructor;


use App\Events\Instructor\InstructorSuspended;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class DestroyInstructorSession {
    public function __construct() {}

    public function handle(InstructorSuspended $event): void
    {
        $driver = Config::get('session.driver');

        if ($driver === 'database') {
            $table = Config::get('session.table', 'sessions');
            DB::table($table)->where('user_id', $event->instructor->getAuthIdentifier())->delete();
        }
    }
}
