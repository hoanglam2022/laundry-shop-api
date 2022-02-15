<?php

namespace App\Http\Requests;

use App\Models\laundry_shop\MstUser;
use App\Rules\EmailRule;
use App\Rules\EmailUniqueRule;
use App\Rules\FirstNameRule;
use App\Rules\LastNameRule;
use App\Rules\PasswordRule;
use App\Rules\PhoneNumberRule;
use App\Rules\PhoneNumberUniqueRule;
use App\Rules\UsernameRule;
use App\Rules\UsernameUniqueRule;

class MstUserRegisterRequest extends ApiRequest
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
            'username'     => [
                new UsernameRule(),
                new UsernameUniqueRule(new MstUser())],
            'password'     => new PasswordRule(),
            'first_name'   => new FirstNameRule(),
            'last_name'    => new LastNameRule(),
            'email'        => [new EmailRule(), new EmailUniqueRule(new MstUser())],
            'phone_number' => [new PhoneNumberRule(), new PhoneNumberUniqueRule(new MstUser())],
        ];
    }
}
