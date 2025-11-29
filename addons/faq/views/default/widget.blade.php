@php
    use App\Addons\Faq\Models\Faq;
    if ($group ?? null) {
        $faqs = $faqs ?? Faq::forContext($group);
    } else {
        $faqs = $faqs ?? Faq::forContext(null, $product ?? null);
    }
    $headingTitle = $title ?? __('faq::messages.client.title');
    $headingDescription = $description ?? __('faq::messages.client.description');
    $isGroupContext = !empty($group);
    $usefulnessEnabled = setting('faq_usefulness_enabled', true);
@endphp
@if($faqs->isNotEmpty())
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
  <div class="max-w-2xl mx-auto text-center mb-12 lg:mb-16">
    <h2 class="text-2xl font-bold md:text-3xl md:leading-tight text-gray-800 dark:text-neutral-200">
      {{ $headingTitle }}
    </h2>
    <p class="mt-2 text-gray-600 dark:text-neutral-400">
      {{ $headingDescription }}
    </p>
  </div>

  <div class="max-w-5xl mx-auto">
    @if($isGroupContext)
      <div class="grid sm:grid-cols-2 gap-6 md:gap-10">
        @foreach ($faqs as $faq)
          <article class="group h-full rounded-2xl border border-gray-200 bg-white/90 p-6 shadow-sm transition hover:-translate-y-1 hover:border-indigo-200 hover:shadow-lg dark:bg-slate-900 dark:border-gray-700 dark:shadow-slate-700/[.7]" data-faq-usefulness-group="{{ $faq->id }}">
            <div class="flex gap-4">
              <div class="mt-1 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 ring-1 ring-indigo-100 transition group-hover:bg-indigo-100 dark:bg-neutral-800 dark:text-indigo-300 dark:ring-neutral-700">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l3 3m-3-3l-3 3m12-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div class="grow">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-neutral-100">
                  {{ $faq->trans('title') }}
                </h3>
                <p class="mt-2 text-gray-600 leading-relaxed dark:text-neutral-400">
                  {!! nl2br($faq->trans('answer')) !!}
                </p>

                @if($usefulnessEnabled)
                  <div class="mt-4 border-t border-dashed border-gray-200 pt-4 dark:border-neutral-700">
                    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-neutral-400" data-faq-usefulness-stats data-template="{{ __('faq::messages.client.useful_stats_template_raw') }}" data-empty="{{ __('faq::messages.client.useful_prompt') }}">
                      <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                      </svg>
                      <span data-faq-usefulness-copy>
                        @if(($faq->total_votes ?? 0) > 0)
                          {{ __('faq::messages.client.useful_stats_template', ['yes' => $faq->useful_yes_count ?? 0, 'total' => $faq->total_votes, 'percent' => $faq->useful_ratio ?? 0]) }}
                        @else
                          {{ __('faq::messages.client.useful_prompt') }}
                        @endif
                      </span>
                    </div>

                    <div class="mt-3 flex flex-wrap gap-2">
                      <button type="button" class="inline-flex items-center gap-1 rounded-full border border-gray-200 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 transition hover:border-indigo-500 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 disabled:opacity-60 dark:border-gray-600 dark:bg-neutral-900 dark:text-gray-200" data-faq-usefulness-button data-useful="1" data-endpoint="{{ route('client.faq.usefulness', $faq) }}">
                        <i class="bi bi-hand-thumbs-up"></i> {{ __('faq::messages.client.useful_yes') }}
                      </button>
                      <button type="button" class="inline-flex items-center gap-1 rounded-full border border-gray-200 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 transition hover:border-rose-500 hover:text-rose-600 focus:outline-none focus:ring-2 focus:ring-rose-500 disabled:opacity-60 dark:border-gray-600 dark:bg-neutral-900 dark:text-gray-200" data-faq-usefulness-button data-useful="0" data-endpoint="{{ route('client.faq.usefulness', $faq) }}">
                        <i class="bi bi-hand-thumbs-down"></i> {{ __('faq::messages.client.useful_no') }}
                      </button>
                    </div>

                    <p class="mt-2 text-sm text-emerald-600 min-h-[1.25rem]" data-faq-feedback>
                      {{ session('faq_usefulness_'.$faq->id) }}
                    </p>
                  </div>
                @endif
              </div>
            </div>
          </article>
        @endforeach
      </div>
    @else
      <div class="rounded-2xl border border-gray-200 bg-white/90 shadow-sm dark:border-gray-700 dark:bg-slate-900 dark:shadow-slate-700/[.7]">
        <div class="divide-y divide-gray-200 dark:divide-neutral-700">
          @foreach ($faqs as $faq)
            <div class="flex flex-col gap-2 px-5 py-4 md:px-6" data-faq-usefulness-group="{{ $faq->id }}">
              <div class="flex items-start gap-3">
                <div class="mt-1 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 ring-1 ring-indigo-100 dark:bg-neutral-800 dark:text-indigo-300 dark:ring-neutral-700">
                  <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l3 3m-3-3l-3 3m12-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <div class="grow">
                  <h3 class="text-base font-semibold text-gray-900 dark:text-neutral-100">
                    {{ $faq->trans('title') }}
                  </h3>
                  <p class="text-sm text-gray-600 leading-relaxed dark:text-neutral-400">
                    {!! nl2br($faq->trans('answer')) !!}
                  </p>
                </div>
              </div>

              @if($usefulnessEnabled)
                <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500 dark:text-neutral-400">
                  <div class="flex items-center gap-2" data-faq-usefulness-stats data-template="{{ __('faq::messages.client.useful_stats_template_raw') }}" data-empty="{{ __('faq::messages.client.useful_prompt') }}">
                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    <span data-faq-usefulness-copy>
                      @if(($faq->total_votes ?? 0) > 0)
                        {{ __('faq::messages.client.useful_stats_template', ['yes' => $faq->useful_yes_count ?? 0, 'total' => $faq->total_votes, 'percent' => $faq->useful_ratio ?? 0]) }}
                      @else
                        {{ __('faq::messages.client.useful_prompt') }}
                      @endif
                    </span>
                  </div>

                  <div class="flex flex-wrap gap-2">
                    <button type="button" class="inline-flex items-center gap-1 rounded-full border border-gray-200 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 transition hover:border-indigo-500 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 disabled:opacity-60 dark:border-gray-600 dark:bg-neutral-900 dark:text-gray-200" data-faq-usefulness-button data-useful="1" data-endpoint="{{ route('client.faq.usefulness', $faq) }}">
                      <i class="bi bi-hand-thumbs-up"></i> {{ __('faq::messages.client.useful_yes') }}
                    </button>
                    <button type="button" class="inline-flex items-center gap-1 rounded-full border border-gray-200 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 transition hover:border-rose-500 hover:text-rose-600 focus:outline-none focus:ring-2 focus:ring-rose-500 disabled:opacity-60 dark:border-gray-600 dark:bg-neutral-900 dark:text-gray-200" data-faq-usefulness-button data-useful="0" data-endpoint="{{ route('client.faq.usefulness', $faq) }}">
                      <i class="bi bi-hand-thumbs-down"></i> {{ __('faq::messages.client.useful_no') }}
                    </button>
                  </div>

                  <p class="text-sm text-emerald-600 min-h-[1.25rem]" data-faq-feedback>
                    {{ session('faq_usefulness_'.$faq->id) }}
                  </p>
                </div>
              @endif
            </div>
          @endforeach
        </div>
      </div>
    @endif
  </div>
</div>
@else
<div class="max-w-3xl mx-auto px-4 py-8 text-center text-gray-500 dark:text-neutral-400">
  {{ __('faq::messages.client.empty') }}
</div>
@endif

@once
  @if($usefulnessEnabled)
    <script>
      (() => {
        const token = '{{ csrf_token() }}';

        document.addEventListener('click', async (event) => {
          const button = event.target.closest('[data-faq-usefulness-button]');
          if (!button) {
            return;
          }

          event.preventDefault();

          if (button.dataset.loading === 'true') {
            return;
          }

          button.dataset.loading = 'true';
          const endpoint = button.dataset.endpoint;
          const isUseful = button.dataset.useful === '1';
          const group = button.closest('[data-faq-usefulness-group]');
          const feedback = group?.querySelector('[data-faq-feedback]');
          const stats = group?.querySelector('[data-faq-usefulness-stats]');

          if (feedback) {
            feedback.textContent = '';
            feedback.classList.remove('text-rose-600');
          }

          try {
            const response = await fetch(endpoint, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token,
                'X-Requested-With': 'XMLHttpRequest',
              },
              body: JSON.stringify({ is_useful: isUseful }),
            });

            if (!response.ok) {
              throw new Error('Unable to send feedback');
            }

            const payload = await response.json();

            if (stats && payload.counts) {
              const copy = stats.querySelector('[data-faq-usefulness-copy]');
              if (copy) {
              if (payload.counts.total > 0) {
                const template = stats.dataset.template ?? ':percent%';
                copy.textContent = template
                  .replace(':percent', payload.counts.ratio ?? 0)
                  .replace(':yes', payload.counts.yes ?? 0)
                  .replace(':total', payload.counts.total ?? 0);
              } else {
                copy.textContent = stats.dataset.empty ?? '';
              }
              }
            }

            if (feedback && payload.message) {
              feedback.classList.remove('text-rose-600');
              feedback.classList.add('text-emerald-600');
              feedback.textContent = payload.message;
            }
          } catch (error) {
            if (feedback) {
              feedback.textContent = '{{ __('faq::messages.client.feedback_error') }}';
              feedback.classList.remove('text-emerald-600');
              feedback.classList.add('text-rose-600');
            }
            console.error(error);
          } finally {
            button.dataset.loading = 'false';
          }
        });
      })();
    </script>
  @endif
@endonce
