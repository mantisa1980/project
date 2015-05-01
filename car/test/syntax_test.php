<?php
require_once "../util/util.php";
require_once "../config/html_header_common.php";
ini_set('display_errors','On');
class Foo 
{
    private $AAA = 3;
    function __construct($v)
    {
        echo "construct Foo". $v."<br>";
        echo("this->AAA=".$this->AAA);
        $this->AAA = array();
    }
    //function __destruct()
    //{
    //    echo "destruct Foo";
    //}
    function clear()
    {
        unset($this->AAA);
        echo("this->AAA clear=".$this->AAA);
        $this->AAA = array();
    }
}

function do_test()
{
    /*
    $a = NULL;
    $b = "";
    
    echo empty($a)."<br>";  // only output thing if 1 (true); output nothing if false
    echo empty($b)."<br>";

    $c = [[1,2],[3,4] ];
    echo $c;
    echo $c[0];
    echo $c[0][0]."<br>";
    echo $c[0][1];

    $f = new Foo(1);

    $stack = array("orange", new Foo(1));
    array_push($stack, "apple", "raspberry");
    print_r("s0=".$stack."<br>");
    unset($stack);
    print_r("s0=".$stack."<br>");
    if($stack == NULL)
    {
        print_r("s0 is null");
    }
    */
    $f = new Foo(1);
    $f->clear();

}

do_test();


?>
