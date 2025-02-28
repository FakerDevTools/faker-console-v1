<?php

function application_avatar($id, $absolute = false)
{
    $application = application_fetch($id);
    return $application['image'] ? $application['image'] : ($absolute ? ENV_CONSOLE_DOMAIN : '').'/images/no_application.png';
}

function application_fetch_all()
{

    global $connect;

    $query = 'SELECT *
        FROM applications
        ORDER BY name';
    $result = mysqli_query($connect, $query);

    $data = array();

    while($record = mysqli_fetch_assoc($result))
    {
        $data[] = $record;
    }
    
    return $data;

}

function application_fetch($identifier, $field = false)
{

    if(!$identifier) return false;

    global $connect;

    if($field)
    {
        $query = 'SELECT *
            FROM applications
            WHERE '.$field.' = "'.addslashes($identifier).'"
            LIMIT 1';
    }
    else
    {
        $query = 'SELECT *
            FROM applications
            WHERE id = "'.addslashes($identifier).'"
            AND deleted_at IS NULL
            LIMIT 1';
    }
    
    $result = mysqli_query($connect, $query);

    if(mysqli_num_rows($result)) return mysqli_fetch_assoc($result);
    else return false;

}

function application_check()
{

    global $_application, $_user;

    if(!$_application)
    {
        user_set_application($_user['id']);
        header_redirect(ENV_CONSOLE_DOMAIN.'/account/dashboard');
    }

}

function application_seeder($identifier)
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
        WHERE application_id = "'.$identifier.'"
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
        WHERE application_id = "'.$identifier.'"
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
        WHERE application_id = "'.$identifier.'"
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
        WHERE application_id = "'.$identifier.'"
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
        WHERE application_id = "'.$identifier.'"
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


