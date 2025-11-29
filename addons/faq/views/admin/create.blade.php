@extends('admin/layouts/admin')

@section('title', __('faq::messages.create.title'))

@section('content')
<div class="container mx-auto">
  <form method="POST" action="{{ route($routePath.'.store') }}">
    @csrf

    <div class="card">
      <div class="card-heading flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ __('faq::messages.create.title') }}
          </h2>
          <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ __('faq::messages.create.description') }}
          </p>
        </div>

        <div class="mt-3 sm:mt-0">
          <button class="btn btn-primary">
            {{ __('admin.create') }}
          </button>
        </div>
      </div>

      <div class="card-body space-y-5">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
        @include('admin/shared/input', [
          'name'          => 'title',
          'label'         => __('faq::messages.formulaire.title'),
          'value'         => old('title', $faq->title),
        ])
        </div>
        <div>
        @include('admin/shared/select', [
          'name'          => 'group_id',
          'label'         => __('global.group'),
          'options'       => ['' => __('global.none')] + $groups,
          'value'         => old('group_id', $faq->group_id ?? ''),
          'help'          => __('faq::messages.formulaire.group_help'),
        ])
        </div>
        <div>
        @include('admin/shared/select', [
          'name'          => 'product_id',
          'label'         => __('global.product'),
          'options'       => ['' => __('global.none')] + $products,
          'value'         => old('product_id', $faq->product_id ?? ''),
          'help'          => __('faq::messages.formulaire.product_help'),
        ])
        </div>
        </div>
        @include('admin/shared/textarea', [
          'name'          => 'answer',
          'label'         => __('faq::messages.formulaire.answer'),
          'value'         => old('answer', $faq->answer),
          'rows'          => 12,
        ])
        @include('admin/shared/input', [
          'type'          => 'number',
          'name'          => 'sort_order',
          'label'         => __('global.sort_order'),
          'value'         => old('sort_order', $faq->order ?? 0),
        ])
      </div>
    </div>
  </form>
</div>
@endsection
