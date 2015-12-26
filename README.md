Campus Witkey
=============

This is my little web project made with Laravel 4.2 which aims to encourage students who has special talent to help someone in need.

About myself
------------

> Software Engineering student in school, crazy about technolygy and art
> but not proficient. A short time ago, a little conflict happened in
> school between someone and me so that I have to  quit school.
> However, it's a chance for me because I can spend all my spare
> time in programming learning. To summarize the self-study plan,
> acturally I did learn something new that I didn't know before like
> linux, git and web framework.Previously, I did almost work in windows
> and now I change to linux environment so that I could learn more about
> programming with so much open source code.

Let's keep on track
-------------------
First you need to config the database in Framework/app/config/database.php.
And then create a database named witkey in mysql

    CREATE DATABASE witkey

change directory to Framework and make database migration:

    php artisan migrate

then run the server

    php artisan serve

type localhost:8000 in browser and you can see the page

Architecture
------------
**Data Model**
![Data Model][1]

**Flowchart**
![Flowchart][2]

**Class Diagram with MVC architecture**
![Class Diagram][3]


References
----------

bootstrap-wysiwyg/bootstrap3-wysiwyg
https://github.com/bootstrap-wysiwyg/bootstrap3-wysiwyg

moment/moment
https://github.com/moment/moment

kbwood/countdown
https://github.com/kbwood/countdown

one-signal/emoji-picker
https://github.com/one-signal/emoji-picker


  [1]: https://github.com/bytrix/witkey/raw/master/Diagram/DataModel/DataModel.png
  [2]: https://github.com/bytrix/witkey/raw/master/Diagram/Flowchart/Flowchart.png
  [3]: https://github.com/bytrix/witkey/raw/master/Diagram/ClassDiagram/ClassDiafram.jpg