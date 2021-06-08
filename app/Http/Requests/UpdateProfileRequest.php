<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
  public function rules(): array
  {
    return [
      'name' => 'required',
      'email' => ['required', 'email', Rule::unique('users', 'email')->ignore(Auth::id())],
      'metas.address' => 'required'
    ];
  }

  public function authorize(): bool
  {
    return true;
  }
}
