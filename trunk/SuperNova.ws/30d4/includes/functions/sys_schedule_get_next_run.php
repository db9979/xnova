<?php

// format: d@<time>

// format: [<m|w|d|h|m|s>@]<time>
// first param: m - monthly, w - weekly, d - daily, h - hourly, m - minutly, s - secondly
// second param: [<months>-[<days|weeks> [<hours>:[<minutes>:]]]<seconds>
//        valid: '10' - runtime every 10 s
//        valid: '05:' or '05:00' - runtime every 5 m
//        valid: '02::' or '02:00:' or '02:00:00' - runtime every 2 h
//        etc
// ToDo: m, w, d

function SYS_scheduleGetNextRun($scheduleList, $lastRun = 0, $timeNow = 0, $runMissed = true){
  $dtf = 'Y-m-d H:i:s';
//  $dtf = 'd H:i:s';

//pdump($scheduleList);
//pdump(date($dtf, $timeNow), 'timeNow');
//pdump(date($dtf, $lastRun), 'lastRun');
//pdump($runMissed, 'runMissed');
  $lastRun = $lastRun ? $lastRun : 0;

  $dateFields = array( 'seconds', 'minutes', 'hours', 'mday', 'mon', 'year' );

  // If no $timeNow defined - using current time
  if(!$timeNow) $timeNow = time();

  // $lastRun should be always not greater then $timeNow!
  if($lastRun>$timeNow)
    $lastRun = $timeNow - 1;

  // Parsing shedule list
  $schedules = explode(',', $scheduleList);
  foreach($schedules as $schIndex => $schedule){
    // Parsing specific schedule
    $thisSchedule = explode('@', $schedule);

    // If no @-sign - it means 'once per day' i.e. 'd'
    if(count($thisSchedule) == 1)
      array_unshift($thisSchedule, 'd');

    // Calculating schedule interval in seconds
    switch($thisSchedule[0]){
      case 'd':
        $scheduledInterval = 24*60*60;
        break;
    }
    if(!$lastRun) $lastRun = $timeNow - 2*$scheduledInterval;

    // Checking - if current schedule correct
    if(preg_match(SCHEDULER_PREG,$thisSchedule[1],$matches)){
      $matches = array_reverse($matches);

      //parsing $lastRun
      $last = getdate($lastRun);

      // Applying schedule to parsed $lastRun
      for($i=0; $i<6; $i++)
        if($matches[$i] != '')
          $last[$dateFields[$i]] = $matches[$i];
      // Making new date with correct schedule
      $lastRun = mktime( $last['hours'], $last['minutes'], $last['seconds'], $last['mon'], $last['mday'], $last['year']);
      // Calculating previous schedule time
      $lastRun += $scheduledInterval * floor(($timeNow - $lastRun)/$scheduledInterval);

      if(!$nextRun)
        $nextRun = $lastRun + $scheduledInterval * intval(!$runMissed);

      if(($runMissed && $lastRun>$nextRun && $lastRun<=$timeNow)||(!$runMissed && $lastRun<$nextRun && $lastRun>=$timeNow))
          $nextRun = $lastRun;

    };
  }

  return($nextRun);
}

?>
