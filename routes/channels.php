<?php

use Illuminate\Support\Facades\Broadcast;

$fFunction = function ($user, $id) {return (int) $user->id === (int) $id;};
Broadcast::channel('App.Models.User.{id}', $fFunction);
