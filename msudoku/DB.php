<?

// Database abstraction class

class DB
{
    /*## Database Variables ##*/
    /*## ------------------ ##*/
    var $DBhost = "127.0.0.1";
    var $DBuser = "[obfuscated]";
    var $DBpass = "[obfuscated]";
    var $DBname = "sudoku";
    var $DBtype = "mysql";
    var $DBdebug = false;
    /*## ------------------ ##*/
    /*## DON'T CHANGE BELOW ##*/

    var $totalQueries = 0;

    function __construct()
    {
        //## Connect to Server ##
        $this->dbh = mysql_connect($this->DBhost, $this->DBuser, $this->DBpass);
        mysql_select_db($this->DBname, $this->dbh);
        $this->dbgtxt = '';
    }

    function __destruct()
    {
        mysql_close($this->dbh);
    }

    // most normal queries would use this one
    function simpleQuery ($table,$fields,$where = "",$extra = "")
    {

        if($where) $where = "WHERE ".$where;

        if ($fields == "*" || $fields == ""){
            $fieldsArray = $this->getFields($table);
            $fields = implode(",",$fieldsArray);
        }

        $query = "SELECT $fields FROM $table $where $extra";
        $this->dbgtxt .= $query."\n";
        $dh = mysql_query($query, $this->dbh);
        $data = array();
        if(is_resource($dh)){
            while($datal = mysql_fetch_assoc($dh)){
                $data[] = $datal;
            }
            mysql_free_result($dh);
        }
        $this->totalQueries++;

        // let's make sure that we have data to return, or else return false
        if(count($data) > 0) {
            return $data;
        } else {
            return false;
        }
    }

    function fullQuery($query){
        $this->dbgtxt .= $query."\n";
        $dh = mysql_query($query, $this->dbh);
        $data = array();
        if(is_resource($dh)){
            while($datal = mysql_fetch_assoc($dh)){
                $data[] = $datal;
            }
            mysql_free_result($dh);
        }
        $this->totalQueries++;

        // let's make sure that we have data to return, or else return false
        if(count($data) > 0) {
            return $data;
        } else {
            return false;
        }
    }

    // normal insert
    function dbWrite($table,$pairs,$extra = "")
    {
        $nPairs = count($pairs);
        $keys = '';
        $values = '';
        for ($i=0;$i<$nPairs;$i++)
        {
            $keys .= "`".key($pairs)."`";
            $values .= "'".$this->escape($pairs[key($pairs)])."'";
            if ($i<($nPairs -1)) { $keys .= ","; $values .= ","; }
            next($pairs);
        }

        $query = "INSERT INTO $table ($keys) VALUES ($values) $extra";
        $this->dbgtxt .= $query."\n";
        mysql_query($query,$this->dbh);
        $this->totalQueries++;
        return mysql_insert_id($this->dbh);
    }

    // more data
    function dbBatchWrite($table,$arrs,$extra = "")
    {
        $numr = count($arrs);
        $i=0;
        foreach($arrs as $pairs){
            if($i==0){
                $i++;
                $keys = "`".implode('`,`',array_keys($pairs))."`";
                $values = "(";
            }else{
                $values.=",(";
            }
            foreach($keys as $aky){
                $values .= "'".$pairs[$aky]."'";
            }
            $values.=")";
        }

        $query = "INSERT INTO $table ($keys) VALUES $values $extra";
        $this->dbgtxt .= $query."\n";
        mysql_query($query,$this->dbh);
        $this->totalQueries++;
        return mysql_insert_id($this->dbh);
    }

    function dbReplace($table,$pairs,$where)
    {
        if($where) $where = "WHERE ".$where;

        $keys = '';
        $values = '';
        $nPairs = count($pairs);
        for ($i=0;$i<$nPairs;$i++)
        {
            $keys .= "`".key($pairs)."`";
            $values .= "'".$pairs[key($pairs)]."'";
            if ($i<($nPairs -1)) { $keys .= ","; $values .= ","; }
            next($pairs);
        }

        $query = "REPLACE INTO $table ($keys) VALUES ($values) $where";
        $this->dbgtxt .= $query."\n";
        mysql_query($query,$this->dbh);
        $this->totalQueries++;
        return mysql_insert_id($this->dbh);
    }

    // this function does a INSERT... SELECT - it also works a lil bit differently than the other funcs
    //function dbInsertSelect($insTable,$insFields,$selTable,$selFields,$selWhere,$selExtra)
    function dbInsertSelect($data)
    {
        if($data['selWhere']) $data['selWhere'] = "WHERE ".$data['selWhere'];

        if ($data['insFields'] == "*" || $data['insFields'] == ""){
            $data['insFieldsArray'] = $this->getFields($data['insTable']);
            $data['insFields'] = implode(",",$data['insFieldsArray']);
        }

        if ($data['selFields'] == "*" || $data['selFields'] == ""){
            $data['selFieldsArray'] = $this->getFields($data['selTable']);
            $data['selFields'] = implode(",",$data['selFieldsArray']);
        }

        $query = "INSERT INTO ".$data['insTable']." (".$data['insFields'].") SELECT ".$data['selFields']." FROM ".$data['selTable']." ".$data['selWhere']." ".$data['selExtra'];
        $this->dbgtxt .= $query."\n";
        mysql_query($query,$this->dbh);
        $this->totalQueries++;
        $ar = mysql_affected_rows($this->dbh);
        if($ar >= 1) return $ar;
        else return false;
    }

    // normal update
    function dbUpdate($table,$pairs,$where = "",$type = "")
    {
        if($where) $where = "WHERE ".$where;

        $update = '';
        // let's check to see whether or not the pairs var is an array
        if(is_array($pairs)) {
            $nPairs = count($pairs);
            for ($i=0;$i<$nPairs;$i++)
            {
                if(!$type) $update .= "`".key($pairs)."`='".$this->escape($pairs[key($pairs)])."'";
                else $update .= "`".key($pairs)."`=".$this->escape($pairs[key($pairs)]);
                if ($i<($nPairs -1)) $update .= ",";
                next($pairs);
            }
        } else $update = $pairs;

        $query = "UPDATE $table SET $update $where";
        $this->dbgtxt .= $query."\n";
        mysql_query($query,$this->dbh);
        $this->totalQueries++;
        $ar = mysql_affected_rows($this->dbh);
        if($ar >= 1) return $ar;
        else return false;
    }

    function delete($table,$where,$extra = "")
    {
        $query = "DELETE FROM $table WHERE $where $extra";
        $this->dbgtxt .= $query."\n";
        mysql_query($query,$this->dbh);
        $this->totalQueries++;
        $ar = mysql_affected_rows($this->dbh);
        if($ar >= 1) return $ar;
        else return false;
    }

    function getFields($ftable)
    {
        $fquery = "SHOW COLUMNS FROM $ftable";
        $fdh = mysql_query($fquery,$this->dbh);
        $retfields = array();
        while($fdt = mysql_fetch_assoc($fdh)){
            $retfields[] = $fdt['Field'];
        }
        mysql_free_result($fdh);
        return $retfields;
    }
    
    function escape($ips)
    {
        return mysql_real_escape_string($ips,$this->dbh);
    }
}
?>
