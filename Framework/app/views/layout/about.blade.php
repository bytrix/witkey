@extends('layout.master')

@section('style')
<style>

	.menu{
		position: fixed;
		right: 40px;
		top: 120px;
	}
	
	.menu .nav>li>a{
		background-color: #fbfbfb;
	}

	.content{
		max-width: 800px;
	}

	section{
		padding-bottom: 40px;
		/*margin-bottom: 40px;*/
	}

	  /* Custom Styles */
    ul.nav-tabs{
        /*width: 140px;*/
        margin-top: 20px;
        border-radius: 4px;
        border: 1px solid #ddd;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.067);
    }
    ul.nav-tabs li{
        margin: 0;
        border-top: 1px solid #ddd;
    }
    ul.nav-tabs li:first-child{
        border-top: none;
    }
    ul.nav-tabs li a{
        margin: 0;
        padding: 8px 16px;
        border-radius: 0;
    }
    ul.nav-tabs li.active a, ul.nav-tabs li.active a:hover{
        color: #fff;
        background: #0088cc;
        border: 1px solid #0088cc;
    }
    ul.nav-tabs li:first-child a{
        border-radius: 4px 4px 0 0;
    }
    ul.nav-tabs li:last-child a{
        border-radius: 0 0 4px 4px;
    }
    ul.nav-tabs.affix{
        top: 120px; /* Set the top position of pinned element */
    }

</style>
@stop

@section('script')
{{-- @parent --}}
{{-- {{HTML::script(URL::asset('https://github.com/tuupola/jquery_lazyload/raw/master/jquery.lazyload.js'))}} --}}
{{HTML::script(URL::asset('assets/script/jquery.lazyload.js'))}}
<script>
$(document).ready(function(){
	// $("#myNav").affix();
	$('img').lazyload({
		placeholder: "http://localhost/assets/image/loading.gif"
	});
});
</script>
@stop

@section('menu')
	<ul class="nav navbar-nav">

	{{-- <li><a href="/">Home</a></li> --}}
	<li><a href="/school/{{Session::get('school_id_session')}}">{{Lang::get('task.list')}}</a></li>
	<li><a href="/task/create">{{Lang::get('task.task-publish')}}</a></li>
	<li class="active"><a href="/about">{{Lang::get('message.help')}}</a></li>
{{-- 	<li class="active" class="dropdown">
	  <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{Lang::get('message.help')}} <span class="caret"></span></a>
	  <ul class="dropdown-menu">
	    <li><a href="/about">About</a></li>
	  </ul>
	</li> --}}

	</ul>
@stop

@section('content')


		<div class="menu" id="myScrollSpy">
			<ul class="nav nav-tabs nav-stacked">
				<li><a href="#help-374FD1497E9F063C">什么是校园威客？</a></li>
				{{-- <li><a href="#help-2">How to play with it?</a></li> --}}
				<li><a href="#help-C525ECB61FB0A505">什么是悬赏和招标？</a></li>
				<li><a href="#help-122089F75308C788">新手流程</a></li>
				<li><a href="#help-66AE869B5F3AA2AA">如何通过实名认证？</a></li>
				<li><a href="#help-1AC98EF635CBBE68">出现问题怎么办？</a></li>
			</ul>
		</div>
	<div class="container content">



		<section>
			<h1 class="page-header">
				{{Lang::get('message.help')}}
			</h1>
			<h2 id="help-374FD1497E9F063C">什么是校园威客？</h2>
			<p>
				校园威客是一个致力于鼓励学生利用课余时间将知识与技能转化为经济收益的在线平台，在校园威客您可以帮同学买早饭；学习太忙，没时间打游戏？来校园威客找专业的游戏玩家为您打怪升级；临近期末，苦于找不到各种复习资料？来校园威客找超级学霸！在这里，每一个人都可以成为服务提供者或服务享受者，还能赚外快哦！
			</p>
		</section>

{{-- 		<section>
			<h2 id="help-2">How to play with it?</h2>
			<p>
				how how how how how how how how
			</p>
		</section> --}}

		<section>
			<h2 id="help-C525ECB61FB0A505">什么是悬赏和招标？</h2>
			<p>
				一般来说，威客任务分为两种：<b>悬赏任务</b>和<b>招标任务</b>。
			</p>
			<p>
				悬赏任务通常为简单易操作的任务，任务周期也较短，如发传单、QQ群推广等，因此需要提前托管赏金以保障任务执行者的权益；而悬赏任务通常是任务工程量比较大，如软件开发、海报设计，雇主无法预估任务所需的执行周期与价格，因此可以先给出一个大概的价格范围，然后反复与威客协商价格，待威客给出一个确定的报价后，雇主才开始托管赏金。
			</p>
		</section>

		<section>
			<h2 id="help-122089F75308C788">新手流程</h2>
			<img data-original="https://raw.githubusercontent.com/bytrix/witkey/master/Diagram/Flowchart/Flowchart.png">
		</section>

		<section>
			<h2 id="help-66AE869B5F3AA2AA">如何通过实名认证？</h2>
			<p>
				用户登录后点击网站右上角的菜单项进入用户中心，在左侧的面板选择实名认证，正确填写个人身份信息后提交，若您的信息核实后无误，即可在2个工作日之内通过实名认证。
			</p>
		</section>


		<section>
			<h2 id="help-1AC98EF635CBBE68">出现问题怎么办？</h2>
			<p>
				若您在交易过程中遇到任何困难、疑惑，请发邮件至 <a href="mailto:problem@campuswitkey.com">problem@campuswitkey.com</a> 详细描述您的问题，我们会尽快为您找到最佳解决方案。
			</p>
		</section>

	</div>
@stop