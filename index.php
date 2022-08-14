<?php

    //composer autoload for autoload classes and files
    require('vendor/autoload.php');

    //Handle REQUEST URI using route method of Router class to provide customized router ficility
    Router::route('/', function(){
        require(__DIR__.'/view/crud_view.php');
    });


    Router::route('/list', function(){
        Return CRUD::list();
    });


    Router::route('/store', function(){
        Return CRUD::store();
    });


    Router::route('/edit', function(){
        Return CRUD::edit();
    });

    Router::route('/update', function(){
        Return CRUD::update();
        
    });

    Router::route('/destroy', function(){
        Return CRUD::destroy();
    });

    //dispatch initialized route URI using dispatch method of Router class that will call the specific closure function
    $action = $_SERVER['REQUEST_URI'];
    Router::dispatch($action);