<?php

class Util {

	public static function getCity() {
		$city = file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=php');
		$city = explode('	', mb_convert_encoding($city, 'utf-8', 'gbk'));
		return $city[5];
	}

	public static function asterisk($input, $headLength, $tailLength) {

		$head   = mb_substr($input, 0, $headLength);
		$tail   = mb_substr($input, -$tailLength);
		$asteriskBody = '';

		for ($i=0; $i < strlen($input) - ($headLength + $tailLength); $i++) { 

			$asteriskBody .= '*';
		}

		return $head . $asteriskBody . $tail;

	}

	public static function secToYear($second) {

		$minute = $second / 60;
		$hour   = $minute / 60;
		$day    = $hour / 24;
		$year   = $day / 365;

		if ($year < 0) {

			return 0;
		}
		return ceil($year);
	}

	public static function getGrade($user, $schoolAge) {

		switch ($schoolAge) {
			case '0':
				return '准大一';
				break;

			case '1':
				return '大一';
				break;

			case '2':
				return '大二';
				break;

			case '3':
				return '大三';
				break;
				
			case '4':
				return '大四';
				break;
			
			default:
				$thisYear = Date("Y");
				if ($user->gender == "M") {
					$gender = "学长";
				} else {
					$gender = "学姐";
				}
				return $thisYear - $schoolAge + 4 . "届" . $gender;
				break;
		}
	}


	public static function getExtension($filename) {
		$arr = array();
		$arr = explode('.', $filename);
		if (count($arr) == 1) {
			return '';
		} else {
			return end($arr);
		}
	}

	public static function isPhone($val) {
		if (preg_match("/^[0-9]{11}$/", $val)) {
			return true;
		} else {
			return false;
		}
	}

	public static function isEmail($val) {
		if (preg_match("/^\w+@[a-zA-Z0-9]+\.[a-zA-Z]+$/", $val)) {
			return true;
		} else {
			return false;
		}
	}


	// 0 - 1000			1.1%	1.011
	// 1000 - 2000		1.0%	1.010
	// 2000 - 3000		0.9%	1.009
	// 3000 - 4000		0.8%	1.008
	// 4000 - 5000		0.7%	1.007
	// 5000 - ?			0.6%	1.006

	public static function getTotalFee($fee) {
		if ($fee > 0 && $fee < 1000) {
			$profit = 1.1;
		} elseif ($fee >= 1000 && $fee < 2000) {
			$profit = 1.0;
		} elseif ($fee >= 2000 && $fee < 3000) {
			$profit = 0.9;
		} elseif ($fee >= 3000 && $fee < 4000) {
			$profit = 0.8;
		} elseif ($fee >= 4000 && $fee <=5000) {
			$profit = 0.7;
		} else {
			$profit = 0.6;
		}
		$factor = $profit / 100 + 1;
		return $fee * $factor;
	}


}