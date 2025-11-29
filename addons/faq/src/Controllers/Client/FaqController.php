<?php

/*
 * This file is part of the CLIENTXCMS project.
 * This file is the property of the CLIENTXCMS association. Any unauthorized use, reproduction, or download is prohibited.
 * For more information, please consult our support: clientxcms.com/client/support.
 * Year: 2024
 */

namespace App\Addons\Faq\Controllers\Client;

use App\Addons\Faq\Models\Faq;
use App\Http\Controllers\Controller;
use App\Models\Store\Group;
use App\Models\Store\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends Controller
{
    protected string $model = Faq::class;
    protected string $viewPath = 'faq::';
    protected string $routePath = 'client.faq';

    public function index(): View
    {
        $faqs = Faq::forContext();

        return view('faq::index', [
            'faqs'          => $faqs,
            'pageTitle'     => __('faq::messages.client.general_title'),
            'pageDescription' => __('faq::messages.client.general_description'),
            'ctaUrl'        => route('front.support.index'),
            'ctaText'       => __('faq::messages.client.cta_text'),
            'ctaButton'     => __('faq::messages.client.cta_button'),
        ]);
    }

    public function group(Group $group): View
    {
        $faqs = Faq::forContext($group);

        return view('faq::index', [
            'group'          => $group,
            'faqs'           => $faqs,
            'pageTitle'      => __('faq::messages.client.group_title', ['name' => $group->name]),
            'pageDescription'=> __('faq::messages.client.group_description', ['name' => $group->name]),
        ]);
    }

    public function product(Product $product): View
    {
        $faqs = Faq::forContext(null, $product);

        return view('faq::index', [
            'product'        => $product,
            'faqs'           => $faqs,
            'pageTitle'      => __('faq::messages.client.product_title', ['name' => $product->name]),
            'pageDescription'=> __('faq::messages.client.product_description', ['name' => $product->name]),
        ]);
    }

    public function usefulness(Request $request, Faq $faq): JsonResponse|RedirectResponse
    {
        $data = $request->validate([
            'is_useful' => ['required', 'boolean'],
        ]);

        $faq->usefulnessVotes()->updateOrCreate(
            ['ip_address' => $request->ip()],
            ['is_useful' => $data['is_useful']]
        );

        $this->loadUsefulnessCounts($faq);

        $message = $data['is_useful']
            ? __('faq::messages.client.feedback_positive')
            : __('faq::messages.client.feedback_negative');

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'counts' => [
                    'yes' => (int) ($faq->useful_yes_count ?? 0),
                    'no'  => (int) ($faq->useful_no_count ?? 0),
                    'total' => $faq->total_votes,
                    'ratio' => $faq->useful_ratio,
                ],
            ]);
        }

        return back()->with('faq_usefulness_'.$faq->id, $message);
    }

    private function loadUsefulnessCounts(Faq $faq): Faq
    {
        return $faq->loadCount([
            'usefulnessVotes as useful_yes_count' => fn ($query) => $query->where('is_useful', true),
            'usefulnessVotes as useful_no_count'  => fn ($query) => $query->where('is_useful', false),
        ]);
    }
}
