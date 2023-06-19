<?php

include_once '../vendor/autoload.php';

include_once 'Stream/ReadUsersCollection.php';
include_once 'Stream/ReadUser.php';

//$userCollection = ReadUsersCollection::get();
$user = ReadUser::find(1);

 var_dump($user->getResource());