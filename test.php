<?php

class testing{
  public function fish(){
    echo "hello fish";
  }
}

$test = new testing();
$call = "test->fish";
$$call();