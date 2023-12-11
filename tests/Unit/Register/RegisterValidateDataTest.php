<?php


use App\Register\RegisterValidateData;

it('can validate user name', function () {
    $result = (new RegisterValidateData([
        'user_name' => 'russet'
    ]));
    $result2 = (new RegisterValidateData([
        'user_name' => 'russEk66'
    ]));

    $result->validateUserName();
    $result2->validateUserName();

    expect($result->getValidationResult())->toBeFalse()
        ->and($result2->getValidationResult())->toBeTrue();
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

    expect($result->getValidationResult())->toBeFalse()
        ->and($result2->getValidationResult())->toBeTrue();
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

    expect($result->getValidationResult())->toBeFalse()
        ->and($result2->getValidationResult())->toBeTrue();
});
