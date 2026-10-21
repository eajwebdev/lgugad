<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Crypt;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Decrypts an ID from a URL, or aborts with 404 if it was tampered with.
     *
     * Senior views use encrypt() (serialized); DAFAC views use Crypt::encryptString().
     */
    protected function decryptId(string $payload, bool $serialized = false): int
    {
        try {
            return (int) ($serialized ? Crypt::decrypt($payload) : Crypt::decryptString($payload));
        } catch (DecryptException $e) {
            abort(404);
        }
    }
}
