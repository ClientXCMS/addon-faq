@extends('admin/layouts/admin')

@section('title', __('faq::messages.categories.create.title'))

@section('content')
<div class="container mx-auto">
  @include('admin/shared/alerts')
  <form method="POST" action="{{ route($routePath.'.store') }}">
    @csrf

    <div class="card">
      <div class="card-heading flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ __('faq::messages.categories.create.title') }}
          </h2>
          <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ __('faq::messages.categories.create.description') }}
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
          <div>
            @include('admin/shared/input', [
              'name'          => 'name',
              'label'         => __('faq::messages.categories.formulaire.name'),
              'value'         => old('name', $category->name),
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
      </div>
    </div>
  </form>
</div>
@endsection