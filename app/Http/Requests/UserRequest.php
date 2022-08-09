<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $uniqueEmail = $this->uniqueEmailRules();
        $passwordRequired = $this->passwordRequiredRules();

        return [
            'name'      => 'required',
            'email'     => 'required|email|' . $uniqueEmail,
            'password'  => $passwordRequired,
            'group_id'  => ['required', function ($attribute, $value, $fail) {
                if ($value === '0') $fail('Vui lòng chọn nhóm');
            }]
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'Tên không được để trống',
            'email.required'    => 'Email không được để trống',
            'email.email'       => 'Email không đúng định dạng',
            'email.unique'      => 'Email đã có người sử dụng',
            'password.required' => 'Mật khẩu không được để trống',
            'group_id.required' => 'Nhóm không được để trống',
        ];
    }

    private function uniqueEmailRules()
    {
        $uniqueEmail = 'unique:users';

        if (session('id')) {
            $id = session('id');
            $uniqueEmail .= ',email,' . $id;
        }

        return $uniqueEmail;
    }

    private function passwordRequiredRules()
    {
        $requiredRule = '';

        if (session('passwordRequiredRule'))
            $requiredRule .= session('passwordRequiredRule');

        return $requiredRule;
    }
}