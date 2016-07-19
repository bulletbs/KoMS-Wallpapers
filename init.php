<?php defined('SYSPATH') or die('No direct script access.');

if(!Route::cache()){
    Route::set('wallpapers', 'wallpapers(/<action>(/<id>))', array('action'=>'(wallpaper|download|comment)', 'id'=>'\d+'))
        ->defaults(array(
            'controller' => 'wallpapers',
            'action' => 'index',
        ));
    Route::set('wallpapers_main', 'wallpapers(/p<page>)', array('page'=>'\d+'))
        ->defaults(array(
            'controller' => 'wallpapers',
            'action' => 'index',
        ));
    Route::set('wallpapers_category', 'wallpapers/<alias>(/p<page>)', array('alias'=>'[\w\d_\-]+', 'page'=>'\d+'))
        ->defaults(array(
            'controller' => 'wallpapers',
            'action' => 'index',
        ));
}