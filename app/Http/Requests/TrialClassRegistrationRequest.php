<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrialClassRegistrationRequest extends FormRequest
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
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'phone' => str_replace([' ', '-'], '', $this->phone),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'gurdian_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:100',
            'occupation' => 'required|string|max:100',
            'country' => 'required|string|max:50',
            'hear_from' => 'required|string|max:20',
            'hasDevice' => 'nullable|boolean',
            'language' => 'nullable|string|max:20',
            'student_name' => 'required|string|max:100',
            'age' => 'required|integer|min:7|max:16',
            'school' => 'required|string|max:100',
            'gender' => 'required|string|max:10',
            'class_date' => 'required|date',
            'trial_class_id' => 'required|integer',
            'utm_medium' => 'nullable|string|max:100',
        ];
    }
    
    public function messages(): array
    {
        return [
            'gurdian_name.required' => 'Guardian name is required',
            'phone.required' => 'Phone is required',
            'email.required' => 'Email is required',
            'occupation.required' => 'Occupation is required',
            'country.required' => 'Country is required',
            'hear_from.required' => 'Hear from is required',
            'student_name.required' => 'Student name is required',
            'age.required' => 'Age is required',
            'school.required' => 'School is required',
            'gender.required' => 'Gender is required',
            'class_date.required' => 'Class date is required',
            'trial_class_id.required' => 'Class Time is required',
        ];
    }
}
