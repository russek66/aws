<?php


use App\Register\RegisterValidateData;

it('can validate username', function () {
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
