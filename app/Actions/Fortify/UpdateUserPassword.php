<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class UpdateUserPassword implements UpdatesUserPasswords
{
  use PasswordValidationRules;

  public function update($user, array $input)
  {
    $arr = [
      'required',
      'string',
    ];

    $passwordRules = $this->passwordRules();

    $arr = [
      'current_password' => $arr,
      'password' => $passwordRules,
    ];

    $make = Validator::make($input, $arr);

    $after = $make->after(function ($validator) use ($user, $input) {
      $bln = isset($input['current_password']);
      $bln = $bln && Hash::check($input['current_password'], $user->password);

      if (! $bln) {
        $errors = $validator->errors();
        $__ = __('The provided password does not match your current password.');
        $errors->add('current_password', $__);
      }
    });

    $after->validateWithBag('updatePassword');
    $make = Hash::make($input['password']);
    $arr = ['password' => $make];
    $forceFill = $user->forceFill($arr);
    $forceFill->save();
  }
}
