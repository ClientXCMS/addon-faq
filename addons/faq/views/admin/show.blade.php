@extends('admin/layouts/admin')

@section('title', __('faq::messages.update.title'))

@section('content')
<div class="container mx-auto">
  <form method="POST" action="{{ route($routePath.'.update', $faq->id) }}">
    @csrf
    @method('PUT')
    <div class="card">
      <div class="card-heading flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ __('faq::messages.update.title') }}
          </h2>
          <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ __('faq::messages.update.description') }}
          </p>
        </div>
        <div class="mt-3 sm:mt-0">
          <button class="btn btn-primary">
            {{ __('global.update') }}
          </button>
          @if ($faq->group)
            <a href="{{ route('client.faq.group', $faq->group->slug) }}" class="btn btn-secondary" target="_blank">
              {{ __('global.seemore') }}
            </a>
          @endif
          @if ($faq->product)
            <a href="{{ route('front.store.basket.config', $faq->product->id)}}" class="btn btn-secondary" target="_blank">
              {{ __('global.seemore') }}
            </a>
          @endif
        </div>
      </div>

      <div class="card-body">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
        @include('admin/shared/input', [
          'name'          => 'title',
          'label'         => __('faq::messages.formulaire.title'),
          'value'         => old('title', $faq->title),
          'translatable'  => true,
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
          'value'         => old('answer', isset($faq) ? $faq->trans('answer', $faq->answer ?? '') : ''),
          'rows'          => 12,
          'translatable'  => isset($faq),
        ])
        @include('admin/shared/input', [
          'type'          => 'number',
          'name'          => 'sort_order',
          'label'         => __('global.sort_order'),
          'value'         => old('sort_order', $faq->order ?? 0),
          ])
        </div>
      </div>
      <div class="card mt-6">
        <div class="card-heading flex items-center justify-between">
          <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
              {{ __('faq::messages.stats.title') }}
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">
              {{ __('faq::messages.stats.description') }}
            </p>
          </div>
        </div>
        <div class="card-body">
          <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="flex items-center gap-4 rounded-xl border border-gray-200 bg-white px-4 py-4 shadow-sm dark:border-gray-700 dark:bg-gray-900">
              <div class="flex h-12 w-12 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-300">
                <i class="bi bi-hand-thumbs-up text-2xl"></i>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                  {{ __('faq::messages.client.useful_yes') }}
                </p>
                <p class="text-3xl font-semibold text-gray-900 dark:text-gray-50 leading-none">
                  {{ $faq->useful_yes_count ?? 0 }}
                </p>
              </div>
            </div>
            <div class="flex items-center gap-4 rounded-xl border border-gray-200 bg-white px-4 py-4 shadow-sm dark:border-gray-700 dark:bg-gray-900">
              <div class="flex h-12 w-12 items-center justify-center rounded-full bg-rose-50 text-rose-600 dark:bg-rose-900/30 dark:text-rose-300">
                <i class="bi bi-hand-thumbs-down text-2xl"></i>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                  {{ __('faq::messages.client.useful_no') }}
                </p>
                <p class="text-3xl font-semibold text-gray-900 dark:text-gray-50 leading-none">
                  {{ $faq->useful_no_count ?? 0 }}
                </p>
              </div>
            </div>
            <div class="flex items-center gap-4 rounded-xl border border-gray-200 bg-white px-4 py-4 shadow-sm dark:border-gray-700 dark:bg-gray-900">
              <div class="flex h-12 w-12 items-center justify-center rounded-full bg-indigo-50 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-300">
                <i class="bi bi-clipboard-check text-2xl"></i>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                  {{ __('store.total') }}
                </p>
                <p class="text-3xl font-semibold text-gray-900 dark:text-gray-50 leading-none">
                  {{ ($faq->useful_yes_count ?? 0) + ($faq->useful_no_count ?? 0) }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
  @include('admin/translations/overlay', ['item' => $faq, 'id' => $faq->id])
@endsection
