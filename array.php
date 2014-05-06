<?php

function makeArray($count = 10){
	for($i=0;$i < $count;$i++){
//		$arr[] = $i;
		$arr[] = $i * rand(1,15);
	}
	return $arr;
}


function printDashedLine($arr){
    foreach($arr as $key => $value){
            echo '------';
    }
    echo "\r\n";
}

function printArray(Array $arr,$title=''){
        printDashedLine($arr);
        echo "| $title";
        echo "\r\n";
        printDashedLine($arr);
	
	foreach($arr as $key => $value){
		echo '|';
		printNumber($key);
	}
	echo "| \r\n";

	foreach($arr as $key => $value){
		echo '|';
		printNumber($value);
	}
	echo "| \r\n";

	printDashedLine($arr);
        echo "\r\n";
}

function printNumber($num){
	$str = str_pad($num,5,' ');
	echo $str;
}


//Insertion Sort
function insertionSort(Array &$arr){
	$n = count($arr);
	for($i=1;$i <= $n-1; $i++){ //start at 1 instead of zero because the first element is already sorted
		//		echo $arr[$i] . PHP_EOL;
		insert($arr,$i,$arr[$i]);		
	}
	return;
}

function insert(&$arr, $pos, $value){

//	echo "pos: $pos value $value" . PHP_EOL;
	$i = $pos - 1;
	while($i>=0 and $arr[$i] > $value){
		$arr[$i+1] = $arr[$i];
		$i = $i-1;
//		echo 'while loop ' . "i: $i value: $value" .PHP_EOL;
	}
	$arr[$i+1] = $value;
	//printArray($arr);
	return;
}




//median sort

function findMedianIndex(Array $arr, $left_index=0, $right_index=0){
	//cheat to find median; sort() uses quicksort and sorts the friggin data.
	//TODO: use "median of medians" search.

	$original_arr = $arr;

	sort($arr);

	if($left_index == 0 && $right_index == 0){
		$max_index = count($arr) - 1;
		$mid_index = floor($max_index/2);
	} else {
		$mid_index = floor(($right_index - $left_index)/2) + $left_index;
	}

	$median_value = $arr[$mid_index];

	return array_search($median_value,$original_arr); //return the key in the original array that represents the median value
}


function medianSort(Array &$arr){
	$max_index = count($arr)-1;
	doMedianSort($arr,0,$max_index);
}

function doMedianSort(Array &$arr, $left_index, $right_index){
	if($left_index < $right_index){
		$median_index = findMedianIndex($arr, $left_index, $right_index);
		$mid_index = floor(($right_index+$left_index)/2);
		swap($arr,$mid_index,$median_index);
		echo "mid_index: $mid_index median_index: $median_index \r\n";

		for($i=$left_index; $i <= ($mid_index-1); $i++){
			if($arr[$i] > $arr[$mid_index]){
				$lesser_value_index = findLesserValueOnRightHandSide($arr,$mid_index+1,$right_index,$arr[$mid_index]);
				swap($arr,$lesser_value_index,$i);
			}
		}
	doMedianSort($arr, $left_index, $mid_index-1);
	doMedianSort($arr,$mid_index+1, $right_index);	
	}
	

}


//walk through an array and find a value that is less or equal to the passed in value
function findLesserValueOnRightHandSide($arr, $begin_index, $end_index, $value){
	for($i=$begin_index;$i<= $end_index;$i++){
		if($arr[$i] <= $value){
			return $i;
		}
	}
}

function swap(&$arr, $index_a, $index_b){
	$temp = $arr[$index_b];
	$arr[$index_b] = $arr[$index_a];
	$arr[$index_a] = $temp;
}


function QuickSort(&$arr){
    doQuickSort($arr, 0, count($arr)-1);
}

function doQuickSort(&$arr,$left_index, $right_index){
    if($left_index < $right_index){
        $pivot_index = partition($arr,$left_index,$right_index);
        doQuickSort($arr, $left_index, $pivot_index-1);
        doQuickSort($arr,$pivot_index + 1, $right_index);
    }
}


function partition(&$arr,$left_index,$right_index){
    $pivot_index = rand($left_index,$right_index);
    $store = $left_index;
    swap($arr,$right_index,$pivot_index);
    
    for($i=$left_index;$i<$right_index;$i++){
        if($arr[$i] <= $arr[$right_index]){
            swap($arr,$i,$store);
            $store++;
        }
    }
    swap($arr,$right_index,$store);
    return $store;
}





$arr = makeArray(10);
printArray($arr, 'initial array');

shuffle($arr);
printArray($arr, 'shuffled array');

medianSort($arr);
printArray($arr,'median sorted array');

//$arr = insertionSort($arr);
QuickSort($arr);
printArray($arr, 'Quicksorted array');

//var_dump(makeArray());
