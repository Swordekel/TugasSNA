<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BorrowingRequestUpdateRequest extends FormRequest
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
            'status' => [
                'required',
                'in:Approved,Rejected',
            ],
            'computer_allocation' => [
                'required_if:status,Approved',
                'in:Auto-allocate computer,Allocate computer manually',
            ],
            'room' => [
                'exclude_if:status,Rejected',
                'required_if:computer_allocation,Allocate computer manually',
                'nullable',
                'exists:rooms,id',
            ],
            'computer' => [
                'exclude_if:status,Rejected',
                'nullable',
                'exists:computers,id',
            ],
            'rejection_reason' => [
                'required_if:status,Rejected',
            ],
        ];
    }
}
