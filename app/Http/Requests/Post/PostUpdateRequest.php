<?php

namespace App\Http\Requests\Post;

use App\Enums\PostStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required', 'min:3'],
            'slug' => ['required', 'min:3'],
            'text' => ['required', 'min:10'],
            'author_id' => ['required', 'numeric'],
            'status' => ['required', Rule::in(PostStatus::Active->value, PostStatus::Draft->value)],
        ];
    }
}
