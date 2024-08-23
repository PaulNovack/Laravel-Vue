<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderTasksRequest extends FormRequest
{
    public function authorize()
    {
        // Set to true if all users are allowed to reorder tasks,
        // or implement your logic to determine if the user is authorized
        return true;
    }

    public function rules()
    {
        return [
            'tasks' => 'required|array',
            'tasks.*.id' => 'required|integer|exists:tasks,id',
            'tasks.*.priority' => 'required|integer',
        ];
    }
}
