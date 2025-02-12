<?php

$length = 1;

$prompt = 'Write a script for a '.$length.' minute radio segment. 

The radio station name is Lively Radio. 

There is one host for the radio station. 
His name is Emit and he is the main character from the LEGO movie.

Only include the words the host will say, no instructions, no speaker names, no music or sounds.

The topic of this segment is traffic. 

Here is a list of each road, the road, and how many cars are currently on the road:

';

$query = 'SELECT *,(
        SELECT COUNT(*)
        FROM squares
        INNER JOIN coords
        ON squares.x = coords.x
        AND squares.y = coords.y
        INNER JOIN road_square
        ON squares.id = road_square.square_id
        WHERE road_square.road_id = roads.id 
    ) AS cars,(
        SELECT COUNT(*)
        FROM squares
        INNER JOIN road_square
        ON squares.id = road_square.square_id
        WHERE road_square.road_id = roads.id
    ) AS squares
    FROM roads
    WHERE city_id = "'.$_GET['key'].'"
    ORDER BY name';
$result = mysqli_query($connect, $query);

while($road = mysqli_fetch_assoc($result))
{
    $prompt .= $road['name'].' is at '.round($road['cars']/$road['squares']*100).'% capacity.'.chr(13);
}

$prompt .= '

Do not mention the size of the roads or the exact number of cars or percentages, just use this data to gauge which roads 
should be included in the report and if traffic is good or bad. The report does not need to include every 
street.

Here is some other optional information:

The city name is Smart City.
On Diagon Alley is Dagobah swamp.
The Daily Bugle is on the corner of Second Ave and 39th Street.
The Sanctum Sanctorum is on Blecker Street Street.

Lifting bridge on 39th Avenue is up and no traffic can get through.
The train gate on Eriador Street is down and a train is passing through. 

Please include at least three of the above details in the report. 

';