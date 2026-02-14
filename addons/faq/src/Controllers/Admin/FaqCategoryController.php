<?php

/*
 * This file is part of the CLIENTXCMS project.
 * This file is the property of the CLIENTXCMS association. Any unauthorized use, reproduction, or download is prohibited.
 * For more information, please consult our support: clientxcms.com/client/support.
 * Year: 2024
 */

namespace App\Addons\Faq\Controllers\Admin;

use App\Addons\Faq\Models\FaqCategory;
use App\Http\Controllers\Admin\AbstractCrudController;
use App\Theme\ThemeManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FaqCategoryController extends AbstractCrudController
{
    protected string $model = FaqCategory::class;
    protected string $viewPath = 'faq_admin::categories';
    protected string $routePath = 'admin.faq.categories';
    protected ?string $managedPermission = 'admin.manage_faqs';
    protected string $searchField = 'name';

    public function getCreateParams()
    {
        $data = parent::getCreateParams();
        $data['category'] = new FaqCategory();
        return $data;
    }

    public function destroy(FaqCategory $category): RedirectResponse
    {
        $category->delete();
        ThemeManager::clearCache();

        return $this->deleteRedirect($category);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:faq_categories,slug'],
            'icon' => ['nullable', 'string', 'max:255'],
            'order' => ['nullable', 'integer', 'min:0'],
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $data['order'] = $data['order'] ?? 0;

        $category = FaqCategory::create($data);
        ThemeManager::clearCache();

        return redirect()->route('admin.faq.categories.index')
            ->with('success', __('admin.create'));
    }

    public function update(Request $request, FaqCategory $category)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:faq_categories,slug,' . $category->id],
            'icon' => ['nullable', 'string', 'max:255'],
            'order' => ['nullable', 'integer', 'min:0'],
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $data['order'] = $data['order'] ?? $category->order;

        $category->update($data);
        ThemeManager::clearCache();

        return redirect()->route('admin.faq.categories.index')
            ->with('success', __('global.update'));
    }

    public function show(FaqCategory $category)
    {
        $category->loadCount('faqs');

        return $this->showView([
            'category' => $category,
            'routePath' => $this->routePath,
        ]);
    }
}