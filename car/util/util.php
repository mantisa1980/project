<?php

////////////////////////////////////////////////////////////////////////////
//////////////////////////// DB (with HTML ) utility //////////////////////////////////
////////////////////////////////////////////////////////////////////////////

// Table: output pure HTML of tabular data and click handlers (by outout some javascript code)
class Table
{
    private $row_data = NULL;
    private $header_names = NULL;
    private $header_display_names = NULL;
    private $hidden_fields = NULL;
    private $link_info_list = NULL;
    private $editable_fields = NULL;
    private $on_edit_finish_page = NULL;

    private $submit_handler = NULL; // page that receives json data

    public function __construct()
    {
        $this->row_data = array();
        $this->link_info_list = array();
    }

    public function clear()
    {
        //unset($this->row_data);
        //unset($this->header_names);
        //unset($this->header_display_names);
        //unset($this->hidden_fields);
        //unset($this->link_info_list);

        $this->row_data = array();
        $this->link_info_list = array();

        $this->header_names = NULL; // unset make them Undefined
        $this->header_display_names = NULL;
        $this->hidden_fields = NULL;
        $this->editable_fields = NULL;
        $this->on_edit_finish_page = NULL;
        $this->edit_button_display_name = NULL;

        $this->submit_handler = NULL;
    }
    // in php, arrays are assigned by copying . 
    // 
    public function setHeaderNames($header_array_data,$header_array_display)
    {
        if (count($header_array_data) != count($header_array_display) )
        {
            die("Invalid counts of header and display data for class Table!".count($header_array_data).",".count($header_array_display) );
        }
        //print "type=".gettype($header_array_data);
        if(gettype($header_array_data) != 'array')
        {
            die("Invalid header_array_data format!");
        }
        if(gettype($header_array_display) != 'array')
        {
            die("Invalid header_array_display format!");
        }

        $this->header_names = $header_array_data;
        $this->header_display_names = $header_array_display;
    }

    public function addRow($row_array_data)
    {
        if($this->header_names == NULL)
        {
            die("Header is not set for class Table!");
        }

        if(gettype($row_array_data) != 'array')
        {
            die("Invalid row format for class Table!");
        }

        if (count($this->header_names) != count($row_array_data) )
        {
            die("Invalid row data count for class Table!h=".count($this->header_names).",r=".count($row_array_data)  );
        }

        array_push($this->row_data, $row_array_data);
        //print_r ($this->row_data[0]);
    }

    public function addLinkInfo($path, $display_label, $alert_message=NULL)
    {
        array_push($this->link_info_list, [$path, $display_label,$alert_message]);
    }

    public function getHeaderNames()
    {
        return $this->header_names;
    }
    public function setHiddenFields($keys)
    {
        //print "type=".gettype($header_array_data);
        if(gettype($keys) != 'array')
        {
            die("Invalid keys format!");
        }
        $this->hidden_fields = $keys;
    }

    public function setEditableFields($keys, $handler, $button_edit_name )
    {
        $this->editable_fields = $keys;
        $this->on_edit_finish_page = $handler;
        $this->edit_button_display_name = $button_edit_name;
    }

    // 盡量不要editable跟 有click_handler的混用...
    // submit的table只用submit button不要在Table右邊再用button click hand;er
    // 雖然功能上應該是沒差.
    // not implemented yet . post whole table as json
    public function addSubmitWholeTableButton($submit_handler)  // 可搭配set editable fields使用,把table以json post出去
    {
        $this->submit_handler = submit_handler;
    }

    // old : link to handler page by GET parameters
    /*
    public function outputHTML()
    {
        echo "<Table>";

        // output header 
        foreach ($this->header_display_names as $i)
        {
            echo "<th>".$i."</th>";
        }

        // output content 
        $header_counter=0;
        $tr_counter=0;
        //foreach ($this->header_names as $i)
        foreach ($this->row_data as $row)
        {
            echo "<tr>";
            echo '<tr id="'.$tr_counter.'">'; // can be used for submit table by wrapping table as json
            $tr_counter+=1;
            $header_counter=0;
            foreach ($row as $cell)
            {
                echo "<td name=".$this->header_names[$header_counter].">";
                echo $cell;  // content 
                echo "</td>";
                $header_counter+=1;
            }

            // add hyperlink if exist any ... before ending tr tag
            
            foreach($this->link_info_list as $link_data)
            {
                $anchor="<a href=".$link_data[0]."?" ;
                
                for ($j = 0; $j < count($this->header_names); $j++) 
                {
                    $param = $this->header_names[$j];
                    //$value = $row[$j];
                    $value = rawurlencode($row[$j]);  // handle special character problem ;
                    
                    if($j  < ( count($this->header_names)-1) ) // not last key
                    {
                        $anchor=$anchor.$param."=".$value."&";
                    }
                    else
                    {
                        $anchor=$anchor.$param."=".$value.">".$link_data[1]."</a>" ;
                    }
                }
                echo "<td>".$anchor."</td>";
            }
            echo "</tr>";
        }
        echo "</Table>";
    }
    */

    public function outputHTML()
    {
        echo "<Table>";

        // output header 

        for ($j = 0; $j < count($this->header_names); $j++) 
        {
            if ( $this->hidden_fields!=NULL && in_array($this->header_names[$j], $this->hidden_fields) )
            {
                continue;
            }
            else
            {
                echo "<th>".$this->header_display_names[$j]."</th>";
            }
        }

        // output content 
        $tr_counter=0;
        foreach ($this->row_data as $row)
        {
            echo '<tr id="'.$tr_counter.'">'; // can be used for submit table by wrapping table as json
            $tr_counter+=1;
            for ($j = 0; $j < count($row); $j++) 
            {
                if ( $this->hidden_fields!=NULL && in_array($this->header_names[$j], $this->hidden_fields) )
                {
                    echo '<input type="hidden" class="hidden_key" name="'.$this->header_names[$j].'" value="'.$row[$j].'">';
                }
                else
                {
                    if($this->editable_fields!=NULL && in_array($this->header_names[$j],$this->editable_fields ) )
                    {
                        echo '<td name="'.$this->header_names[$j].'" class="editable_text">';
                        //echo '<input type="text" value="'.$row[$j].'">'; // depreciated, 若有大量submit需求再來用..   
                        echo $row[$j];  // content
                    }
                    else
                    {
                        echo '<td name="'.$this->header_names[$j].'" class="readonly_text">';
                        echo $row[$j];  // content
                    }
                    echo "</td>";
                }
            }
            
            $has_link = false;

            if ( $this->editable_fields != NULL )
            {
                echo '<td><input type="button" class="modify_button" name="'.$this->on_edit_finish_page.'" value="'.$this->edit_button_display_name.'" onClick="on_table_util_modify_click(this)"></td>';
            }
            
            // output click buttons
            foreach($this->link_info_list as $link_data)
            {
                if($has_link == false)
                {
                    $has_link = true;    
                }
                if ($link_data[2] == NULL )
                {
                    echo '<td><input type="button" name="'.$link_data[0].'" value="'.$link_data[1].'" onClick="on_table_util_sendout_click(this)"></td>';
                }
                else  // buttons with confirm alert 
                {
                    echo '<td><input type="button" name="'.$link_data[0].'" value="'.$link_data[1].'" onClick="on_table_util_alert_click(this,\''.$link_data[2].'\')"></td>';
                }  
            }
            echo "</tr>";
        }
        echo "</Table>";

        // output click handler javascript 
        if($has_link || $this->editable_fields != NULL )
        {
            $js_src = file_get_contents("../js/table_util_row_click_handler.js"); // read js file as string
            echo $js_src;
        }
    }
}

class PagingUtility
{
    private $url;
    private $previous;
    private $next;
    private $maxPageNo;
    private $query_str;

    public function __construct($url,$query_str,$maxPageNo)
    {
        $this->url = $url;
        $this->query_str = $query_str;
        $this->maxPageNo = $maxPageNo;
        $previous = -1;
        $next = -1;
    }

    public function setCurrentPageNo($pageNo)
    {
        $this->setPreviousPage($pageNo-1);
        $this->setNextPage($pageNo+1);
    }

    private function setPreviousPage($pageNo)
    {
        if($pageNo >= 0 && $pageNo < $this->maxPageNo)
        {
            $this->previous = $pageNo;
        }
        else
        {
            $this->previous = -1;
        }
    }

    private function setNextPage($pageNo)
    {
        if($pageNo > 0 && $pageNo <= $this->maxPageNo )
        {
            $this->next = $pageNo;
        }
        else
        {
            $this->next = -1;
        }
    }

    public function outputHTML()
    {
        if($this->previous >= 0)
        {
            echo '<a href="'.$this->url."?".$this->query_str.'='. $this->previous.'">Previous Page:'.$this->previous.'</a>';
            //print "last=".$this->previous;
        }
        if($this->next > 0)
        {
            echo ' <a href="'.$this->url."?".$this->query_str.'='. $this->next.'">Next Page:'.$this->next.'</a>';
            //print "next=".$this->next;
        }
    }
}

// input : (select) query , return data rows as array 
class DBUtility
{
    private $result;
    private $limitOffset;
    private $limitCount;
    private $nonLimitCount;
    


    public function __construct($database_host, $username, $password,$database_name)
    {
        $this->database_host = $database_host;
        $this->username = $username;
        $this->password = $password;
        $this->database_name = $database_name;
        //$this->result = array();
        $this->limitOffset = NULL;
        $this->limitCount  = NULL;
        $this->nonLimitCount = 0;
    }

    private function connectDatabase()
    {
        $connection = mysqli_connect($this->database_host, $this->username, $this->password,$this->database_name);
        if (!$connection) 
        {
            echo "DB connection error, Code:".mysqli_connect_errno()."<br>";
            echo "DB connection error, Msg:".mysqli_connect_error()."<br>";
            die(mysqli_connect_error());
        }

        @mysqli_query($connection, 'set names utf8');  // set UTF-8 as DB communication encoding
        
        return $connection;
    }

    public function clear()
    {
        $this->result = NULL;
        $this->limitOffset = NULL;
        $this->limitCount  = NULL;
        $this->nonLimitCount = 0 ; // total count of query without limit: for paging
    }

    public function getLastQueryData()
    {
        return $this->result;
    }
    public function getLimitRowCount()
    {
        return count($this->result);
    }
    public function getTotalLimitRowCount() // ignore limit criteria
    {
        return $this->nonLimitCount;
    }

    public function getQueryData($query)
    {
        // row_count : count non-limited
        $conn = $this->connectDatabase();
        $limitFlag = false;

        // have limit setting
        if ( ($this->limitOffset!= NULL || $this->limitOffset==0) && $this->limitCount!= NULL)
        {
            // get total query count for paging 
            $limitFlag = true;
            $c = mysqli_query($conn,$query);
            $r = mysqli_num_rows($c);
            if ($r=="")
            {
                $this->nonLimitCount = 0;
            }
            else
            {
                $this->nonLimitCount = $r;
            }
            mysqli_free_result($c);
            //echo "total=".$this->nonLimitCount;

            //append limit criteria to query 
            $query = $query." limit ".$this->limitOffset.",".$this->limitCount;
            //echo "query=".$query;
        }

        $this->result = array();
        $cursor = mysqli_query($conn,$query);
        if(!$cursor)
        {
            die("[getQueryData] mysqli_query fail!");
        }
        
        while( ($i=mysqli_fetch_array($cursor) ) )
        {
            array_push($this->result,$i);
        }
        mysqli_free_result($cursor);
        mysqli_close($conn);

        if($limitFlag == false)
        {
            $this->nonLimitCount = count($this->result);
        }
        return $this->result;
    }

    public function setLimit($limitOffset,$limitCount)
    {
        $this->limitOffset = $limitOffset;
        $this->limitCount  = $limitCount;
    }
}

// input : 1. set column keys . 2 . add rows. 3. output Table with select query 
class DBTableUtility
{
    private $table = NULL;
    private $db_utility = NULL;

    public function __construct($database_host, $username, $password,$database_name)
    {
        $this->table = new Table();
        $this->db_utility = new DBUtility($database_host, $username, $password,$database_name);
    }

    public function getLastQueryData()
    {
        return $this->db_utility->getLastQueryData();
    }

    public function getTotalLimitRowCount()
    {
        return $this->db_utility->getTotalLimitRowCount();
    }

    public function clear()
    {
        $this->table->clear();
        $this->db_utility->clear();
    }
    // note: query選出的欄位數要跟setColumnFields給的欄位一樣數目
    public function outputSelectQuery($query)  //output SELECT * FROM  ... query.
    {
        $result =  $this->db_utility->getQueryData($query);

        if( count($result) <=0 )
        {
            return;
        }
        
        $key_list = $this->table->getHeaderNames();
        foreach ($result as $i )
        {
           $tmp = [];
           foreach($key_list as $key)
           {
               array_push($tmp,$i[$key]);  // push row element as an array ( required by Table object)
                //echo "row data".$i[$key]."<br>";
           }
           $this->table->addRow($tmp);
        }
        $this->table->outputHTML();
    }

    // control Table

    // set field keys ; note : this should match the fields that select query matches
    public function setColumnFields($header_array_data,$header_array_display)
    {
        $this->table->setHeaderNames($header_array_data,$header_array_display);
    }

    public function addRow($row_array_data)
    {
        $this->table->addRow($row_array_data);
    }

    public function addLinkInfo($path, $display_label, $alert_message=NULL)
    {
        $this->table->addLinkInfo($path, $display_label, $alert_message);
    }

    public function setHiddenFields($keys)
    {
        $this->table->setHiddenFields($keys);
    }

    public function setEditableFields($keys, $handler, $button_edit_name="編輯" )
    {
        $this->table->setEditableFields($keys,$handler,$button_edit_name);
    }

    public function setPaging($dataPerPage,$pageNo) // restrict display rows using mysql limit . pageNo begins from 0
    {
        $this->db_utility->setLimit($dataPerPage*$pageNo, $dataPerPage);
    }

    private function connect_database()
    {
        $connection = mysqli_connect($this->database_host, $this->username, $this->password,$this->database_name);
        if (!$connection) 
        {
            echo "DB connection error, Code:".mysqli_connect_errno()."<br>";
            echo "DB connection error, Msg:".mysqli_connect_error()."<br>";
            die(mysqli_connect_error());
        }

        @mysqli_query($connection, 'set names utf8');  // set UTF-8 as DB communication encoding
        
        return $connection;
    }
}

class FormInputUtility
{
    private $br = NULL;
    public function __construct()
    {
        $this->br = "<br>";
    }

    public function setAutoBr($is_on)
    {
        if($is_on==true)
        {
            $this->br = "<br>";
        }
        else
        {
            $this->br = "";
        }
    }

    public function beginForm($action)
    {
        echo "<form method=\"post\" action=\"".$action."\">";
    }

    public function addHiddenInput($key,$value)
    {
        echo "<input name=\"".$key."\" type=\"hidden\" value=\"".$value."\" >";
    }

    public function addInputText($key,$display,$value=NULL)
    {
        echo $display.$this->br;
        echo "<input name=\"".$key."\" type=\"text\" value=\"".$value."\"  >".$this->br.$this->br;
    }

    public function addTextArea($key,$display,$value=NULL)
    {
        echo $display.$this->br;
        echo "<textarea name=\"".$key."\" value=\"".$value."\" rows=\"4\" cols=\"100\">".$value."</textarea>".$this->br.$this->br;
    }

    public function addSelection($key, $display, $option_keys, $option_values, $default_selected_index=0)
    {
        if ( count($option_keys) != count($option_values) )
        {
            die("Error addSelection arguments!");
        }

        echo $display.$this->br;
        echo '<select name="'.$key.'">';
        $counter=0;

        for ($i = 0; $i < count($option_keys); $i++) 
        {
            if($i == $default_selected_index )
            {
                echo '<option value="'.$option_keys[$i].'" selected="selected">';
            }
            else
            {
                echo '<option value="'.$option_keys[$i].'">';
            }
            echo $option_values[$i];
            echo '</option>';
        }
        echo '</select>'.$this->br.$this->br ;
    }

    public function addSubmitButton($button_display="送出")
    {
        echo $this->br.'<input type="submit" value="'.$button_display.'" style="height: 20px; width: 100px" >';
    }

    public function endForm()
    {
        echo "</form>";
    }
}

function connectCarDB() {
    $link = mysqli_connect(DEF_DATABASE_HOST, DEF_USER_NAME, DEF_PASSWORD,DEF_DATABASE_NAME);
    if (!$link) {
        //die(mysqli_connect_error());
        echo "Error Code:".mysqli_connect_errno()."<br>";
        echo "Error Msg:".mysqli_connect_error()."<br>";
    }
    @mysqli_query($link, 'set names utf8');
    return $link;
}

function connectDB($host, $user, $pwd, $dbname) {
    $link = @mysqli_connect($host, $user, $pwd,$dbname);
    //echo "1111".$r."<br>";
    if (!$link) {
        die(mysqli_connect_error());
        //echo "Error Code:".mysqli_connect_errno()."<br>";
        //echo "Error Msg:".mysqli_connect_error()."<br>";
    }
    return $link;
}

function setConnLang($link, $lang)
{
    @mysqli_query($link, 'set names '.$lang);
}

function useDB($link, $dbname){
    if ($link){
        if ( !mysqli_select_db($link, $dbname) ){
            die("use DB error!".$dbname);
        }
        //echo "Change DB OK";
    }
    else
    {
       die("Invalid connection argument");
    }
}

function getQueryCount($cursor) {
    $r = mysqli_num_rows($cursor);
    if ($r=="") {
        return 0;
    }
    return $r;
}

function closeDB($link) {
    return mysqli_close($link);
}

function queryDB($link,$sql){
    return mysqli_query($link,$sql);
}

function outputTableRowWithFetchArray($cursor, $key_list ) {
    outputTableHeader($key_list);
    while( ($i=mysqli_fetch_array($cursor) ) )
    {
        echo "<tr>";
        for ($j = 0; $j < count($key_list); $j++) {
            echo "<td>";
            $key = $key_list[$j];
            echo $i[$key];
            echo "</td>";
        }
        echo "</tr>";
    }
   
    mysqli_free_result($cursor);
}
function outputTableWithModifyButton($cursor, $key_list ) {
    outputTableHeader($key_list);
    while( ($i=mysqli_fetch_array($cursor) ) )
    {
        echo "<tr>";
        for ($j = 0; $j < count($key_list); $j++) {
            echo "<td>";
            $key = $key_list[$j];
            echo $i[$key];
            echo "</td>";
        }
        //echo "<td><form name=\"form\"><input id=\"edit\" type=\"submit\" name=\"edit\" value=\"Edit\" /></form></td>";
        //echo "<td><form name=form><input id=edit type=submit name=edit value=Edit /></form></td>";
        echo "<td><input type=submit value=Edit onClick=on_click_update /></td>";
        echo "</tr>";
    }
    mysqli_free_result($cursor);
}

function outputTableWithAnchor($cursor, $key_list , $modify_page="", $delete_page="" ) {
    outputTableHeader($key_list);
    while( ($i=mysqli_fetch_array($cursor) ) )
    {
        $modify_anchor="<a href=".$modify_page."?" ;
        $delete_anchor="<a href=".$delete_page."?" ;
        
        echo "<tr>";
        for ($j = 0; $j < count($key_list); $j++) {
            $key = $key_list[$j];  // ex. email key
            echo "<td name=".$key.">";
            echo $i[$key];  // ex. email's content 
            echo "</td>";
            $modify_anchor=$modify_anchor.$key."=".$i[$key];
            $delete_anchor=$delete_anchor.$key."=".$i[$key];
            
            if($j  < ( count($key_list)-1) ) // not last key
            {
                $modify_anchor=$modify_anchor."&";
                $delete_anchor=$delete_anchor."&";
            }
            else
            {
                $modify_anchor=$modify_anchor.">修改</a>"; // end tag
                $delete_anchor=$delete_anchor.">刪除</a>"; // end tag
            }
        }
        if( $modify_page!= "")
        {
            echo "<td>".$modify_anchor."</td>";
        }
         if( $delete_page!= "")
        {
            echo "<td>".$delete_anchor."</td>";
        }
        
        echo "</tr>";
    }
    mysqli_free_result($cursor);
}

////////////////////////////////////////////////////////////////////////////
//////////////////////////// HTML utility //////////////////////////////////
////////////////////////////////////////////////////////////////////////////



function outputRedirect($url, $seconds)
{
    echo "<meta http-equiv=\"refresh\" content=\"".$seconds."; url=".$url."  \" />";
}

function outputTableHeader($key_list) {
     foreach ($key_list as $i)
     {
         echo "<th>".$i."</th>";
     }
}

function outputInputTextFormByTableRow($primary_key_list, $key_list , $key_name, $value_list , $submit_page="")
{
    //<input type ="text" value="123">
    echo "<form method=\"post\" action=\"".$submit_page."\">";
    echo "<h3>";
    for ($j = 0; $j < count($key_list); $j++) 
    {
        if ( in_array($key_list[$j], $primary_key_list) )  // primary keys not editable and not visible
        {
            //echo $value_list[$j]."<br>";
            //echo "<input name=\"".$key_list[$j]."\" type=\"text\" value=\"".$value_list[$j]."\" size= 32 readonly><br>";
            echo "<input name=\"".$key_list[$j]."\" type=\"hidden\" value=\"".$value_list[$j]."\" >";
        }
        else
        {
            echo $key_name[$j].":<br>";
            echo "<input name=\"".$key_list[$j]."\" type=\"text\" value=\"".$value_list[$j]."\" size= 32 ><br>";
            echo "<br>";
        }
    }
    echo "</h3>";
    echo "<input type=\"submit\" value=\"送出\">";
    echo "</form>";
}

?>

