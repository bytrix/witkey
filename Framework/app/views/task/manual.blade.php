@extends('layout.master_pure')

@section('content')

	<div class="container">
		
	<h2>
		{{ Lang::get('task.how-to-publish-a-qualified-task') }}
	</h2>

	<hr />

	<b>任务发布要求</b>
	<ol>
		<li>任务必须符合校规校纪</li>
		<li>确实能够执行的任务（无须天马行空，例如：替我睡觉、帮我把天上的星星摘下来等不可能完成的任务）</li>
		<li>必须让任务参与者得到应得的经济收益（若任务参与者所创造的价值远大于雇主支付的金额，同样视为不合格任务，例如：1块钱帮我开发一套定制软件）</li>
		<li>尽可能详细的描述任务需求，包括具体时间、地点、人员，以便减少任务参与者反复询问任务详情的次数，提高任务执行效率</li>
	</ol>

	</div>

@stop