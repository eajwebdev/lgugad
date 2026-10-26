<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Appends the Day Care Workers flag (index 7 of User::MODULES) to every account's `access` CSV.
     * Administrators get access; other accounts start without it.
     *
     * @return void
     */
    public function up()
    {
        DB::table('users')->orderBy('id')->each(function ($user) {
            $flags = explode(',', (string) $user->access);
            if (count($flags) !== 7) {
                return;
            }

            $flags[] = $user->role === 'Administrator' ? '1' : '0';
            DB::table('users')->where('id', $user->id)->update(['access' => implode(',', $flags)]);
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        DB::table('users')->orderBy('id')->each(function ($user) {
            $flags = explode(',', (string) $user->access);
            if (count($flags) !== 8) {
                return;
            }

            DB::table('users')->where('id', $user->id)->update(['access' => implode(',', array_slice($flags, 0, 7))]);
        });
    }
};
