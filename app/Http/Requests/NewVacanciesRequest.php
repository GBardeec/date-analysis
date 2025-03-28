<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewVacanciesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'professional_role' => ['required', 'int'],
            'count' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'professional_role.required' => 'Название вакансии обязательна к заполнению',
            'professional_role.int' => 'Название вакансии должно быть числом',
            'count.required' => 'Кол-во вакансий обязательно к заполнению',
            'count.integer' => 'Кол-во вакансий должно быть числом',
            'count.min' => 'Минимальное кол-во вакансий должно быть 1',
        ];
    }
}
