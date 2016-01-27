<?php

class CategoryTableSeeder extends Seeder {

	public function run() {

		Category::create(['name_inside' => '学习辅导', 'name_outside' => '学霸专区']);
		Category::create(['name_inside' => '跑腿任务', 'name_outside' => '跑腿任务']);
		Category::create(['name_inside' => '维修任务', 'name_outside' => '维修任务']);
		// Category::create(['name_inside' => 'Hiring']);
		Category::create(['name_inside' => '屌丝任务', 'name_outside' => '屌丝福利']);
		Category::create(['name_inside' => '兼职任务', 'name_outside' => '兼职任务']);
		Category::create(['name_inside' => '游戏任务', 'name_outside' => '游戏任务']);
		Category::create(['name_inside' => '其他任务', 'name_outside' => '其他任务']);
	}
}