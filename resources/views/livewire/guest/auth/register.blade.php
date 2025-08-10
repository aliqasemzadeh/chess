<section class="bg-gray-50 dark:bg-gray-900">
  <div class="mx-auto grid h-screen max-w-screen-xl px-4 py-8 lg:grid-cols-12 lg:gap-20 lg:py-16">
    <div class="w-full place-self-center lg:col-span-6">
      <div class="mx-auto max-w-lg rounded-lg bg-white p-4 shadow-sm dark:bg-gray-800 sm:p-6">
        <a href="#" class="mb-4 inline-flex items-center text-xl font-semibold text-gray-900 dark:text-white sm:mb-6">
          <img class="ml-2 h-8 w-8" src="/images/logo.svg" alt="logo" />
          Flowbite
        </a>
        <h1 class="mb-2 text-2xl font-extrabold leading-tight tracking-tight text-gray-900 dark:text-white">ساخت حساب کاربری</h1>
        <p class=" text-gray-500 dark:text-gray-400">حساب دارید؟ <a class="font-medium text-primary-700 hover:underline dark:text-primary-500" href="#">وارد شوید</a></p>
        <form class="mt-4 space-y-4 sm:mt-6 sm:space-y-6" action="#">
          <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
            <div class="sm:col-span-2">
              <label for="name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">نام و نام خانوادگی</label>
              <input type="text" id="name" name="name" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-primary-600 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500 sm:text-sm" placeholder="مثال: علی رضایی" required />
            </div>
            <div>
              <label for="email" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">ایمیل</label>
              <input type="email" id="email" name="email" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-primary-600 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500 sm:text-sm" placeholder="name@company.com" required />
            </div>
            <div>
              <label for="password" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">رمز عبور</label>
              <input type="password" id="password" name="password" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-primary-600 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500 sm:text-sm" placeholder="••••••••" required />
            </div>
            <div>
              <label for="password_confirmation" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">تایید رمز عبور</label>
              <input type="password" id="password_confirmation" name="password_confirmation" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-primary-600 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500 sm:text-sm" placeholder="••••••••" required />
            </div>
          </div>

          <div class="flex items-start">
            <div class="flex h-5 items-center">
              <input id="terms" type="checkbox" class="focus:ring-3 h-4 w-4 rounded-sm border border-gray-300 bg-gray-50 focus:ring-primary-300 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600" required />
            </div>
            <label for="terms" class="mr-3 text-sm text-gray-500 dark:text-gray-300">قوانین و شرایط را می‌پذیرم</label>
          </div>

          <button type="submit" class="w-full rounded-lg bg-primary-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">ثبت نام</button>
        </form>
      </div>
    </div>
    <div class="ml-auto hidden place-self-center lg:col-span-6 lg:flex">
      <img class="mx-auto dark:hidden" src="/images/sign-in.svg" alt="illustration" />
      <img class="mx-auto hidden dark:flex" src="/images/sign-in-dark.svg" alt="illustration" />
    </div>
  </div>
</section>
