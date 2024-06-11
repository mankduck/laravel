<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th style="width:50px;">
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center">{{ __('messages.tablePromotion.promotionName') }}</th>
            <th class="text-center">{{ __('messages.tablePromotion.promotionKey') }}</th>
            @include('backend.dashboard.component.languageTh')
            <th class="text-center">{{ __('messages.tablePromotion.promotionModel') }}</th>
            <th class="text-center">{{ __('messages.tableStatus') }}</th>
            <th class="text-center">{{ __('messages.tableAction') }}</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($promotions) && is_object($promotions))
            @foreach ($promotions as $promotion)
                <tr id="{{ $promotion->id }}">
                    <td>
                        <input type="checkbox" value="{{ $promotion->id }}" class="input-checkbox checkBoxItem">
                    </td>
                    <td>
                        {{ $promotion->name }}
                    </td>
                    <td>
                        {{ $promotion->keyword }}
                    </td>
                    @foreach ($languages as $language)
                        @if (session('app_locale') === $language->canonical)
                            @continue
                        @endif
                        @php
                            $translated = isset($promotion->description[$language->id]) ? 1 : 0;
                        @endphp
                        <td class="text-center">
                            <a class="{{ $translated == 1 ? '' : 'text-danger' }}"
                                href="{{ route('promotion.translate', ['languageId' => $language->id, 'id' => $promotion->id]) }}">
                                {{ $translated == 1 ? 'Đã dịch' : 'Chưa dịch' }}
                            </a>
                        </td>
                    @endforeach

                    <td>
                        {{ $promotion->short_code ?? '-' }}
                    </td>
                    <td class="text-center js-switch-{{ $promotion->id }}">
                        <input type="checkbox" value="{{ $promotion->publish }}" class="js-switch status "
                            data-field="publish" data-model="{{ $config['model'] }}"
                            {{ $promotion->publish == 2 ? 'checked' : '' }} data-modelId="{{ $promotion->id }}" />
                    </td>
                    <td class="text-center">
                        <a href="{{ route('promotion.edit', $promotion->id) }}" class="btn btn-success"><i
                                class="fa fa-edit"></i></a>
                        <a href="{{ route('promotion.delete', $promotion->id) }}" class="btn btn-danger"><i
                                class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
{{ $promotions->links('pagination::bootstrap-4') }}
