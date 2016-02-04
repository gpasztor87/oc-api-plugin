<?php

Route::group(['prefix' => 'api/v1'], function() {
    Autumn\Api\Classes\ApiManager::instance()->getRoutes();
});