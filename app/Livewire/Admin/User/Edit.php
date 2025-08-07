<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;
use WireElements\Pro\Components\SlideOver\SlideOver;
use WireUi\Traits\WireUiActions;
use Illuminate\Support\Facades\Hash;

class Edit extends SlideOver
{
    use WireUiActions;

    public User $user;
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ];
    }

    protected function messages()
    {
        return [
            'name.required' => 'نام کاربر الزامی است',
            'email.required' => 'ایمیل الزامی است',
            'email.email' => 'فرمت ایمیل صحیح نیست',
            'email.unique' => 'این ایمیل قبلاً ثبت شده است',
            'password.min' => 'رمز عبور باید حداقل 8 کاراکتر باشد',
            'password.confirmed' => 'تکرار رمز عبور مطابقت ندارد',
        ];
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        $this->user->update($data);

        $this->notification()->success(
            $title = 'کاربر بروزرسانی شد',
            $description = 'اطلاعات کاربر با موفقیت بروزرسانی شد'
        );

        $this->close(andDispatch: ['userUpdated']);
    }

    public function render()
    {
        return view('livewire.admin.user.edit');
    }
}
