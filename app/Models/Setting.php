<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Single-row table (id = 1) holding the system name and logo.
 */
class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'system_name',
        'photo_filename',
    ];

    private static ?self $current = null;

    /**
     * The settings row, loaded once per request. Unsaved if the row doesn't exist yet.
     */
    public static function current(): self
    {
        return static::$current ??= static::firstOrNew(['id' => 1]);
    }

    public static function forgetCurrent(): void
    {
        static::$current = null;
    }
}
