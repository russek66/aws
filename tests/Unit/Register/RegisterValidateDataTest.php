<?php


use App\DataTransfer\RegisterDTO;
use App\Register\RegisterValidateData;

uses(GetResult::class);

it('can validate user name', function () {
    $badRDTO = new RegisterDTO(
        'russet',
        'russet',
        'russet',
        'russet',
        'russet'
    );
    $goodRDTO = new RegisterDTO(
        'ruawek856',
        '8BananaJu!cy',
        '8BananaJu!cy',
        '8BananaJuqcy@gmail.com',
        '8BananaJuqcy@gmail.com'
    );

    $object = (new RegisterValidateData($badRDTO));
    $object2 = (new RegisterValidateData($goodRDTO));

    $object->validateUserName();
    $object2->validateUserName();

    $this->setParams($object);
    expect($this->result)->toBeFalse();
    $this->setParams($object2);
    expect($this->result)->toBeTrue();

});

it('can validate user email', function () {
    $result = (new RegisterValidateData([
        'user_email' => 'russekwp.pl',
        'user_email_repeat' => 'russekwp.pl'
    ]));
    $result2 = (new RegisterValidateData([
        'user_email' => 'russek@wp.pl',
        'user_email_repeat' => 'russek@wp.pl'
    ]));

    $result->validateUserEmail();
    $result2->validateUserEmail();

    expect($result->getResult())->toBeFalse()
        ->and($result2->getResult())->toBeTrue();
});

it('can validate user password', function () {
    $result = (new RegisterValidateData([
        'user_password' => 'russet',
        'user_password_repeat' => 'russet'
    ]));
    $result2 = (new RegisterValidateData([
        'user_password' => 'russEk66!',
        'user_password_repeat' => 'russEk66!'
    ]));

    $result->validateUserPassword();
    $result2->validateUserPassword();

    expect($result->getResult())->toBeFalse()
        ->and($result2->getResult())->toBeTrue();
});
