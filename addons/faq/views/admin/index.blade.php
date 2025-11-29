<?php
/*
 * This file is part of the CLIENTXCMS project.
 * This file is the property of the CLIENTXCMS association. Any unauthorized use, reproduction, or download is prohibited.
 * For more information, please consult our support: clientxcms.com/client/support.
 * Year: 2024
 */
?>
@extends('admin/layouts/admin')

@section('title', __('faq::messages.index.title'))

@section('content')
    <div class="container mx-auto">
        <div class="flex flex-col">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    @include('admin/shared/alerts')

                    <div class="card">
                        <div class="card-heading">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                                    {{ __('faq::messages.index.title') }}
                                </h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('faq::messages.index.description') }}
                                </p>
                            </div>
                            <div class="mt-2 sm:mt-0">
                                <a class="btn btn-primary text-sm w-full sm:w-auto" href="{{ route($routePath.'.create') }}">
                                    {{ __('admin.create') }}
                                </a>
                            </div>
                        </div>

                        <div class="border rounded-lg overflow-hidden dark:border-gray-700">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead>
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-start">
                                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">#</span>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-start">
                                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">{{ __('global.title') }}</span>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-start">
                                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">{{ __('global.group') }}</span>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-start">
                                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">{{ __('global.product') }}</span>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-start">
                                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">{{ __('global.created') }}</span>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-start">
                                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">{{ __('global.actions') }}</span>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @if ($items->count() === 0)
                                        <tr class="bg-white hover:bg-gray-50 dark:bg-slate-900 dark:hover:bg-slate-800">
                                            <td colspan="6" class="px-6 py-8 whitespace-nowrap text-center">
                                                <div class="flex flex-col items-center">
                                                    <p class="text-sm text-gray-800 dark:text-gray-400">{{ __('global.no_results') }}</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif

                                    @foreach($items as $faq)
                                        <tr class="bg-white hover:bg-gray-50 dark:bg-slate-900 dark:hover:bg-slate-800">
                                            <td class="h-px w-px whitespace-nowrap">
                                                <span class="block px-6 py-2">
                                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $faq->id }}</span>
                                                </span>
                                            </td>
                                            <td class="h-px w-px whitespace-nowrap">
                                                <span class="block px-6 py-2">
                                                    <span class="text-sm text-gray-700 dark:text-gray-300 font-medium">
                                                        {{ $faq->title }}
                                                    </span>
                                                </span>
                                            </td>
                                            <td class="h-px w-px whitespace-nowrap">
                                                <span class="block px-6 py-2">
                                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                                        {{ $faq->group->name ?? '-' }}
                                                    </span>
                                                </span>
                                            </td>
                                            <td class="h-px w-px whitespace-nowrap">
                                                <span class="block px-6 py-2">
                                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                                        {{ $faq->product->name ?? '-' }}
                                                    </span>
                                                </span>
                                            </td>
                                            <td class="h-px w-px whitespace-nowrap">
                                                <span class="block px-6 py-2">
                                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                                        {{ $faq->created_at ? $faq->created_at->format('d/m/Y') : '-' }}
                                                    </span>
                                                </span>
                                            </td>

                                            <td class="h-px w-px whitespace-nowrap">
                                            <a href="{{ route('admin.faq.show', $faq->id) }}">
                                                <span class="px-1 py-1.5">
                                                    <span class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800">
                                                        <i class="bi bi-eye-fill"></i>
                                                        {{ __('global.view') }}
                                                    </span>
                                                </span>
                                            </a>
                                            <form action="{{ route('admin.faq.destroy', $faq->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirmation()">
                                                    <span class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border font-medium bg-red text-red-700 shadow-sm align-middle hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:bg-red-900 dark:hover:bg-red-800 dark:border-red-700 dark:text-white dark:hover:text-white dark:focus:ring-offset-gray-800">
                                                        <i class="bi bi-trash"></i>
                                                        {{ __('global.delete') }}
                                                    </span>
                                                </button>
                                            </form>
                                        </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="py-1 px-4 mx-auto">
                            {{ $items->links('admin.shared.layouts.pagination') }}
                        </div>
                        
                            <form method="POST" action="{{ route('admin.faq.settings.update') }}" class="mt-6">
                                @csrf
                                @method('PUT')
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
                                            @include('admin/shared/switch', [
                                                'name' => 'faq_usefulness_enabled',
                                                'label' => '',
                                                'checked' => setting('faq_usefulness_enabled', true),
                                            ])
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
                </div>
            </div>
        </div>
@endsection
