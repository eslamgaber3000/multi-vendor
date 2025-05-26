<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressForm extends FormRequest
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

            'addr.pilling.first_name' => 'required|string|max:30|min:3',
            'addr.pilling.last_name' => 'required|string|max:30|min:3',
            'addr.pilling.email' => 'required|email',
            'addr.pilling.phone_number' => 'required|string',
            'addr.pilling.mailing_address' => 'nullable|string|max:100|min:10',
            'addr.pilling.postal_code' => 'nullable|string',
            'addr.pilling.country' => 'required|string|min:2|max:3',
            'addr.pilling.state' => 'nullable|string',
            'addr.pilling.city' => 'required|string|min:3|max:20',
            'addr.shipping.first_name' => 'required|string|max:30|min:3',
            'addr.shipping.last_name' => 'required|string|max:30|min:3',
            'addr.shipping.email' => 'required|email',
            'addr.shipping.phone_number' => 'required|string',
            'addr.shipping.mailing_address' => 'nullable|string|max:100|min:10',
            'addr.shipping.postal_code' => 'nullable|string',
            'addr.shipping.country' => 'required|string|min:2|max:3',
            'addr.shipping.state' => 'nullable|string',
            'addr.shipping.city' => 'required|string|min:3|max:20',

        ];
    }


    public function messages()
    {
        return [
            //pilling first name
            'addr.pilling.first_name.required' => 'The first name can not be empty ',
            'addr.pilling.first_name.max' => 'The first name can not be more than 30 character',
            'addr.pilling.first_name.min' => 'The first name can not be less than 3 character ',
            // pilling last name
            'addr.pilling.last_name.required' => 'The first name can not be empty ',
            'addr.pilling.last_name.max' => 'The first name can not be more than 30 character',
            'addr.pilling.last_name.min' => 'The first name can not be less than 3 character ',
            //pilling email
            'addr.pilling.email.required' => 'the email Failed is required',
            'addr.pilling.email.email' => 'Invalid email',
            //pilling phone number
            'addr.pilling.phone_number.required' => 'can not be empty',
            //pilling mailing address
            'addr.pilling.mailing_address.max' => 'mailing address is too long',
            'addr.pilling.mailing_address.min' => 'mailing address is too small',
            
            //pilling country
            'addr.pilling.country.required' => 'The Country field is required',
            'addr.pilling.country.min' => 'Invalid Country Code',
            'addr.pilling.country.max' => 'Invalid Country Code',

            //pilling city
            'addr.pilling.city.required' => 'the city field can not be empty',
            'addr.pilling.city.max' => 'the city field can not be grater than 30 character',
            'addr.pilling.city.min' => 'the city field can not be less than 3 character',

            // shipping first name
            'addr.shipping.first_name.required' => 'The first name can not be empty ',
            'addr.shipping.first_name.max' => 'The first name can not be more than 30 character',
            'addr.shipping.first_name.min' => 'The first name can not be less than 3 character ',
            // shipping last name
            'addr.shipping.last_name.required' => 'The first name can not be empty ',
            'addr.shipping.last_name.max' => 'The first name can not be more than 30 character',
            'addr.shipping.last_name.min' => 'The first name can not be less than 3 character ',

            //shipping email
            'addr.shipping.email.required' => 'the email Failed is required',
            'addr.shipping.email.email' => 'Invalid email',

            //shipping phone number
            'addr.shipping.phone_number.required' => 'can not be empty',

            //shipping mailing address
            'addr.shipping.mailing_address.max' => 'mailing address is too long',
            'addr.shipping.mailing_address.min' => 'mailing address is too small',
            
            //shipping country
            'addr.shipping.country.required' => 'The Country field is required',
            'addr.shipping.country.min' => 'Invalid Country Code',
            'addr.shipping.country.max' => 'Invalid Country Code',

            //shipping city
            'addr.shipping.city.required' => 'the city field can not be empty',
            'addr.shipping.city.max' => 'the city field can not be grater than 30 character',
            'addr.shipping.city.min' => 'the city field can not be less than 3 character',

        ];
    }
}
