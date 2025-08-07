<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;
use WireElements\Pro\Components\SlideOver\SlideOver;
use WireUi\Traits\WireUiActions;
use Illuminate\Support\Facades\Hash;

class Create extends SlideOver
{
    use WireUiActions;

    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    protected function messages()
    {
        return [
            'name.required' => 'نام کاربر الزامی است',
            'email.required' => 'ایمیل الزامی است',
            'email.email' => 'فرمت ایمیل صحیح نیست',
            'email.unique' => 'این ایمیل قبلاً ثبت شده است',
            'password.required' => 'رمز عبور الزامی است',
            'password.min' => 'رمز عبور باید حداقل 8 کاراکتر باشد',
            'password.confirmed' => 'تکرار رمز عبور مطابقت ندارد',
        ];
    }

    public function save()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $this->notification()->success(
            $title = 'کاربر ایجاد شد',
            $description = 'کاربر جدید با موفقیت ایجاد شد'
        );

        $this->close(andDispatch: ['userCreated']);
    }

    public function render()
    {
        return view('livewire.admin.user.create');
    }
}
