<?php

function city_avatar($id, $absolute = false)
{
    $city = city_fetch($id);
    return $city['image'] ? $city['image'] : ($absolute ? ENV_CONSOLE_DOMAIN : '').'/images/no_city.png';
}

function city_fetch_all()
{

    global $connect;

    $query = 'SELECT *
        FROM cities
        ORDER BY name';
    $result = mysqli_query($connect, $query);

    $data = array();

    while($record = mysqli_fetch_assoc($result))
    {
        $data[] = $record;
    }
    
    return $data;

}

function city_fetch($identifier, $field = false)
{

    if(!$identifier) return false;

    global $connect;

    if($field)
    {
        $query = 'SELECT *
            FROM cities
            WHERE '.$field.' = "'.addslashes($identifier).'"
            LIMIT 1';
    }
    else
    {
        $query = 'SELECT *
            FROM cities
            WHERE id = "'.addslashes($identifier).'"
            AND deleted_at IS NULL
            LIMIT 1';
    }
    
    $result = mysqli_query($connect, $query);

    if(mysqli_num_rows($result)) return mysqli_fetch_assoc($result);
    else return false;

}

function city_check()
{

    global $_city, $_user;

    if(!$_city)
    {
        user_set_city($_user['id']);
        header_redirect(ENV_ACCOUNT_DOMAIN.'/account/dashboard');
    }

}

function city_seeder($identifier)
{

    global $connect;

    $data = '<?php

use App\Models\Road;
use App\Models\Track;
use App\Models\Building;
use App\Models\Square;
use App\Models\SqureImage;

// **************************************************'.chr(13).
        '// Roads'.chr(13);

    $query = 'SELECT *
        FROM roads
        WHERE city_id = "'.$identifier.'"
        ORDER BY id';
    $result = mysqli_query($connect, $query);

    while($record = mysqli_fetch_assoc($result))
    {
        $data .= 'Road::factory()->create([';
        foreach($record as $key => $value)
        {
            $data .= '"'.$key.'" => "'.$value.'",';
        }
        $data .= ']);'.chr(13);
    }

    $data .= str_repeat(chr(13), 2).
        '// **************************************************'.chr(13).
        '// Tracks'.chr(13);

    $query = 'SELECT *
        FROM tracks
        WHERE city_id = "'.$identifier.'"
        ORDER BY id';
    $result = mysqli_query($connect, $query);

    while($record = mysqli_fetch_assoc($result))
    {
        $data .= 'Track::factory()->create([';
        foreach($record as $key => $value)
        {
            if($value)
            {
                $data .= '"'.$key.'" => "'.$value.'",';
            }
        }
        $data .= ']);'.chr(13);
    }

    $data .= str_repeat(chr(13), 2).
        '// **************************************************'.chr(13).
        '// Buildings'.chr(13);

    $query = 'SELECT *
        FROM buildings
        WHERE city_id = "'.$identifier.'"
        ORDER BY id';
    $result = mysqli_query($connect, $query);

    while($record = mysqli_fetch_assoc($result))
    {
        $data .= 'Building::factory()->create([';
        foreach($record as $key => $value)
        {
            if($value)
            {
                $data .= '"'.$key.'" => "'.$value.'",';
            }
        }
        $data .= ']);'.chr(13);
    }

    $data .= str_repeat(chr(13), 2).
        '// **************************************************'.chr(13).
        '// Squares'.chr(13);

    $query = 'SELECT *
        FROM squares
        WHERE city_id = "'.$identifier.'"
        ORDER BY id';
    $result = mysqli_query($connect, $query);

    while($record = mysqli_fetch_assoc($result))
    {
        $data .= '$square = Square::factory()->create([';
        foreach($record as $key => $value)
        {
            $data .= '"'.$key.'" => "'.$value.'",';
        }
        $data .= ']);'.chr(13);

        $roads = square_roads($record['id'], true);
        if(count($roads)) $data .= '$square->roads()->attach(['.implode(',', $roads).']);'.chr(13);

        $tracks = square_tracks($record['id'], true);
        if(count($tracks)) $data .= '$square->tracks()->attach(['.implode(',', $tracks).']);'.chr(13);

    }

    /*
    $data .= str_repeat(chr(13), 2).
        '// **************************************************'.chr(13).
        '// Buildings'.chr(13);

    $query = 'SELECT *
        FROM buildings
        WHERE city_id = "'.$identifier.'"
        ORDER BY id';
    $result = mysqli_query($connect, $query);

    while($record = mysqli_fetch_assoc($result))
    {
        $data .= 'Track::factory()->create([';
        foreach($record as $key => $value)
        {
            $data .= '"'.$key.'" => "'.$value.'",';
        }
        $data .= ']);'.chr(13);
    }
        */

    return $data;

    /*
    Setting::factory()->create([
        'name' => $value['name'],
        'value' => $value['value'],
    ]);
    */
}


