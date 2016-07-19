<?php

return array
(
    'cards' => array(
        'total_items'       => 0,
        'items_per_page'    => 25,
        'current_page'      => array
        (
            'source'        => 'route',
            'key'           => 'page',
        ),
        'view'              => 'cards/pagination',
        'auto_hide'         => TRUE,
        'first_page_in_url' => FALSE,
        'count_out' => 1,
        'count_in' => 9,
    ),

);