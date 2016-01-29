<?php

class CategoryTableSeeder extends Seeder {

	public function run() {

		Category::create(['name' => '学习辅导', 'name2' => '学霸专区']);
		Category::create(['name' => '跑腿任务', 'name2' => '跑腿任务']);
		Category::create(['name' => '维修任务', 'name2' => '维修任务']);
		// Category::create(['name' => 'Hiring']);
		Category::create(['name' => '屌丝任务', 'name2' => '屌丝福利']);
		Category::create(['name' => '兼职任务', 'name2' => '兼职任务']);
		Category::create(['name' => '游戏任务', 'name2' => '游戏任务']);
		Category::create(['name' => '其他任务', 'name2' => '其他任务']);
	}
}