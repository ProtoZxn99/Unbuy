<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of enigma_c
 *
 * @author Patrick
 */
class enigma_c {
    //put your code here
    public function enigma($pass, $repetition) {
        
        $prime = 927265122523;
        $prime2 = 916245448571;
        $saltnumber = 53521854928943965007199254740991;
        
        $source = $pass;
        
        $source2 = 15;
        $source3 = 5;
        $source4 = 25;
        $source5 = 11;
        $source6 = 29;
        
        $source3 += 33;
        $length = strlen($source);
        $source = base64_encode(sha1($source));
        $raw = str_split($source);
        $start = ($prime2*$length%113);
        if($start<33){
            $start+=47;
        }
        $serialized = array((int)$start);
        $result = (string) chr($source3);
        $saltmine = ($source5-1)*3;
        $salt = (int) substr((string) $saltnumber, $saltmine, 3);
        foreach ($raw as $data) {
            $data = abs((pow(ord($data)-96,2))*$prime%126);
            $counter = $source5;
            array_push($serialized, $data); 
            if($data<$source2){
                while($data<$source2 && $counter<$source6){
                    $data = abs(pow(($data+$counter),$length-1)%101);
                    $counter++;
                    $salt = abs(($salt * $counter)%67+59);
                    array_push($serialized, $salt);
                }
                array_push($serialized, $counter);
                if($counter<$source5){
                    array_push($serialized, $data); 
                }
            }
        }
        for($i = count($serialized)-1; $i>0; $i--){
            if((strlen($serialized[$i]))<2){
                $serialized[$i-1]= $serialized[$i-1].$serialized[$i];
                $serialized[$i] = (string)((((int)$serialized[$i])+$source4)%84+42);
            }
            if(($serialized[$i]<33)){
                $serialized[$i] = (string)((int)$serialized[$i]+33);
            }
            $result = (string) $result . chr($serialized[$i]);
        }
        $count_c = 0;
        $result = str_replace("c", "", $result, $count_c);
        while($count_c<33 || $count_c>126){
            $count_c = pow($count_c,9)*11%126;
        }
        $result = substr($result, 0,1) . substr($result, 2, 5) . chr($count_c) . substr($result,7);
        $result = base64_encode($result);
        
        $target = strlen($result);
        if($target>47){
            $target = $target-45;
            $target = $this->nearestprimenumber($target);
            $result = substr($result, $target, 45);
        }
        $symbolizer = str_split(substr($result, 10, 5));
        $symbolized = "";
        foreach ($symbolizer as $key) {
            if($key>99){
                $symbolized = $symbolized . chr(((ord($key))%65)+33);
            }
        }
        $result = substr($symbolized, 3, 10).$result;
        if($repetition){
            $result = base64_encode(sha1(base64_encode($result)));
            $this->enigma($result, false);
        }
        return substr($result,0,45);
    }
    
    private function nearestprimenumber($number){
        for($i = $number; $i>2; $i--){
            $counter = 0;
            for($j=$i; $j>0; $j--){
                if($i%$j==0){
                    $counter++;
                }
            }
            if($counter==2){
                return $i-1;
            }
        }
        return 1;
    }
}