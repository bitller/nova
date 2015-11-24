@extends('includes.ajax-translations.common')

@section('trans')
    <div id="help-center-manager-trans"
        delete-category="{{ trans('help_center.delete_category') }}"
        delete-article="{{ trans('help_center.delete_article') }}"
    ></div>
@endsection