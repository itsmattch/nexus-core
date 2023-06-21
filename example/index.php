<?php

use Assembler\UserAssembler;
use Repository\UserRepository;

include_once '../vendor/autoload.php';

include_once './Assembler/UserAssembler.php';
include_once './Blueprint/UserBlueprint.php';
include_once './Model/UserModel.php';
include_once './Repository/UserRepository.php';
include_once './Resource/UserCollectionResource.php';
include_once './Resource/UserResource.php';

//$repository = UserRepository::load();
$assembler = UserAssembler::find(1);
