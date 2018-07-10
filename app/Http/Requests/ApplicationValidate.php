<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class ApplicationValidate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
//            'loan_id' => 'required|unique:loan.applications,loan_no|unique:loan.applications,loan_no',
            'loan_id' => ['required',
                Rule::unique('loan.applications', 'loan_no')->where(function ($query) {
                    return $query->where('portfolio', $this->portfolio);
                }),
            ],
            'portfolio' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required:email',
            'ssn' => 'required',
            'state' => 'required',
            'dl_id' => 'required',
            'new_ret' => 'required',
            'ebd' => 'required',
            'voe_ret' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'loan_id.unique' => 'Application already sent for approval',
            'portfolio.required'  => 'Portfolio is required',
            'first_name.required'  => 'First Name is required',
            'last_name.required'  => 'Last Name is required',
            'email.required'  => 'Email is required',
            'ssn.required'  => 'SSN is required',
            'state.required'  => 'State is required',
            'dl_id.required'  => 'Request Code is required',
            'new_ret.required'  => 'Please select new or returning customer',
            'ebd.required'  => 'Ending Balance is required',
            'voe_ret.required'  => 'Please select employment verification',
        ];
    }
}
