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
}