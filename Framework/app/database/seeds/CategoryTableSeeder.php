<?php

class CategoryTableSeeder extends Seeder {

	public function run() {

		Category::create(['name' => 'Study Guide']);
		Category::create(['name' => 'Buy Breakfast']);
		Category::create(['name' => 'Computer Maintenance']);
		Category::create(['name' => 'Hiring']);
		Category::create(['name' => 'Boon for Diaosi']);
		Category::create(['name' => 'Part-time Job']);
		Category::create(['name' => 'Gaming']);
		Category::create(['name' => 'Other']);
	}
}