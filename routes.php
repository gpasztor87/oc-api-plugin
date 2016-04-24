<?php

Route::group(['prefix' => 'api/v1', 'middleware' => 'cors'], function () {
    Autumn\Api\Classes\ApiManager::instance()->getRoutes();
});
