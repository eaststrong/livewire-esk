<?php

namespace App\Models;

use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\TeamInvitation as JetstreamTeamInvitation;

class TeamInvitation extends JetstreamTeamInvitation
{
  protected $fillable = [
    'email',
    'role',
  ];

  public function team()
  {
    $teamModel = Jetstream::teamModel();
    return $this->belongsTo($teamModel);
  }
}
