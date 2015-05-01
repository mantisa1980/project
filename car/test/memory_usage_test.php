<?php
ini_set('display_errors','On');

class foo
{
    private $_var;

    public function __construct()
    {
      $this->_var = array();
      for($i = 0; $i < 1000000; $i++)
      {
           $this->_var[rand(1, 10000)] = 'I am string '.$i.' in the array';
      }
    }

      public function myGC1() // 有幫助, 只是Test物件回收後一樣會消失
      {
        $this->_var = null;
      }

      public function myGC2()  // 有幫助, 只是Test物件回收後一樣會消失
      {
        unset($this->_var);
      }

    //public function __destruct()
    //{
        //$this->_var = null;
    //}
}


echo 'before: '.memory_get_usage().'</br>';
$Test = new foo();
echo 'after class instance: '.memory_get_usage().'</br>';

$Test->myGC1();
echo 'after set null of _var: '.memory_get_usage().'</br>';

$Test->myGC2();
echo 'after unset of _var: '.memory_get_usage().'</br>';
$Test = NULL;
echo 'after SET TEST AS NULL: '.memory_get_usage().'</br>';

?>

