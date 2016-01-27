<?php

Route::group(['prefix' => 'api/v1', 'middleware' => 'cors'], function() {
    Autumn\Tools\Classes\ApiManager::instance()->getRoutes();
});