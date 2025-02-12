<?php

function navigation_array($selected = false)
{

    $navigation = [
        [
            'title' => 'City Portal',
            'sections' => [
                [
                    'title' => 'Geography',
                    'id' => 'geography',
                    'pages' => [
                        [
                            'icon' => 'bm-maps',
                            'url' => '/maps/dashboard',
                            'title' => 'Maps',
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/maps/dashboard',
                                    'colour' => 'red',
                                ],[
                                    'title' => 'Map Quick Edit',
                                    'url' => '/maps/quick',
                                    'colour' => 'red',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Maps',
                                    'url' => '/maps/dashboard',
                                    'colour' => 'red',
                                    'icon' => 'bm-maps',
                                ],[
                                    'title' => 'Places',
                                    'url' => '/places/dashboard',
                                    'colour' => 'red',
                                    'icon' => 'bm-places',
                                ],[
                                    'title' => 'Road View',
                                    'url' => '/roadview/dashboard',
                                    'colour' => 'red',
                                    'icon' => 'bm-roadview',
                                ],[
                                    'title' => 'Track View',
                                    'url' => '/trackview/dashboard',
                                    'colour' => 'red',
                                    'icon' => 'bm-trackview',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Visit Maps App',
                                    'url' => 'https://maps.brickmmo.com',
                                    'colour' => 'orange',
                                    'icon' => 'fa-solid fa-arrow-up-right-from-square',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Uptime Report',
                                    'url' => '/uptime/maps',
                                    'colour' => 'orange',
                                    'icons' => 'bm-uptime',
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/uptime/maps',
                                    'colour' => 'orange',
                                    'icons' => 'bm-stats',
                                ],
                            ],
                        ],[
                            'icon' => 'bm-places',
                            'url' => '/places/dashboard',
                            'title' => 'Places',
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/places/dashboard',
                                    'colour' => 'red',
                                ],[
                                    'title' => 'Buildings',
                                    'url' => '/places/buildings',
                                    'colour' => 'red',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Maps',
                                    'url' => '/maps/dashboard',
                                    'colour' => 'red',
                                    'icon' => 'bm-maps',
                                ],[
                                    'title' => 'Places',
                                    'url' => '/places/dashboard',
                                    'colour' => 'red',
                                    'icon' => 'bm-places',
                                ],[
                                    'title' => 'Road View',
                                    'url' => '/roadview/dashboard',
                                    'colour' => 'red',
                                    'icon' => 'bm-roadview',
                                ],[
                                    'title' => 'Track View',
                                    'url' => '/trackview/dashboard',
                                    'colour' => 'red',
                                    'icon' => 'bm-trackview',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Visit Maps App',
                                    'url' => 'https://maps.brickmmo.com',
                                    'colour' => 'orange',
                                    'icon' => 'fa-solid fa-arrow-up-right-from-square',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Uptime Report',
                                    'url' => '/uptime/maps',
                                    'colour' => 'orange',
                                    'icons' => 'bm-uptime',
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/uptime/maps',
                                    'colour' => 'orange',
                                    'icons' => 'bm-stats',
                                ],
                            ],
                        ],[
                            'icon' => 'bm-roadview',
                            'url' => '/roadview/dashboard',
                            'title' => 'Road View',
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/roadview/dashboard',
                                    'colour' => 'red',
                                ],[
                                    'title' => 'Roads',
                                    'url' => '/roadview/roads',
                                    'colour' => 'red',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Maps',
                                    'url' => '/maps/dashboard',
                                    'colour' => 'red',
                                    'icon' => 'bm-maps',
                                ],[
                                    'title' => 'Places',
                                    'url' => '/places/dashboard',
                                    'colour' => 'red',
                                    'icon' => 'bm-places',
                                ],[
                                    'title' => 'Road View',
                                    'url' => '/roadview/dashboard',
                                    'colour' => 'red',
                                    'icon' => 'bm-roadview',
                                ],[
                                    'title' => 'Track View',
                                    'url' => '/trackview/dashboard',
                                    'colour' => 'red',
                                    'icon' => 'bm-trackview',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Visit Maps App',
                                    'url' => 'https://maps.brickmmo.com',
                                    'colour' => 'orange',
                                    'icon' => 'fa-solid fa-arrow-up-right-from-square',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Uptime Report',
                                    'url' => '/uptime/maps',
                                    'colour' => 'orange',
                                    'icons' => 'bm-uptime',
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/uptime/maps',
                                    'colour' => 'orange',
                                    'icons' => 'bm-stats',
                                ],
                            ],
                        ],[
                            'icon' => 'bm-trackview',
                            'url' => '/trackview/dashboard',
                            'title' => 'Track View',
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/trackview/dashboard',
                                    'colour' => 'red',
                                ],[
                                    'title' => 'Tracks',
                                    'url' => '/trackview/tracks',
                                    'colour' => 'red',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Maps',
                                    'url' => '/maps/dashboard',
                                    'colour' => 'red',
                                    'icon' => 'bm-maps',
                                ],[
                                    'title' => 'Places',
                                    'url' => '/places/dashboard',
                                    'colour' => 'red',
                                    'icon' => 'bm-places',
                                ],[
                                    'title' => 'Road View',
                                    'url' => '/roadview/dashboard',
                                    'colour' => 'red',
                                    'icon' => 'bm-roadview',
                                ],[
                                    'title' => 'Track View',
                                    'url' => '/trackview/dashboard',
                                    'colour' => 'red',
                                    'icon' => 'bm-trackview',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Visit Maps App',
                                    'url' => 'https://maps.brickmmo.com',
                                    'colour' => 'orange',
                                    'icon' => 'fa-solid fa-arrow-up-right-from-square',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Uptime Report',
                                    'url' => '/uptime/maps',
                                    'colour' => 'orange',
                                    'icons' => 'bm-uptime',
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/uptime/maps',
                                    'colour' => 'orange',
                                    'icons' => 'bm-stats',
                                ],
                            ],
                        ],
                    ],
                ],[
                    'title' => 'Control',
                    'id' => 'control',
                    'pages' => [
                        [
                            'icon' => 'bm-control-panel',
                            'url' => '/panel/dashboard',
                            'title' => 'Control Panel',
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/panel/dashboard',
                                    'colour' => 'red',
                                ],[
                                    'title' => 'Modify Values',
                                    'url' => '/panel/values',
                                    'colour' => 'red',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Visit Control Panel App',
                                    'url' => 'https://panel.brickmmo.com',
                                    'colour' => 'orange',
                                    'icon' => 'fa-solid fa-arrow-up-right-from-square',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Uptime Report',
                                    'url' => '/uptime/panel',
                                    'colour' => 'orange',
                                    'icons' => 'bm-uptime',
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/stats/panel',
                                    'colour' => 'orange',
                                    'icons' => 'bm-stats',
                                ],
                            ],
                        ],[
                            'icon' => 'bm-control-clock',
                            'url' => '/clock/dashboard',
                            'title' => 'Clock',
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/panel/dashboard',
                                    'colour' => 'red',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Visit Clock App',
                                    'url' => 'https://clock.brickmmo.com',
                                    'colour' => 'orange',
                                    'icon' => 'fa-solid fa-arrow-up-right-from-square',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Uptime Report',
                                    'url' => '/uptime/clock',
                                    'colour' => 'orange',
                                    'icons' => 'bm-uptime',
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/stats/clock',
                                    'colour' => 'orange',
                                    'icons' => 'bm-stats',
                                ],
                            ],
                        ],
                    ],
                ],[
                    'title' => 'Community',
                    'id' => 'community',
                    'pages' => [
                        [
                            'icon' => 'bm-radio-station',
                            'url' => '/radio/dashboard',
                            'title' => 'Radio',
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/radio/dashboard',
                                    'colour' => 'red',
                                ],[
                                    'title' => 'Schedule',
                                    'url' => '/radio/schedule',
                                    'colour' => 'red',
                                ],[
                                    'title' => 'Types',
                                    'url' => '/radio/types',
                                    'colour' => 'red',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Visit Radio App',
                                    'url' => 'https://lively.brickmmo.com',
                                    'colour' => 'orange',
                                    'icon' => 'fa-solid fa-arrow-up-right-from-square',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Uptime Report',
                                    'url' => '/uptime/radio',
                                    'colour' => 'orange',
                                    'icons' => 'bm-uptime',
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/stats/radio',
                                    'colour' => 'orange',
                                    'icons' => 'bm-stats',
                                ],
                            ],
                        ],[
                            'icon' => 'bm-events',
                            'url' => '/events/dashboard',
                            'title' => 'Events',
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/events/dashboard',
                                    'colour' => 'red',
                                ],[
                                    'title' => 'Event List',
                                    'url' => '/events/list',
                                    'colour' => 'red',
                                ],[
                                    'title' => 'Registration List',
                                    'url' => '/events/registrations/list',
                                    'colour' => 'red',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Visit Events App',
                                    'url' => 'https://events.brickmmo.com',
                                    'colour' => 'orange',
                                    'icon' => 'fa-solid fa-arrow-up-right-from-square',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Uptime Report',
                                    'url' => '/uptime/events',
                                    'colour' => 'orange',
                                    'icons' => 'bm-uptime',
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/stats/evenrs',
                                    'colour' => 'orange',
                                    'icons' => 'bm-stats',
                                ],
                            ],
                        ],[
                            'icon' => 'bm-qr',
                            'url' => '/qr/dashboard',
                            'title' => 'Qr Codes',
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/qr/dashboard',
                                    'colour' => 'red',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Visit QR App',
                                    'url' => 'https://qr.brickmmo.com',
                                    'colour' => 'orange',
                                    'icon' => 'fa-solid fa-arrow-up-right-from-square',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Uptime Report',
                                    'url' => '/uptime/qr',
                                    'colour' => 'orange',
                                    'icons' => 'bm-uptime',
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/stats/qr',
                                    'colour' => 'orange',
                                    'icons' => 'bm-stats',
                                ],
                            ],
                        ],
                    ],
                ],[
                    'title' => 'Social',
                    'id' => 'social',
                    'pages' => [
                        [
                            'icon' => 'bm-brix',
                            'url' => '/brix/dashboard',
                            'title' => 'Brix',
                        ],[
                            'icon' => 'bm-timeline',
                            'url' => '/timeline/dashboard',
                            'title' => 'Timeline',
                        ],
                    ],
                ],[
                    'title' => 'Finances',
                    'id' => 'finances',
                    'pages' => [
                        [
                            'icon' => 'bm-crypto',
                            'url' => '/crypto/dashboard',
                            'title' => 'Crypto',
                        ],
                    ],
                ],
            ],
        ],[
            'title' => 'Student Portal',
            'sections' => [
                [
                    'title' => 'Workflow',
                    'id' => 'students',
                    'pages' => [
                        [
                            'icon' => 'bm-timesheets',
                            'url' => '/timesheets/dashboard',
                            'title' => 'Timesheets',
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/timesheets/dashboard',
                                    'colour' => 'red',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'View Timesheet',
                                    'url' => '/timesheets/dashboard/list',
                                    'colour' => 'orange',
                                ],
                            ],
                        ],[
                            'icon' => 'bm-brickoverflow',
                            'url' => '/brickoverflow/dashboard',
                            'title' => 'BrickOverflow',
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/brickoverflow/dashboard',
                                    'colour' => 'red',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/stats/brickoverflow',
                                    'colour' => 'orange',
                                    'icons' => 'bm-stats',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],[
            'title' => 'Administration',
            'sections' => [
                [
                    'title' => 'Content',
                    'id' => 'admin-content',
                    'pages' => [
                        [
                            'icon' => 'bm-bricksum',
                            'url' => '/admin/bricksum/dashboard',
                            'title' => 'Bricksum',
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/admin/bricksum/dashboard',
                                    'colour' => 'red',
                                ],[
                                    'title' => 'Modify Word List',
                                    'url' => '/admin/bricksum/wordlist',
                                    'colour' => 'red',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Visit Bricksum App',
                                    'url' => 'https://bricksum.brickmmo.com',
                                    'colour' => 'orange',
                                    'icon' => 'fa-solid fa-arrow-up-right-from-square',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Uptime Report',
                                    'url' => '/uptime/bricksum',
                                    'colour' => 'orange',
                                    'icons' => 'bm-uptime',
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/stas/bricksum',
                                    'colour' => 'orange',
                                    'icons' => 'bm-stats',
                                ],
                            ],
                        ],[
                            'icon' => 'bm-colours',
                            'url' => '/admin/colours/dashboard',
                            'title' => 'Colours',
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/admin/colours/dashboard',
                                    'colour' => 'red',
                                ],[
                                    'title' => 'Import Colours',
                                    'url' => '/admin/colours/import',
                                    'colour' => 'red',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Visit Colors App',
                                    'url' => 'https://colours.brickmmo.com',
                                    'colour' => 'orange',
                                    'icon' => 'fa-solid fa-arrow-up-right-from-square',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Uptime Report',
                                    'url' => '/uptime/colours',
                                    'colour' => 'orange',
                                    'icons' => 'bm-uptime',
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/stas/colours',
                                    'colour' => 'orange',
                                    'icons' => 'bm-stats',
                                ],
                            ],
                        ],[
                            'icon' => 'bm-parts',
                            'url' => '/admin/parts/dashboard',
                            'title' => 'Parts',
                        ],[
                            'icon' => 'bm-stores',
                            'url' => '/admin/stores/dashboard',
                            'title' => 'Stores',
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/admin//stores/dashboard',
                                    'colour' => 'red',
                                ],[
                                    'title' => 'Import Stores',
                                    'url' => '/admin//stores/import',
                                    'colour' => 'red',
                                ],[
                                    'title' => 'Import Countries',
                                    'url' => '/admin//stores/countries',
                                    'colour' => 'red',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Visit Stores App',
                                    'url' => 'https://stores.brickmmo.com',
                                    'colour' => 'orange',
                                    'icon' => 'fa-solid fa-arrow-up-right-from-square',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Uptime Report',
                                    'url' => '/uptime/stores',
                                    'colour' => 'orange',
                                    'icons' => 'bm-uptime',
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/stats/stores',
                                    'colour' => 'orange',
                                    'icons' => 'bm-stats',
                                ],
                            ],
                        ],[
                            'icon' => 'bm-media',
                            'url' => '/admin/media/dashboard',
                            'title' => 'Media',
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/admin/media/dashboard',
                                    'colour' => 'red',
                                ],[
                                    'title' => 'Images',
                                    'url' => '/admin/media/images',
                                    'colour' => 'red',
                                ],[
                                    'title' => 'Video',
                                    'url' => '/admin/media/video',
                                    'colour' => 'red',
                                ],[
                                    'title' => 'Audio',
                                    'url' => '/admin/media/audio',
                                    'colour' => 'red',
                                ],[
                                    'title' => 'Tags',
                                    'url' => '/admin/media/tags',
                                    'colour' => 'red',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Visit BrickMMO Media',
                                    'url' => 'https://media.brickmmo.com',
                                    'colour' => 'orange',
                                    'icon' => 'fa-solid fa-arrow-up-right-from-square',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Uptime Report',
                                    'url' => '/uptime/media',
                                    'colour' => 'orange',
                                    'icons' => 'bm-uptime',
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/stats/media',
                                    'colour' => 'orange',
                                    'icons' => 'bm-stats',
                                ],
                            ] ,
                        ],
                    ],
                ],[
                    'title' => 'Finances',
                    'id' => 'admin-finances',
                    'pages' => [
                        [
                            'icon' => 'bm-crypto',
                            'url' => '/admin/crypto/dashboard',
                            'title' => 'Crypto',
                        ],
                    ],
                ],[
                    'title' => 'Tools',
                    'id' => 'admin-tools',
                    'pages' => [
                        [
                            'icon' => 'bm-github',
                            'url' => '/admin/github/dashboard',
                            'title' => 'GitHub Scanner', 
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/admin/github/dashboard',
                                    'colour' => 'red',
                                ],[
                                    'title' => 'Scan Results',
                                    'url' => '/admin/github/results',
                                    'colour' => 'red',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Visit Applications App',
                                    'url' => 'https://applications.brickmmo.com/',
                                    'colour' => 'orange',
                                    'icon' => 'fa-solid fa-arrow-up-right-from-square',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'BrickMMO on GitHub',
                                    'url' => 'https://github.com/BrickMMO',
                                    'colour' => 'orange',
                                    'icon' => 'fa-solid fa-arrow-up-right-from-square',
                                ],[
                                    'title' => 'codeadamca on GitHub',
                                    'url' => 'https://github.com/codeadamca',
                                    'colour' => 'orange',
                                    'icon' => 'fa-solid fa-arrow-up-right-from-square',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Uptime Report',
                                    'url' => '/uptime/contributions',
                                    'colour' => 'orange',
                                    'icons' => 'bm-uptime',
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/stats/contributions',
                                    'colour' => 'orange',
                                    'icons' => 'bm-stats',
                                ],
                            ],
                        ],[
                            'icon' => 'bm-control-panel',
                            'url' => '/admin/panel/dashboard',
                            'title' => 'Control Panel',
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/admin/panel/dashboard',
                                    'colour' => 'red',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Visit Panel App',
                                    'url' => 'https://panel.brickmmo.com',
                                    'colour' => 'orange',
                                    'icon' => 'fa-solid fa-arrow-up-right-from-square',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Uptime Report',
                                    'url' => '/uptime/panel',
                                    'colour' => 'orange',
                                    'icons' => 'bm-uptime',
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/stats/panel',
                                    'colour' => 'orange',
                                    'icons' => 'bm-stats',
                                ],
                            ],
                        ],[
                            'icon' => 'bm-uptime',
                            'url' => '/uptime/dashboard',
                            'title' => 'Up Time',
                            'sub-pages' => [],
                        ],[
                            'icon' => 'bm-stats',
                            'url' => '/stats/dashboard',
                            'title' => 'Stats',
                            'sub-pages' => [],
                        ],
                    ],
                ],[
                    'title' => 'Settings',
                    'id' => 'admin-settings',
                    'pages' => [
                        [
                            'icon' => 'bm-github',
                            'url' => '/admin/applications/dashboard',
                            'title' => 'Applications', 
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/admin/applications/dashboard',
                                    'colour' => 'red',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Visit Applications App',
                                    'url' => 'https://applications.brickmmo.com',
                                    'colour' => 'orange',
                                    'icon' => 'fa-solid fa-arrow-up-right-from-square',
                                ],[
                                    'br' => '---',
                                ],[
                                    'title' => 'Uptime Report',
                                    'url' => '/uptime/panel',
                                    'colour' => 'orange',
                                    'icons' => 'bm-uptime',
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/stats/panel',
                                    'colour' => 'orange',
                                    'icons' => 'bm-stats',
                                ],
                            ],
                        ],[
                            'icon' => 'bm-settings',
                            'url' => '/admin/settings/dashboard',
                            'title' => 'Settings', 
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/admin/settings/dashboard',
                                    'colour' => 'red',
                                ]
                            ],
                        ],[
                            'icon' => 'bm-github',
                            'url' => '/admin/authentication/dashboard',
                            'title' => 'Authentication', 
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/admin/authentication/dashboard',
                                    'colour' => 'red',
                                ],
                            ],
                        ],[
                            'icon' => 'bm-github',
                            'url' => '/admin/crons/dashboard',
                            'title' => 'Cron Jobs', 
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/admin/crons/dashboard',
                                    'colour' => 'red',
                                ],
                            ],
                        ],
                    ],
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

        foreach($navigation as $levels)
        {

            foreach($levels['sections'] as $section)
            {

                foreach($section['pages'] as $page)
                {

                    if(strpos($page['url'], $selected) === 0)
                    {
                        return $page;
                    }

                }

            }

        }

    }

    return $navigation;

}