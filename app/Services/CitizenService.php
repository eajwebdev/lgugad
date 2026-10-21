<?php

namespace App\Services;

use App\Models\Citizen;
use App\Models\CitizenBck;
use App\Models\CitizenI;
use App\Models\CitizenII;
use App\Models\CitizenIII;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CitizenService
{
    private const PROFILE_DIR = 'uploads/senior-profile';
    private const FILES_DIR = 'uploads/senior-files';

    public function exists(string $lname, string $fname, string $mname): bool
    {
        return Citizen::where(compact('lname', 'fname', 'mname'))->exists();
    }

    /**
     * Creates the citizen and its four detail rows in one transaction.
     */
    public function register(array $data): Citizen
    {
        return DB::transaction(function () use ($data) {
            $citizen = Citizen::create([
                'lname' => $data['lname'],
                'fname' => $data['fname'],
                'mname' => $data['mname'],
                'ext' => $data['ext'] ?? null,
            ]);

            $citizen->personal()->create([
                'osca_idnum' => CitizenI::nextOscaIdNumber(),
                'gender' => $data['gender'],
                'bday' => $data['bday'],
                'age' => $data['age'],
            ]);
            $citizen->family()->create();
            $citizen->education()->create();
            $citizen->background()->create();

            return $citizen;
        });
    }

    /**
     * Sets a plain column, or toggles one slot of a CSV checkbox column when $slot is given.
     */
    public function updateField(Model $record, string $column, ?string $value, ?int $slot = null, ?int $age = null): void
    {
        if ($slot !== null) {
            $slots = explode(',', (string) $record->{$column});
            $slots = array_pad($slots, $slot + 1, '');
            $slots[$slot] = $slots[$slot] === $value ? '' : (string) $value;
            $record->{$column} = implode(',', $slots);
        } else {
            $record->{$column} = $value;

            if ($record instanceof CitizenI && $column === 'bday' && $age !== null) {
                $record->age = $age;
            }
        }

        $record->save();
    }

    public function updateProfileImage(Citizen $citizen, UploadedFile $image): void
    {
        $name = 'profile_' . Str::random(20) . '.' . $image->extension();
        $image->move(public_path(self::PROFILE_DIR), $name);

        $old = $citizen->profile;
        $citizen->update(['profile' => self::PROFILE_DIR . '/' . $name]);

        if ($old) {
            $this->deletePublicFile($old);
        }
    }

    /**
     * Stores an uploaded document and returns its stored filename.
     */
    public function addDocument(Citizen $citizen, UploadedFile $file): string
    {
        $original = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) ?: 'document';
        $name = 'file_' . random_int(10000, 99999) . '_' . Str::limit($original, 60, '') . '.' . $file->extension();
        $file->move(public_path(self::FILES_DIR), $name);

        $files = $citizen->fileList();
        $files[] = $name;
        $citizen->update(['files' => implode(',', $files)]);

        return $name;
    }

    public function documentUrl(string $fileName): string
    {
        return asset(self::FILES_DIR . '/' . $fileName);
    }

    /**
     * Removes a document only if it belongs to this citizen. Returns false when it doesn't.
     */
    public function removeDocument(Citizen $citizen, string $fileName): bool
    {
        $files = $citizen->fileList();
        $key = array_search($fileName, $files, true);

        if ($key === false) {
            return false;
        }

        unset($files[$key]);
        $citizen->update(['files' => $files ? implode(',', $files) : null]);
        $this->deletePublicFile(self::FILES_DIR . '/' . $fileName);

        return true;
    }

    /**
     * Deletes the citizen (detail rows cascade via foreign keys) and their uploaded files.
     */
    public function delete(Citizen $citizen): void
    {
        $paths = array_map(fn ($name) => self::FILES_DIR . '/' . $name, $citizen->fileList());
        if ($citizen->profile) {
            $paths[] = $citizen->profile;
        }

        $citizen->delete();

        foreach ($paths as $path) {
            $this->deletePublicFile($path);
        }
    }

    private function deletePublicFile(string $relativePath): void
    {
        $path = public_path($relativePath);
        $root = realpath(public_path('uploads'));
        $real = realpath($path);

        // Only ever delete inside public/uploads.
        if ($real && $root && str_starts_with($real, $root) && is_file($real)) {
            unlink($real);
        }
    }
}
