<?php

class Academy {

	public static $academyCode = [
		'3434' => 'Harvard Colleage',
		'13470' => '福州大学至诚学院'
	];

	public static $majorCode = [
		'01' => '材料成型及控制工程',
		'02' => '材料科学与工程',
		'03' => '电气工程及其自动化',
		'04' => '自动化',
		'05' => '材料化学',
		'06' => '过程装备与控制工程',
		'07' => '化学工程与工艺',
		'08' => '应用化学',
		'09' => '安全工程',
		'10' => '环境工程',
		'11' => '人文地理与城乡规划',
		'12' => '机械设计制造及其自动化',
		'13' => '计算机科学与技术',
		'14' => '软件工程',
		'15' => '网络工程',
		'16' => '建筑学',
		'17' => '财务管理',
		'18' => '国际经济与贸易',
		'19' => '金融工程',
		'20' => '汉语言文学',
		'21' => '生物工程',
		'22' => '生物技术',
		'23' => '食品科学与工程',
		'24' => '土木工程',
		'25' => '工程管理',
		'26' => '日语',
		'27' => '商务英语',
		'28' => '英语',
		'29' => '物流管理',
		'30-1' => '电子信息工程',
		'30-2' => '电子科学与技术',
		'30-3' => '通信工程',
		'30-4' => '微电子科学与工程',
		'31' => '信息管理与信息系统',
		'32' => '行政管理',
		'33' => '包装工程',
		'34' => '工业设计',
		'35' => '音乐学',
		'36' => '产品设计'
	];


	public static function allAcademies() {
		return self::$academyCode;
	}
	public static function getAcademy($academy_code) {
		return self::$academyCode[$academy_code];
	}

	public static function allMajors() {
		return self::$majorCode;
	}
	public static function getMajor($major_code) {
		return self::$majorCode[$major_code];
	}
}