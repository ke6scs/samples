<?
    require("DB.php");
    switch($_REQUEST['req']){
        case "ggd":
            if(empty($DB)) $DB = new DB;
            $uid = $DB->escape($_REQUEST['uid']);
//            error_log('AJAX - ggd: '.var_export($_REQUEST,true));
            $tmx = time();
            $drt = $DB->simpleQuery('users','fb_id','fb_id = '.$uid);
            if($drt){
                $DB->dbUpdate('users',array('last' => $tmx),'fb_id = '.$uid);
            }else{
                $DB->dbWrite('users',array('fb_id' => $uid,'first' => $tmx, 'last' => $tmx));
            }
            $ctd = $DB->fullQuery("SELECT COUNT(*) AS ct FROM puzzles p LEFT JOIN used u ON p.puzzle_id = u.puzzle_id AND u.user_id = $uid AND u.dsbl = 0 AND p.dsbl = 0 WHERE u.user_id IS NULL");
            $rn = rand(0,$ctd[0]['ct']-1);
            $gdd = $DB->fullQuery("SELECT p.puzzle_id,puzzle_data FROM puzzles p LEFT JOIN used u ON p.puzzle_id = u.puzzle_id AND u.user_id = $uid AND u.dsbl = 0 AND p.dsbl = 0 WHERE u.user_id IS NULL LIMIT $rn,1");
            echo $gdd[0]['puzzle_id'].'|'.$gdd[0]['puzzle_data'];
            break;
        case "ghs":
            if(empty($DB)) $DB = new DB;
            $uids = $DB->escape($_REQUEST['uids']);
            if(substr($uids,0,1) == ','){
                $uids = substr($uids,1);
            }
            $hsr = $DB->simpleQuery('scores','uid,MIN(score) as hsc','uid IN ('.$uids.')','GROUP BY uid ORDER BY uid,score');
            if($hsr){
                $rtr = array();
                foreach($hsr as $hs){
                    $rtr[] = $hs['uid'].','.$hs['hsc'];
                }
                echo implode('|',$rtr);
            }
            break;
        case "gls":
            if(empty($DB)) $DB = new DB;
            
            $uids = $DB->escape($_REQUEST['uids']);
            if(substr($uids,0,1) == ','){
                $uids = substr($uids,1);
            }
            $idr = $DB->simpleQuery('scores','MAX(score_id) as sid','uid IN ('.$uids.')','GROUP BY uid');
            if($idr){
                $sids = array();
                foreach($idr as $si){
                    $sids[] = $si['sid'];
                }
                $lsr = $DB->simpleQuery('scores','uid,score','score_id IN ('.implode(',',$sids).')',"");
                if($lsr){
                    $rtr = array();
                    foreach($lsr as $ls){
                        $rtr[] = $ls['uid'].','.$ls['score'];
                    }
                    echo implode('|',$rtr);
                }
            }
            break;
        case "asc":
            if(empty($DB)) $DB = new DB;
            $uid = $DB->escape($_REQUEST['uid']);
            $scr = intval($_REQUEST['scr']);
            $puz = intval($_REQUEST['puz']);
            $dbdt = array(
                'uid'   => $uid,
                'score' => $scr,
                'stamp' => time()
              );
            $DB->dbWrite('scores',$dbdt,"");
            $dbdt1 = array(
                'user_id'   => $uid,
                'puzzle_id' => $puz
              );
            $DB->dbWrite('used',$dbdt1,"");
            break;
        default:
            break;
    }
//            error_log("AJAX - dbdbug: \n" . $DB->dbgtxt);

//    echo "<pre>\n";
//    var_export($_REQUEST);
//    echo "\n".$uid;
//    echo "</pre>\n";
?>
