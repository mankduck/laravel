<div class="col-lg-4">
    <div class="ibox">
        <div class="ibox-title">
            <h5>{{ __('messages.promotion.createPromotion.timeProgram') }}</h5>
        </div>
        <div class="ibox-content">
            <div class="form-row mb20">
                <label for=""
                    class="control-label text-left">{{ __('messages.promotion.createPromotion.startDate') }}<span
                        class="text-danger">(*)</span></label>
                <input type="datetime-local" name="startDate" id="datetime"
                    value="{{ old('startDate', $promotion->startDate ?? '') }}" class="form-control" placeholder=""
                    autocomplete="off" {{ isset($disabled) ? 'disabled' : '' }}>
            </div>
            <div class="form-row mb20">
                <label for=""
                    class="control-label text-left">{{ __('messages.promotion.createPromotion.endDate') }}<span
                        class="text-danger">(*)</span></label>
                <input type="datetime-local" name="endDate" value="{{ old('endDate', $promotion->endDate ?? '') }}"
                    class="form-control" placeholder="" autocomplete="off" {{ isset($disabled) ? 'disabled' : '' }}>
            </div>
            <div class="form-row">
                <div class="uk-flex uk-flex-middle">
                    <input type="checkbox" name="neverEndDate" class="" value="accept" id="neverEnd">
                    <label for=""
                        class="control-label fix-label ml5">{{ __('messages.promotion.createPromotion.noEndDate') }}</label>
                </div>
            </div>
        </div>
    </div>
    <div class="ibox">
        <div class="ibox-title">
            <h5>{{ __('messages.promotion.createPromotion.customer') }}</h5>
        </div>
        @php
            $sourceStatus = old('source', $promotion->sourceStatus ?? null) === 'choose' ? true : false;
        @endphp
        <div class="ibox-content">
            <div class="setting-value">
                <div class="form-row mb20">
                    <div class="uk-flex uk-flex-middle">
                        <input type="radio" name="source" class="chooseSource" value="all" id="allSource"
                            {{ old('source', $promotion->sourceStatus ?? '') === 'all' || !old('source') ? 'checked' : '' }}>
                        <label for="allSource"
                            class="control-label fix-label ml5">{{ __('messages.promotion.createPromotion.allCustomer') }}</label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="uk-flex uk-flex-middle">
                        <input type="radio" name="source" class="chooseSource" value="choose" id="chooseSource"
                            {{ old('source', $promotion->sourceStatus ?? '') === 'choose' ? 'checked' : '' }}>
                        <label for="chooseSource"
                            class="control-label fix-label ml5">{{ __('messages.promotion.createPromotion.chooseCustomer') }}</label>
                    </div>
                </div>
                @if ($sourceStatus)
                    @php
                        $sourceValue = old('sourceValue', $promotion->sourceValue ?? []);
                    @endphp
                    <div class="source-wrapper">
                        <select name="sourceValue[]" class="multipleSelect2" id="" multiple>
                            @foreach ($sources as $key => $val)
                                <option value="{{ $val->id }}"
                                    {{ in_array($val->id, $sourceValue) ? 'selected' : '' }}>{{ $val->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>

        </div>
    </div>
    <div class="ibox">
        <div class="ibox-title">
            <h5>{{ __('messages.promotion.createPromotion.object') }}</h5>
        </div>
        <div class="ibox-content">
            <div class="form-row mb20">
                <div class="uk-flex uk-flex-middle">
                    <input type="radio" name="applyStatus" class="chooseApply" value="all" id="allApply"
                        {{ old('applyStatus', $promotion->applyStatus ?? '') === 'all' || !old('applyStatus') ? 'checked' : '' }}>
                    <label for="allApply"
                        class="control-label fix-label ml5">{{ __('messages.promotion.createPromotion.allObject') }}</label>
                </div>
            </div>
            <div class="form-row">
                <div class="uk-flex uk-flex-middle">
                    <input type="radio" name="applyStatus" class="chooseApply" value="choose" id="chooseApply"
                        {{ old('applyStatus', $promotion->applyStatus ?? '') === 'choose' ? 'checked' : '' }}>
                    <label for="chooseApply"
                        class="control-label fix-label ml5">{{ __('messages.promotion.createPromotion.chooseObject') }}</label>
                </div>
            </div>
            @php
                $applyStatus = old('applyStatus', $promotion->applyStatus ?? '') === 'choose' ? true : false;
                $applyValue = old('applyValue', $promotion->applyValue ?? []);
                // dd($applyValue);

                $applyStatusList = __('module.applyStatus');
            @endphp
            @if ($applyStatus)
                <div class="apply-wrapper">
                    <select name="applyValue[]" class="multipleSelect2 conditionItem" id="" multiple>
                        @foreach ($applyStatusList as $key => $val)
                            <option value="{{ $val['id'] }}">
                                {{ $val['name'] }}
                            </option>
                        @endforeach
                    </select>
                    <div class="wrapper-condition"></div>
                </div>
            @endif
        </div>
    </div>
</div>
<input type="hidden" name="" class="applyStatusList" value="{{ json_encode(__('module.applyStatus')) }}">
<input type="hidden" name="" class="conditionItemSelected" value="{{ json_encode($applyValue) }}">

@if (count($applyValue))
    @foreach ($applyValue as $key => $val)
        <input type="hidden" name="" class="condition_input_{{ $val }}"
            value="{{ json_encode(old($val)) }}">
    @endforeach
@endif

<input type="hidden" name="" class="preload_promotionMethod"
    value="{{ old('method', $promotion->method ?? null) }}">

<input type="hidden" name="" class="preload_select_product_and_quantity"
    value="{{ old('module_type', $promotion->module_type ?? null) }}">

<input type="hidden" name="" class="input_order_amount_range"
    value="{{ json_encode(old('promotion_order_amount_range', $promotion->promotion_order_amount_range ?? null)) }}">

<input type="hidden" name="" class="input_product_and_quantity"
    value="{{ json_encode(old('product_and_quantity', $promotion->product_and_quantity ?? null)) }}">

<input type="hidden" name="" class="input_object"
    value="{{ json_encode(old('object', $promotion->object ?? null)) }}">
