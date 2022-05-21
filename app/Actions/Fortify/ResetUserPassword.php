<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

class ResetUserPassword implements ResetsUserPasswords
{
  use PasswordValidationRules;

  public function reset($user, array $input)
  {
    $passwordRules = $this->passwordRules();
    $arr = ['password' => $passwordRules];
    $make = Validator::make($input, $arr);
    $make->validate();
    $make = Hash::make($input['password']);
    $arr = ['password' => $make];
    $forceFill = $user->forceFill($arr);
    $forceFill->save();
  }
}
