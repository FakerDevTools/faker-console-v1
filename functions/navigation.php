<?php

function navigation_array($selected = false)
{

    $navigation = [
       [
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
            'url' => '/tokens/dashboard',
            'title' => 'API Tokens',
            'id' => 'tokens',
            'icon' => 'fa-solid fa-key',
            'pages' => [
                [
                    'title' => 'Dashboard',
                    'url' => '/tokens/dashboard',
                    'colour' => 'red',
                ],[
                    'title' => 'Add Key',
                    'url' => '/tokens/add',
                    'colour' => 'red',
                ],
            ],
        ],[
            'url' => '/access/dashboard',
            'title' => 'IP Access',
            'id' => 'access',
            'icon' => 'fa-solid fa-server',
            'pages' => [
                [
                    'title' => 'Dashboard',
                    'url' => '/access/dashboard',
                    'colour' => 'red',
                ],[
                    'title' => 'Add Key',
                    'url' => '/access/add',
                    'colour' => 'red',
                ],
            ],
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

            if(isset($section['pages']))
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


    }

    return $navigation;

}