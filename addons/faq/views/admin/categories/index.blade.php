<?php
/*
 * This file is part of the CLIENTXCMS project.
 * This file is the property of the CLIENTXCMS association. Any unauthorized use, reproduction, or download is prohibited.
 * For more information, please consult our support: clientxcms.com/client/support.
 * Year: 2024
 */
?>
@extends('admin/layouts/admin')

@section('title', __('faq::messages.categories.index.title'))

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
                                    {{ __('faq::messages.categories.index.title') }}
                                </h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('faq::messages.categories.index.description') }}
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
                                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">{{ __('global.name') }}</span>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-start">
                                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">{{ __('global.slug') }}</span>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-start">
                                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">{{ __('faq::messages.categories.icon') }}</span>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-start">
                                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">{{ __('faq::messages.categories.faqs_count') }}</span>
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

                                    @foreach($items as $category)
                                        <tr class="bg-white hover:bg-gray-50 dark:bg-slate-900 dark:hover:bg-slate-800">
                                            <td class="h-px w-px whitespace-nowrap">
                                                <span class="block px-6 py-2">
                                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $category->id }}</span>
                                                </span>
                                            </td>
                                            <td class="h-px w-px whitespace-nowrap">
                                                <span class="block px-6 py-2">
                                                    <span class="text-sm text-gray-700 dark:text-gray-300 font-medium">
                                                        {{ $category->name }}
                                                    </span>
                                                </span>
                                            </td>
                                            <td class="h-px w-px whitespace-nowrap">
                                                <span class="block px-6 py-2">
                                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                                        {{ $category->slug }}
                                                    </span>
                                                </span>
                                            </td>
                                            <td class="h-px w-px whitespace-nowrap">
                                                <span class="block px-6 py-2">
                                                    @if($category->icon)
                                                        <i class="{{ $category->icon }} text-gray-600 dark:text-gray-400"></i>
                                                    @else
                                                        <span class="text-sm text-gray-600 dark:text-gray-400">-</span>
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="h-px w-px whitespace-nowrap">
                                                <span class="block px-6 py-2">
                                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                                        {{ $category->faqs_count ?? 0 }}
                                                    </span>
                                                </span>
                                            </td>

                                            <td class="h-px w-px whitespace-nowrap">
                                                <a href="{{ route('admin.faq.categories.show', $category->id) }}">
                                                    <span class="px-1 py-1.5">
                                                        <span class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800">
                                                            <i class="bi bi-eye-fill"></i>
                                                            {{ __('global.view') }}
                                                        </span>
                                                    </span>
                                                </a>
                                                <form action="{{ route('admin.faq.categories.destroy', $category->id) }}" method="POST" class="inline">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection