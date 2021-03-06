<?php

 /*
 Скрипт опознания денег
 Документация на http://api.yandex.ru/money/doc/dg/reference/notification-p2p-incoming.xml
 
 Сделал на http, хотя рекомендуют https
 */

 // Общие настройки
  include("settings.php");
  // Библиотека функций
  include("functions.php");

  //notification_type&operation_id&amount&currency&datetime&sender&codepro&notification_secret&label


   $PaymentSum = (double)$_POST['amount'];
   //$PaymentSum = $_POST['amount'];

	if (empty($PaymentSum))
	{
	print('ff');
        return;
	}

   
   $Sql = "insert into Payments (paymentsource_id, payment_sum) values (1, $PaymentSum)";
   $Result = MySqlQuery($Sql);
   mysql_free_result($Result);


    print('qqq');


/*
// Проверка, как именно используем скрипт: из интерфейса или отдельно
if (isset($MyPHPScript) and $action == 'JSON')
{
  if (!$Administrator) return;
  
  if (!isset($_REQUEST['RaidId'])) {$_REQUEST['RaidId'] = "";}
  $RaidId = $_REQUEST['RaidId'];

}
else 
{

  // Общие настройки
  include("settings.php");
  // Библиотека функций
  include("functions.php");

  // Первичная проверка данных авторизации
  if ($_GET['Login'] == "") 
  {
    print("Login is missing");
    return;

  } elseif ($_GET['Password']== "") {
    print("Password is missing");
    return;
  } 

  $RaidId = $_GET['RaidId'];

  // Аутентификация и авторизация -- проверка прав на получение дампа (администратор)
  $Sql = "select user_id, user_admin from Users where user_hide = 0 and trim(user_email) = trim('".$_GET['Login']."') and user_password = '".md5(trim($_GET['Password']))."'";
  $Result = MySqlQuery($Sql);  
  $Row = mysql_fetch_assoc($Result);

  if ($Row['user_id'] <= 0) 
  {
    print("Autenthication failed");
    return;  
  } 

  if ($Row['user_admin'] == 0)
  {
    print("Authorization failed");
    return;
  }

}
// Конец проверки, как именно используем скрипт: из интерфейса или отдельно


// Берём марш-бросок, который передан
// Если такого нет - берём последний
// Проверяем, что передали идентификатор ММБ


if (empty($RaidId))
{
  $sql = "select raid_id
 	  from Raids 
 	  order by raid_registrationenddate desc
	  LIMIT 0,1 ";

  $Result = MySqlQuery($sql);
  $Row = mysql_fetch_assoc($Result);
  $RaidId = $Row['raid_id'];
  mysql_free_result($Result);

}



// Сбор данных для дампа
$data = array();

// Raids: raid_id, raid_name, raid_registrationenddate
$Sql = "select raid_id, raid_name, raid_registrationenddate from Raids where raid_id = ".$RaidId;
$Result = MySqlQuery($Sql);
while ( ( $Row = mysql_fetch_assoc($Result) ) ) { $data["Raids"][] = $Row; }
mysql_free_result($Result);

// Distances: distance_id, raid_id, distance_name
$Sql = "select distance_id, raid_id, distance_name from Distances where raid_id = ".$RaidId;
$Result = MySqlQuery($Sql);
while ( ( $Row = mysql_fetch_assoc($Result) ) ) { $data["Distances"][] = $Row; }
mysql_free_result($Result);

// Levels: level_id, distance_id, level_name, level_order, level_starttype, level_pointnames, level_pointpenalties, level_begtime, level_maxbegtime, level_minendtime, level_endtime
$Sql = "select level_id, l.distance_id, level_name, level_order, level_starttype, level_pointnames, level_pointpenalties, level_begtime, level_maxbegtime, level_minendtime, level_endtime from Levels l inner join Distances d on l.distance_id = d.distance_id where d.raid_id = ".$RaidId;
$Result = MySqlQuery($Sql);
while ( ( $Row = mysql_fetch_assoc($Result) ) ) { $data["Levels"][] = $Row; }
mysql_free_result($Result);

// LevelPoints: levelpoint_id, level_id, pointtype_id
$Sql = "select levelpoint_id, lp.level_id, pointtype_id from LevelPoints lp inner join Levels l on lp.level_id = l.level_id  inner join Distances d on l.distance_id = d.distance_id where d.raid_id = ".$RaidId;
$Result = MySqlQuery($Sql);
while ( ( $Row = mysql_fetch_assoc($Result) ) ) { $data["LevelPoints"][] = $Row; }
mysql_free_result($Result);

// Teams: team_id, distance_id, team_name, team_num // *
$Sql = "select team_id, t.distance_id, team_name, team_num from Teams t inner join Distances d on t.distance_id = d.distance_id where t.team_hide = 0  and d.raid_id = ".$RaidId;
$Result = MySqlQuery($Sql);
while ( ( $Row = mysql_fetch_assoc($Result) ) ) { $data["Teams"][] = $Row; }
mysql_free_result($Result);

// Users: user_id, user_name, user_birthyear // *
$Sql = "select user_id, user_name, user_birthyear from Users where user_hide = 0";
$Result = MySqlQuery($Sql);
while ( ( $Row = mysql_fetch_assoc($Result) ) ) { $data["Users"][] = $Row; }
mysql_free_result($Result);

// TeamUsers: teamuser_id, team_id, user_id, teamuser_hide
$Sql = "select teamuser_id, tu.team_id, user_id, teamuser_hide from TeamUsers tu inner join Teams t on tu.team_id = t.team_id inner join Distances d on t.distance_id = d.distance_id where t.team_hide = 0  and d.raid_id = ".$RaidId;
$Result = MySqlQuery($Sql);
while ( ( $Row = mysql_fetch_assoc($Result) ) ) { $data["TeamUsers"][] = $Row; }
mysql_free_result($Result);

// TeamLevelDismiss: user_id, levelpoint_id, team_id, teamuser_id, teamleveldismiss_date, device_id
$Sql = "select user_id, levelpoint_id, tld.team_id, teamuser_id, teamleveldismiss_date, device_id from TeamLevelDismiss tld inner join Teams t on tld.team_id = t.team_id inner join Distances d on t.distance_id = d.distance_id where t.team_hide = 0  and d.raid_id = ".$RaidId;
$Result = MySqlQuery($Sql);
while ( ( $Row = mysql_fetch_assoc($Result) ) ) { $data["TeamLevelDismiss"][] = $Row; }
mysql_free_result($Result);

// TeamLevelPoints: user_id, levelpoint_id, team_id, teamlevelpoint_date, device_id, teamlevelpoint_datetime, teamlevelpoint_points, teamlevelpoint_comment
$Sql = "select user_id, levelpoint_id, tlp.team_id, teamlevelpoint_date, device_id, teamlevelpoint_datetime, teamlevelpoint_points, teamlevelpoint_comment from TeamLevelPoints tlp inner join Teams t on tlp.team_id = t.team_id inner join Distances d on t.distance_id = d.distance_id where t.team_hide = 0  and d.raid_id = ".$RaidId;
$Result = MySqlQuery($Sql);
while ( ( $Row = mysql_fetch_assoc($Result) ) ) { $data["TeamLevelPoints"][] = $Row; }
mysql_free_result($Result);

// Заголовки, чтобы скачивать можно было и на мобильных устройствах просто браузером (который не умеет делать Save as...)
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"update.json\"");

// Вывод json
print json_encode( $data );
*/
?>
