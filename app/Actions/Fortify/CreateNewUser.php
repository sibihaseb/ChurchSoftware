<?php

namespace App\Actions\Fortify;

use App\Models\Church;
use App\Models\TemporaryAppCode;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'country_id' => ['nullable', 'string', 'max:255'],
            'state_id' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:255'],
            'church_name' => ['nullable', 'string', 'max:255'],
        ])->validate();

        $church = null;
        if (isset($input['church_name'])) {
            $churchname = $input['church_name'];
            unset($input['church_name']);

            $church = Church::create([
                'name' => $churchname,
            ]);
        }

        $user =  User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'phone' => isset($input['phone']) ? $input['phone'] : null,
            'address' => isset($input['address']) ? $input['address'] : null,
            'city' => isset($input['city']) ? $input['city'] : null,
            'country_id' => isset($input['country_id']) ? $input['country_id'] : null,
            'state_id' => isset($input['state_id']) ? $input['state_id'] : null,
            'postal_code' => isset($input['postal_code']) ? $input['postal_code'] : null,
            'church_id' => isset($church) ? $church->id : null,
            'account_type' => $church ? "a" : "d",
        ])->assignRole($church ? 'Admin' : 'Donar');

        if ($church) {
            TemporaryAppCode::create([
                'user_id' => $user->id,
                'church_id' => $church->id,
            ]);
        }

        return $user;
    }
}
