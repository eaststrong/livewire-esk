<?php

use Illuminate\Support\Facades\Broadcast;

$fChannel = function ($user, $id) {return (int) $user->id === (int) $id;};
Broadcast::channel('App.Models.User.{id}', $fChannel);
