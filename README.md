Campus Witkey
=============

This is my little web project made with Laravel 4.2 which aims to encourage students who has special talent to help someone in need.

Inspired by [PHPHub](https://phphub.org/), [ZhiHu](http://www.zhihu.com/), [ele.me](https://www.ele.me/)

About myself
------------

> Software Engineering student in school, crazy about technolygy and art
> but not much proficient. A short time ago, a little conflict happened in
> school between someone and me so that I have to  quit school.
> However, it's a chance for me because I can spend all my spare
> time in programming learning. To summarize the self-study plan,
> acturally I did learn something new that I didn't know before like
> linux, git and web framework.Previously, I did almost work in windows
> and now I change to linux environment so that I could learn more about
> programming with so much open source code.

Let's keep on track
-------------------
First you need to config the username/password of database in ``Framework/app/config/database.php``.

And then create a database named ``witkey`` in mysql:

    CREATE DATABASE witkey

change directory to ``Framework`` and make database migration:

    php artisan migrate

then run the server:

    php artisan serve

type localhost:8000 in browser and after that you can see the page

Development Progress
--------------------

- [x] 用户登录/注册/退出
- [x] 忘记密码
- [ ] OAuth开放认证
- [x] 任务发布/编辑
- [x] 校区选择
- [x] 实名身份认证
- [ ] 头像上传
- [x] 报价
- [x] 交稿
- [ ] 支付
- [x] 任务延期设置
- [x] 任务收藏
- [x] 任务评价
- [x] 任务搜索
- [x] 任务分类
- [ ] 任务附件上传
- [ ] 日程安排
- [x] 添加好友
- [ ] 雇佣某人
- [ ] 站内信
- [ ] 邮箱验证
- [ ] 短信验证

Architecture
------------

**Database E-R Diagram**

![Database E-R Diagram][1]

**Flowchart**

![Flowchart][2]

**Class Diagram with MVC architecture**

![Class Diagram][3]

> The 3 diagrams above are made with:
> 
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

- [bootstrap3-wysiwyg](https://github.com/bootstrap-wysiwyg/bootstrap3-wysiwyg)
- [jQuery-File-Upload](https://github.com/blueimp/jQuery-File-Upload)
- [moment.js](https://github.com/moment/moment)
- [countdown.js](https://github.com/kbwood/countdown)
- [HTMLPurifier for Laravel 4](https://github.com/mewebstudio/Purifier/tree/master-l4)
- [select2](https://github.com/select2/select2)
- [select2-bootstrap-theme](https://github.com/select2/select2-bootstrap-theme)
- [awesome-bootstrap-checkbox](https://github.com/flatlogic/awesome-bootstrap-checkbox)
- [particles.js](https://github.com/VincentGarreau/particles.js)


  [1]: https://github.com/bytrix/witkey/raw/master/Diagram/DataModel/DataModel.png
  [2]: https://github.com/bytrix/witkey/raw/master/Diagram/Flowchart/Flowchart.png
  [3]: https://github.com/bytrix/witkey/raw/master/Diagram/ClassDiagram/ClassDiagram.jpg
  

Project Fee
-----------

<table>
	<thead>
		<th>Fee Name</th>
		<th>Fee Amount</th>
		<th>Quantity</th>
	</thead>
	<tbody>
		<tr>
			<td>Yunti VPN</td>
			<td>&yen; 230.00</td>
			<td>1</td>
		</tr>
	</tbody>
</table>