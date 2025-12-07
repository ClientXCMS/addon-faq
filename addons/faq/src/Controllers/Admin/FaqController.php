<?php

/*
 * This file is part of the CLIENTXCMS project.
 * This file is the property of the CLIENTXCMS association. Any unauthorized use, reproduction, or download is prohibited.
 * For more information, please consult our support: clientxcms.com/client/support.
 * Year: 2024
 */

namespace App\Addons\Faq\Controllers\Admin;

use App\Addons\Faq\Models\Faq;
use App\Models\Store\Group;
use App\Models\Store\Product;
use App\Http\Controllers\Admin\AbstractCrudController;
use Illuminate\Http\Request;

class FaqController extends AbstractCrudController
{
    protected string $model = Faq::class;
    protected string $viewPath = 'faq_admin::';
    protected string $routePath = 'admin.faq';
    protected array $relations = ['group', 'product'];
    protected ?string $managedPermission = 'admin.manage_faqs';
    protected string $searchField = 'title';

    public function getCreateParams()
    {
        $data = parent::getCreateParams();
        $data['faq'] = new Faq();
        $data['groups'] = Group::orderBy('name')->pluck('name', 'id')->toArray();
        $data['products'] = Product::orderBy('name')->pluck('name', 'id')->toArray();
        return $data;
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return $this->deleteRedirect($faq);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'    => ['required','string','max:255'],
            'answer'  => ['required','string'],
            'group_id' => ['nullable','integer','exists:groups,id'],
            'product_id' => ['nullable','integer','exists:products,id'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);

        $data['order'] = $data['sort_order'] ?? 0;
        unset($data['sort_order']);

        $faq = Faq::create($data);

        return $this->storeRedirect($faq);
    }

    public function show(Faq $faq)
    {
        $groups = Group::orderBy('name')->pluck('name', 'id')->toArray();
        $products = Product::orderBy('name')->pluck('name', 'id')->toArray();

        $faq->loadCount([
            'usefulnessVotes as useful_yes_count' => fn ($query) => $query->where('is_useful', true),
            'usefulnessVotes as useful_no_count'  => fn ($query) => $query->where('is_useful', false),
        ]);

        return $this->showView([
            'faq'       => $faq,
            'groups'    => $groups,
            'products'  => $products,
            'routePath' => $this->routePath,
        ]);
    }
    public function update(Request $request, Faq $faq)
    {
        $data = $request->validate([
            'title'    => ['required','string','max:255'],
            'answer'  => ['required','string'],
            'group_id' => ['nullable','integer','exists:groups,id'],
            'product_id' => ['nullable','integer','exists:products,id'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);

        $data['order'] = $data['sort_order'] ?? $faq->order;
        unset($data['sort_order']);

        $faq->update($data);

        return $this->updateRedirect($faq);
    }
}