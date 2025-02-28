<?php

function navigation_array($selected = false)
{

    $navigation = [
       [
            'icon' => 'bm-maps',
            'url' => '/pdfer/dashboard',
            'title' => 'PDFer',
            'id' => 'pdfer',
            'icon' => 'fa-solid fa-file-pdf',
            'pages' => [
                [
                    'title' => 'Dashboard',
                    'url' => '/pdfer/dashboard',
                    'colour' => 'red',
                ],[
                    'title' => 'History',
                    'url' => '/pdfer/history',
                    'colour' => 'red',
                ],
            ],
        ],[
            'icon' => 'bm-places',
            'url' => '/images/dashboard',
            'title' => 'Images',
            'id' => 'images',
            'icon' => 'fa-solid fa-image',
            'pages' => [
                [
                    'title' => 'Dashboard',
                    'url' => '/pdfer/dashboard',
                    'colour' => 'red',
                ],[
                    'title' => 'History',
                    'url' => '/pdfer/history',
                    'colour' => 'red',
                ],
            ],
        ],[
            'icon' => 'bm-roadview',
            'url' => '/charts/dashboard',
            'title' => 'Charts',
            'id' => 'charts',
            'icon' => 'fa-solid fa-chart-simple',
            'pages' => [
                [
                    'title' => 'Dashboard',
                    'url' => '/pdfer/dashboard',
                    'colour' => 'red',
                ],[
                    'title' => 'History',
                    'url' => '/pdfer/history',
                    'colour' => 'red',
                ],
            ],
        ],[
            'br' => '---',
        ],[
            'icon' => 'bm-trackview',
            'url' => '/keys/dashboard',
            'title' => 'API Keys',
            'id' => 'keys',
            'icon' => 'fa-solid fa-key',
            'pages' => []
        ],[
            'icon' => 'bm-trackview',
            'url' => '/access/dashboard',
            'title' => 'IP Access',
            'id' => 'access',
            'icon' => 'fa-solid fa-server',
            'pages' => []
        ],
    ];

    if($selected)
    {
        
        $selected = '/'.$selected;
        $selected = str_replace('//', '/', $selected);
        $selected = str_replace('.php', '', $selected);
        $selected = str_replace('.', '/', $selected);
        $selected = substr($selected, 0, strrpos($selected, '/'));

        foreach($navigation as $section)
        {

            foreach($section['pages'] as $page)
            {

                if(strpos($page['url'], $selected) === 0)
                {
                    return $section;
                }

            }

        }


    }

    return $navigation;

}