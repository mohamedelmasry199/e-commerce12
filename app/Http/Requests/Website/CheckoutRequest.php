<?php

namespace App\Http\Requests\Website;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'first_name'        => ['required', 'string', 'max:255'],
            'last_name'       => ['required', 'string', 'max:255'],
             'user_email'       => ['required', 'email', 'max:255'],
             'user_phone'       => ['required', 'string', 'max:20'],
             'country_id'     => ['required', 'integer', 'exists:countries,id'],
             'governorate_id' => ['nullable', 'integer', 'exists:governorates,id'],
             'city_id'        => ['nullable', 'integer', 'exists:cities,id'],
             'street'      => ['required', 'string', 'max:255'],
             'note'        => ['nullable', 'string', 'max:1000'],
            //  'coupon'      => ['nullable', 'string', 'max:50'],
        ];
    }

    public function attributes(): array
    {
        return [
            'first_name'        => __('checkout.fields.first_name'),
            'last_name'       => __('checkout.fields.last_name'),
            'user_email'       => __('checkout.fields.user_email'),
            'user_phone'       => __('checkout.fields.user_phone'),
            'country_id'     => __('checkout.fields.country_id'),
            'governorate_id' => __('checkout.fields.governorate_id'),
            'city_id'        => __('checkout.fields.city_id'),
            'street'      => __('checkout.fields.street'),
            'note'        => __('checkout.fields.note'),
            'coupon'      => __('checkout.fields.coupon'),
        ];
    }
}

