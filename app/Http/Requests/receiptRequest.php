<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class receiptRequest extends FormRequest
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
            'date' => 'required|date', // Ensure the date is provided and valid
            'bank_id' => 'required|exists:banks,id', // Ensure the selected bank exists
            'student_id' => 'required|exists:students,id', // Ensure the selected student exists
            'receipt_payment_heading_id' => 'required|exists:receipt_payment_headings,id', // Ensure the selected heading exists
            'amount' => 'required|numeric|min:0', // Ensure amount is a number and non-negative

        ];
    }
}
