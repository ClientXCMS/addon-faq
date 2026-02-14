@extends('admin/layouts/admin')

@section('title', __('faq::messages.categories.show.title', ['name' => $category->getTranslation('name')]))

@section('content')
<div class="container mx-auto">
  @include('admin/shared/alerts')
  
  <form method="POST" action="{{ route($routePath.'.update', $category->id) }}">
    @csrf
    @method('PUT')

    <div class="card">
      <div class="card-heading flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ __('faq::messages.categories.show.title', ['name' => $category->getTranslation('name')]) }}
          </h2>
          <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ __('faq::messages.categories.show.description') }}
          </p>
        </div>

        <div class="mt-3 sm:mt-0 flex gap-2">
          <button class="btn btn-primary">
            {{ __('global.update') }}
          </button>
        </div>
      </div>

      <div class="card-body space-y-5">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            @include('admin/shared/input', [
              'name'          => 'name',
              'label'         => __('faq::messages.categories.formulaire.name'),
              'value'         => old('name', $category->getTranslation('name')),
              'required'      => true,
            ])
          </div>
          <div>
            @include('admin/shared/input', [
              'name'          => 'slug',
              'label'         => __('faq::messages.categories.formulaire.slug'),
              'value'         => old('slug', $category->slug),
              'help'          => __('faq::messages.categories.formulaire.slug_help'),
            ])
          </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            @include('admin/shared/input', [
              'name'          => 'icon',
              'label'         => __('faq::messages.categories.formulaire.icon'),
              'value'         => old('icon', $category->icon),
              'help'          => __('faq::messages.categories.formulaire.icon_help'),
            ])
          </div>
          <div>
            @include('admin/shared/input', [
              'type'          => 'number',
              'name'          => 'order',
              'label'         => __('global.sort_order'),
              'value'         => old('order', $category->order ?? 0),
            ])
          </div>
        </div>

        @if($category->faqs_count > 0)
        <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg dark:bg-blue-900/20 dark:border-blue-800">
          <div class="flex items-center">
            <i class="bi bi-info-circle text-blue-600 dark:text-blue-400 mr-2"></i>
            <p class="text-sm text-blue-700 dark:text-blue-300">
              {{ trans_choice('faq::messages.categories.stats.faqs_count', $category->faqs_count, ['count' => $category->faqs_count]) }}
            </p>
          </div>
        </div>
        @endif
      </div>
    </div>
  </form>
</div>
@endsection