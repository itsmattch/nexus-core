<?php

use Assembler\UserAssembler;
use Repository\UserRepository;
use Resource\CreateUserResource;

include_once '../vendor/autoload.php';

include_once './Assembler/UserAssembler.php';
include_once './Blueprint/UserBlueprint.php';
include_once './Model/UserModel.php';
include_once './Repository/UserRepository.php';
include_once './Resource/CreateUserResource.php';
include_once './Resource/UserCollectionResource.php';
include_once './Resource/UserResource.php';

//$repository = UserRepository::load();
//$assembler = UserAssembler::find(1);
$createUser = CreateUserResource::load(['name' => 'Sarah']);
var_dump($createUser->get());