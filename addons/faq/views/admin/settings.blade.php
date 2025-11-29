@extends('admin.settings.sidebar')

@section('title', __('faq::messages.settings.title'))

@section('setting')
  <div class="card">
    <h4 class="font-semibold uppercase text-gray-600 dark:text-gray-400">
      {{ __('faq::messages.settings.title') }}
    </h4>
    <p class="mb-4 font-semibold text-gray-600 dark:text-gray-400">
      {{ __('faq::messages.settings.description') }}
    </p>

    <form method="POST" action="{{ route('admin.faq.settings.update') }}">
      @csrf
      @method('PUT')
      <div class="grid grid-cols-1 gap-4">
        <div class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 dark:border-gray-700 dark:bg-gray-800">
          <div class="flex items-start justify-between gap-3">
            <div>
              <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                {{ __('faq::messages.settings.usefulness_label') }}
              </p>
              <p class="text-xs text-gray-600 dark:text-gray-400">
                {{ __('faq::messages.settings.usefulness_help') }}
              </p>
            </div>
            <div class="mt-1">
              @include('admin/shared/checkbox', [
                'name' => 'faq_usefulness_enabled',
                'label' => '',
                'checked' => setting('faq_usefulness_enabled', true),
              ])
            </div>
          </div>
        </div>
      </div>

      <div class="flex items-center justify-end mt-4">
        <button type="submit" class="btn btn-primary">
          {{ __('global.save') }}
        </button>
      </div>
    </form>
  </div>
@endsection
