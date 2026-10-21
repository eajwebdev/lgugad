<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

/**
 * Create (no `uid`) and update (with `uid`) of a system user.
 */
class UserRequest extends BaseFormRequest
{
    public function rules(): array
    {
        $isUpdate = $this->filled('uid');

        return [
            'uid' => $isUpdate ? 'required|integer|exists:users,id' : 'prohibited',
            'lname' => 'required|string|max:255',
            'fname' => 'required|string|max:255',
            'mname' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($this->input('uid'))],
            'password' => $isUpdate ? 'nullable|string|min:5' : 'required|string|min:5',
            'Role' => 'required|in:Administrator,Office Staff',
            'gender' => 'required|string|max:10',
            'access' => 'nullable|array',
            'access.*' => 'in:0,1',
        ];
    }

    public function toModelData(): array
    {
        $data = [
            'fname' => $this->validated('fname'),
            'mname' => $this->validated('mname'),
            'lname' => $this->validated('lname'),
            'username' => $this->validated('username'),
            'role' => $this->validated('Role'),
            'gender' => $this->validated('gender'),
            'access' => User::buildAccess($this->validated('access', []), $this->validated('Role')),
        ];

        if ($this->filled('password')) {
            $data['password'] = Hash::make($this->validated('password'));
        }

        return $data;
    }
}
