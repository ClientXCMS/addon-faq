@extends('admin/layouts/admin')

@section('title', __('faq::messages.create.title'))

@section('content')
<div class="container mx-auto">
  @include('admin/shared/alerts')
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
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="md:col-span-2">
        @include('admin/shared/input', [
          'name'          => 'title',
          'label'         => __('faq::messages.formulaire.title'),
          'value'         => old('title', $faq->title),
        ])
        </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
        @include('admin/shared/select', [
          'name'          => 'category_id',
          'label'         => __('faq::messages.formulaire.category'),
          'options'       => ['' => __('global.none')] + $categories,
          'value'         => old('category_id', $faq->category_id ?? ''),
          'help'          => __('faq::messages.formulaire.category_help'),
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

        {{-- Display Sections --}}
        @if(!empty($availableSections))
        <div class="mt-6">
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
            {{ __('faq::messages.formulaire.display_sections') }}
          </label>
          <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">
            {{ __('faq::messages.formulaire.display_sections_help') }}
          </p>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            @foreach($availableSections as $sectionKey => $sectionLabel)
            <label class="flex items-center p-3 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer transition-colors">
              <input
                type="checkbox"
                name="display_sections[]"
                value="{{ $sectionKey }}"
                class="form-checkbox h-5 w-5 text-primary-600 rounded border-gray-300 dark:border-gray-600 focus:ring-primary-500"
                {{ ($faq->exists && $faq->shouldDisplayOn($sectionKey)) || in_array($sectionKey, old('display_sections', [])) ? 'checked' : '' }}
              >
              <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">{{ $sectionLabel }}</span>
            </label>
            @endforeach
          </div>
        </div>
        @endif
      </div>
    </div>
  </form>
</div>
@endsection
