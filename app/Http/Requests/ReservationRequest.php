<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ReservationRequest extends Request
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
            'name'      => 'required|max:50|min:2',
            'forename'  => 'required|max:50|min:2',
            'email'     => 'required|email',
            'nb_people' => 'required|integer|min:1|max:15',
            'arrive_at' => 'required|date',
            'leave_at'  => 'required|date|after:' . $this->input('arrive_at'),
        ];
    }
}
