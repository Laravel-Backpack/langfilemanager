@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
	    {{ trans('backpack::langfilemanager.translate') }} <span class="text-lowercase">{{ trans('backpack::langfilemanager.site_texts') }}</span>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li class="active">{{ trans('backpack::crud.edit') }} {{ trans('backpack::langfilemanager.texts') }}</li>
	  </ol>
	</section>
@endsection

@section('content')
<!-- Default box -->
  <div class="box">
  	<div class="box-header with-border">
	  <h3 class="box-title">{{ ucfirst(trans('backpack::langfilemanager.language')) }}:
		@foreach ($languages as $lang)
			@if ($currentLang == $lang->abbr)
				{{{ $lang->name }}}
			@endif
		@endforeach
		<small>
			 &nbsp; {{ trans('backpack::langfilemanager.switch_to') }}: &nbsp;
			<select name="language_switch" id="language_switch">
				@foreach ($languages as $lang)
				<option value="{{ url(config('backpack.base.route_prefix', 'admin')."/language/texts/{$lang->abbr}") }}" {{ $currentLang == $lang->abbr ? 'selected' : ''}}>{{ $lang->name }}</option>
				@endforeach
			</select>
		</small>
	  </h3>
	</div>
    <div class="box-body">
    	<p><em>{!! trans('backpack::langfilemanager.rules_text') !!}</em></p>
    	<br>
		<ul class="nav nav-tabs">
			@foreach ($langFiles as $file)
			<li class="{{ $file['active'] ? 'active' : '' }}">
				<a href="{{ $file['url'] }}">{{ $file['name'] }}</a>
			</li>
			@endforeach
		</ul>
		<div class="clearfix"></div>
		<br>
		<section class="lang-inputs">
		@if (!empty($fileArray))
			{!! Form::open(array('url' => url(config('backpack.base.route_prefix', 'admin')."/language/texts/{$currentLang}/{$currentFile}"), 'method' => 'post', 'id' => 'lang-form', 'class' => 'form-horizontal', 'data-required' => trans('admin.language.fields_required'))) !!}
				{!! Form::button(trans('backpack::crud.save'), array('type' => 'submit', 'class' => 'btn btn-success submit pull-right hidden-xs hidden-sm', 'style' => "margin-top: -60px;")) !!}
				<div class="form-group hidden-sm hidden-xs">
					<div class="col-sm-2 text-right">
						<h4>{{ trans('backpack::langfilemanager.key') }}</h4>
					</div>
					<div class="hidden-sm hidden-xs col-md-5">
						<h4>{{ trans('backpack::langfilemanager.language_text', ['language_name' => $browsingLangObj->name]) }}</h4>
					</div>
					<div class="col-sm-10 col-md-5">
						<h4>{{ trans('backpack::langfilemanager.language_translation', ['language_name' => $currentLangObj->name]) }}</h4>
					</div>
				</div>
				{!! $langfile->displayInputs($fileArray) !!}
				<hr>
				<div class="text-center">
					{!! Form::button(trans('backpack::crud.save'), array('type' => 'submit', 'class' => 'btn btn-success submit')) !!}
				</div>
			{!! Form::close() !!}
		@else
			<em>{{ trans('backpack::langfilemanager.empty_file') }}</em>
		@endif
	</section>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
@endsection

@section('after_scripts')
	<script>
		jQuery(document).ready(function($) {
			$("#language_switch").change(function() {
				window.location.href = $(this).val();
			})
		});
	</script>
@endsection
