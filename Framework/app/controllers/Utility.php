<?php

class Utility {

	public static function Sec2Year($second) {

		$minute = $second / 60;
		$hour   = $minute / 60;
		$day    = $hour / 24;
		$year   = $day / 365;

		if ($year < 0) {

			return 0;
		}
		return ceil($year);
	}

	public static function grade($schoolAge) {

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
				return '已毕业';
				break;
		}
	}
}