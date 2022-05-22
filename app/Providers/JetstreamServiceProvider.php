<?php

namespace App\Providers;

use App\Actions\Jetstream\AddTeamMember;
use App\Actions\Jetstream\CreateTeam;
use App\Actions\Jetstream\DeleteTeam;
use App\Actions\Jetstream\DeleteUser;
use App\Actions\Jetstream\InviteTeamMember;
use App\Actions\Jetstream\RemoveTeamMember;
use App\Actions\Jetstream\UpdateTeamName;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
{
  public function register()
  {
  }

  public function boot()
  {
    $this->configurePermissions();
    Jetstream::createTeamsUsing(CreateTeam::class);
    Jetstream::updateTeamNamesUsing(UpdateTeamName::class);
    Jetstream::addTeamMembersUsing(AddTeamMember::class);
    Jetstream::inviteTeamMembersUsing(InviteTeamMember::class);
    Jetstream::removeTeamMembersUsing(RemoveTeamMember::class);
    Jetstream::deleteTeamsUsing(DeleteTeam::class);
    Jetstream::deleteUsersUsing(DeleteUser::class);
  }

  protected function configurePermissions()
  {
    $arr = ['read'];
    Jetstream::defaultApiTokenPermissions($arr);

    $arr = [
      'create',
      'read',
      'update',
      'delete',
    ];

    $role = Jetstream::role('admin', 'Administrator', $arr);
    $role->description('Administrator users can perform any action.');

    $arr = [
      'read',
      'create',
      'update',
    ];

    $role = Jetstream::role('editor', 'Editor', $arr);
    $role->description('Editor users have the ability to read, create, and update.');
  }
}
