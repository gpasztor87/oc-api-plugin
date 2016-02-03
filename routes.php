<?php

Route::group(['prefix' => 'api/v1'], function() {
    Autumn\Tools\Classes\ApiManager::instance()->getRoutes();
});