<?php

it('can generate password and activation hash', function () {
    $result = $this->generateHash('pass');

    expect($result)->toBeArray()
        ->and($result['passwordHash'])->toBeString()
        ->and($result['activationHash'])->toBeString();
});
