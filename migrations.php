<?php
include_once('class/database.php');
$migrations = [
    // 2022-08-09
//    'alter table photos add room_number varchar(30) default "" null',
//    'alter table photos add image_watermark varchar(255) null',
//    'update photos set image_watermark = null',
];

foreach ($migrations as $migration){
    database::query($migration);
}
