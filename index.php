<?php

class  Task {
    private $filename;
    private $operation;
    public $array_positive;
    public $array_negative;

    public function __construct($filename,$operation)
    {
        $this->filename = $filename;
        $this->operation = $operation;
    }

    public function workWithFile()
    {
        $fd = fopen($this->filename, 'r') or die("не удалось открыть файл");
        $count = count(file($this->filename));
        for ($i = 0; $i < $count; $i++) {
            $str[] = htmlentities(fgets($fd));
            $str[$i] = explode(' ', $str[$i]);
            $array_result[] =$this->isOperationTypeCheck($str[$i][0],$str[$i][1]);
            $this->isSignCheck($array_result[$i]);
        }
        fclose($fd);
        $this->createDataInFile('positive.txt',$this->array_positive);
        $this->createDataInFile('negative.txt',$this->array_negative);
    }

    public function isOperationTypeCheck($a,$b) {
        if ($this->operation=='-') {
            return $a-$b;
        }elseif($this->operation=='+'){
            return $a+$b;
        }elseif($this->operation=='/') {
            return $a/$b;
        }elseif($this->operation=='*') {
            return $a*$b;
        }else {
            die("Знак введен неправильно");
        }
    }

    public function isSignCheck ($parameter) {
        if ($parameter<0)
            $this->array_negative[] = $parameter;
        else
            $this->array_positive[] = $parameter;
    }

    public function createDataInFile($filename,$array) {
        if(!empty($array)){
        $txt = implode(';',$array);
        file_put_contents($filename,$txt);
        }else {
            $txt = '';
            file_put_contents($filename,$txt);
        }
    }
}

$result = new Task($argv[1],$argv[2]);
$result->workWithFile();
?>