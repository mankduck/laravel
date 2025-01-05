<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th style="width:50px;">
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center">{{ __('messages.promotion.tablePromotion.promotionName') }}</th>
            <th class="text-center">{{ __('messages.promotion.tablePromotion.promotionDiscount') }}</th>
            {{-- @include('backend.dashboard.component.languageTh') --}}
            <th class="text-center">{{ __('messages.promotion.tablePromotion.promotionInfo') }}</th>
            <th class="text-center">{{ __('messages.promotion.tablePromotion.promotionStartDate') }}</th>
            <th class="text-center">{{ __('messages.promotion.tablePromotion.promotionEndDate') }}</th>
            <th class="text-center">{{ __('messages.tableStatus') }}</th>
            <th class="text-center">{{ __('messages.tableAction') }}</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($promotions) && is_object($promotions))
            @foreach ($promotions as $promotion)
                @php
                    $status = '';
                    if (
                        $promotion->endDate !== null &&
                        strtotime($promotion->endDate) - strtotime(now()) <= 0
                    ) {
                        $status = '<span class="text-danger">- Het han</span>';
                    }
                @endphp
                <tr id="{{ $promotion->id }}">
                    <td>
                        <input type="checkbox" value="{{ $promotion->id }}" class="input-checkbox checkBoxItem">
                    </td>
                    <td>
                        <div class="">{{ $promotion->name }} {!! $status !!}</div>
                        <div class="text-success">Ma KM: {{ $promotion->code }}</div>
                    </td>
                    <td>
                        <div class="discount-information text-center">
                            {!! renderDiscountInformation($promotion) !!}
                        </div>
                    </td>
                    {{-- @foreach ($languages as $language)
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
                    @endforeach --}}

                    <td>
                        <div class="">Loai KM: {{ __('module.promotion')[$promotion->method] }}</div>
                    </td>
                    <td>
                        {{ formatDateTable($promotion->startDate) }}
                    </td>
                    <td>
                        {{ $promotion->neverEndDate === 'accept' ? 'Khong gioi han' : formatDateTable($promotion->endDate) }}
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
