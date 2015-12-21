<?php

class ThirdPartyController extends Eloquent {

	public static function getGravatar( $email, $s = 200, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {

		$url = 'https://secure.gravatar.com/avatar/';
		$url .= md5( strtolower( trim( $email ) ) );
		$url .= "?s=$s&d=$d&r=$r";

		if ( $img ) {

			$url = '<img src="' . $url . '"';
			
			foreach ( $atts as $key => $val )
				$url .= ' ' . $key . '="' . $val . '"';
			$url .= ' />';
		}

		return $url;
	}

	public static function getCity() {

		$city = file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=php');
		$city = explode('	', mb_convert_encoding($city, 'utf-8', 'gbk'));

		return $city[5];
	}

}