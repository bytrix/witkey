Campus Witkey
=============

This is my little web project made with Laravel 4.2 which aims to encourage students who has special talent to help someone in need.

Inspired by [PHPHub](https://phphub.org/), [GitHub](https://github.com/), [ZhiHu](http://www.zhihu.com/), [ele.me](https://www.ele.me/)

About myself
------------

> Software Engineering student in school, crazy about technology and art
> but not much proficient. A short time ago, someone in the school had
> a conflict with me so that I have to quit school.
> However, it's a good opportunity for me because I am able to spend all my spare
> time in programming learning. To summarize the self-study plan,
> acturally I did learn something new that I didn't know before like
> linux, git and web framework.Previously, I did almost work in windows
> and now I change to linux environment so that I am able to learn more about
> programming with so much open source code.

Let's keep on track
-------------------

**Initialize**

    python init.py

This will create the directories ignored by .gitignore

    ├── /Framework/public/avatar/
    ├── /Framework/public/file/
    ├── /Framework/public/student_card/
    ├── /Framework/public/upload/cache/
    └── /Server/db_backup/

> Make sure the permission of the directories created above and ``/Framework/app/storage`` is writable.
>
> Just change the file's group to ``www-data`` so that it can work under nginx.

**Configure**

First you need to config the username & password of database in ``Framework/app/config/database.php``.

```php
'mysql' => array(
	'driver'    => 'mysql',
	'host'      => 'localhost',
	'database'  => 'witkey',
	'username'  => 'your_database_username',
	'password'  => 'your_database_password',
	'charset'   => 'utf8mb4',
	'collation' => 'utf8mb4_unicode_ci',
	'prefix'    => '',
),
```
And then create a database named ``witkey`` in mysql:

    CREATE DATABASE witkey

change directory to ``Framework`` and make database migration:

    php artisan migrate

make database seed:

    php artisan db:seed

then run the server:

    php artisan serve

type localhost:8000 in browser and after that you can see the page

Development Progress
--------------------

- [x] 用户登录/注册/退出
- [x] 忘记密码
- [ ] 用户积分?
- [ ] 用户等级?
- [ ] 用户红包
- [x] 用户角色控制
- [x] 校区负责人
- [x] 任务发布/编辑
- [x] 校区选择
- [x] 实名身份认证
- [x] 头像上传
- [x] 报价
- [x] 交稿
- [ ] 支付
- [x] 任务延期设置
- [x] 任务收藏
- [x] 任务评价
- [x] 任务搜索
- [ ] 同校校友都在搜?
- [x] 条件筛选（最新发布、最多赏金、最短周期、最小竞争）
- [x] 任务分类
- [x] 任务附件上传
- [ ] 日程安排?
- [x] 添加好友
- [x] 雇佣某人
- [x] 站内信
- [ ] 邮箱验证?
- [x] 短信验证

Architecture
------------

**Database E-R Diagram**

![Database E-R Diagram][1]

**Flowchart**

![Flowchart][2]

**Class Diagram with MVC architecture**

![Class Diagram][3]

> The 3 diagrams above are made with:
> - [MySQL Workbench](http://dev.mysql.com/downloads/workbench/) (E-R Diagram)
> - [yEd](http://www.yworks.com/products/yed) (Flowchart)
> - [StarUML](http://staruml.io/) (Class Diagram)

Core
----

- Laravel 4.2
- Bootstrap 3.3.5
- AngularJS 1.2.10


References
----------

- ~~[bootstrap3-wysiwyg](https://github.com/bootstrap-wysiwyg/bootstrap3-wysiwyg)~~
- [simditor](https://github.com/mycolorway/simditor)
- [laravel-jquery-file-upload](https://github.com/zimt28/laravel-jquery-file-upload)
- [moment.js](https://github.com/moment/moment)
- [countdown.js](https://github.com/kbwood/countdown)
- [HTMLPurifier for Laravel 4](https://github.com/mewebstudio/Purifier/tree/master-l4)
- [select2](https://github.com/select2/select2)
- [select2-bootstrap-theme](https://github.com/select2/select2-bootstrap-theme)
- [bootstrap-datepicker](https://github.com/eternicode/bootstrap-datepicker)
- [bootstrap-datetimepicker](https://github.com/smalot/bootstrap-datetimepicker)
- [awesome-bootstrap-checkbox](https://github.com/flatlogic/awesome-bootstrap-checkbox)
- [particles.js](https://github.com/VincentGarreau/particles.js)
- [cropper](https://github.com/fengyuanchen/cropper)
- [jquery_lazyload](https://github.com/tuupola/jquery_lazyload)
- [NProgress](https://github.com/rstacruz/nprogress)


  [1]: https://github.com/bytrix/witkey/raw/master/Diagram/DataModel/DataModel.png
  [2]: https://github.com/bytrix/witkey/raw/master/Diagram/Flowchart/Flowchart.png
  [3]: https://github.com/bytrix/witkey/raw/master/Diagram/ClassDiagram/ClassDiagram.jpg
  

Server Configuration
--------------------

**Database backup**

Edit the crontab with command: `crontab -e`.

Save the backup in every morning 3am:

    # m h  dom mon dow   command
      0 3  *   *   *     (ROOT_PATH)/Server/mysql_backup.sh

**Mysql event scheduler**

Turn on event scheduler:

    SET GLOBAL event_scheduler=ON;
Check the status of event scheduler:

    show variables like '%event%';

Create event:

```sql
CREATE EVENT mark_as_expired_task
ON SCHEDULE EVERY 1 MINUTE
DO UPDATE Task SET state = 5 WHERE state = 1 AND expiration < now();
```

Project Fee
-----------

<table>
	<thead>
		<th>Fee Name</th>
		<th>Fee Amount</th>
		<th>Remark</th>
		<th>Quantity</th>
	</thead>
	<tbody>
		<tr>
			<td>Yunti VPN</td>
			<td>&yen; 230.00</td>
			<td></td>
			<td>1</td>
		</tr>
		<tr>
			<td>Aliyun ECS</td>
			<td>&yen; 58.24</td>
			<td></td>
			<td>1</td>
		</tr>
		<tr>
			<td>Domain Name</td>
			<td>&yen; 39.00</td>
			<td></td>
			<td>1</td>
		</tr>
		<tr>
			<td>Short Message Service</td>
			<td>&yen; 1200.00</td>
			<td>20000 text messages</td>
			<td>1</td>
		</tr>
		<tr>
			<td>Aliyun Server Renewal</td>
			<td>&yen; 1224.00</td>
			<td>3 years</td>
			<td>1</td>
		</tr>
		<tr>
			<td>Domain Name Renewal</td>
			<td>&yen; 190.00</td>
			<td>2 years</td>
			<td>1</td>
		</tr>
		<tr>
			<td>User Coupons</td>
			<td>&yen; 2058.76</td>
			<td></td>
			<td>1</td>
		</tr>

		<tr>
			<td><b>Total</b></td>
			<td><b>&yen; 5000</b></td>
			<td></td>
			<td><b>7</b></td>
		</tr>
	</tbody>
</table>
