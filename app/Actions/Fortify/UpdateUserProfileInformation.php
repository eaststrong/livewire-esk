<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
  public function update($user, array $input)
  {
    $unique = Rule::unique('users');
    $ignore = $unique->ignore($user->id);

    $arr1 = [
      'required',
      'email',
      'max:255',
      $ignore,
    ];

    $arr2 = [
      'required',
      'string',
      'max:255',
    ];

    $arr3 = [
      'nullable',
      'mimes:jpg,jpeg,png',
      'max:1024',
    ];

    $arr = [
      'email' => $arr1,
      'name' => $arr2,
      'photo' => $arr3,
    ];

    $make = Validator::make($input, $arr);
    $make->validateWithBag('updateProfileInformation');
    $isset = isset($input['photo']);

    if ($isset) {
      $user->updateProfilePhoto($input['photo']);
    }

    $bln = $input['email'] !== $user->email;
    $bln = $bln && $user instanceof MustVerifyEmail;

    if ($bln) {
      $this->updateVerifiedUser($user, $input);
    } else {
      $arr = [
        'email' => $input['email'],
        'name' => $input['name'],
      ];

      $forceFill = $user->forceFill($arr);
      $forceFill->save();
    }
  }

  protected function updateVerifiedUser($user, array $input)
  {
    $arr = [
      'email' => $input['email'],
      'email_verified_at' => null,
      'name' => $input['name'],
    ];

    $forceFill = $user->forceFill($arr);
    $forceFill->save();
    $user->sendEmailVerificationNotification();
  }
}
