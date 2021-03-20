<div style="margin-left: {{ (15 * ($level - 1)) }}px">
	<h4>
		{!! /*$level.*/ucfirst(str_replace(['_', '-'], ' ', trim($header))) !!}
		<a class="toggle-inputs" href="#"><i class="glyphicon glyphicon-plus-sign"></i></a>
	</h4>
	<div class="lang-input-box" style="margin-left: 10px;">
		{!! $langfile->displayInputs($item, $parents, $header, $level) !!}
	</div>
</div>
