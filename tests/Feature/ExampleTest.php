<?php

test('returns a successful response', function () {
    $response = $this->get(route('modules.index'));

    $response->assertOk();
});
