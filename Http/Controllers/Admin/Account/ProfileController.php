<?php

namespace Modules\User\Http\Controllers\Admin\Account;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\User\Contracts\Authentication;
use Modules\User\Http\Requests\UpdateProfileRequest;
use Modules\User\Repositories\UserRepository;

class ProfileController extends AdminBaseController
{
    /**
     * @var UserRepository
     */
    private $user;

    /**
     * @var Authentication
     */
    private $auth;

    public function __construct(UserRepository $user, Authentication $auth)
    {
        parent::__construct();
        $this->user = $user;
        $this->auth = $auth;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit(): Response
    {
        return view('user::admin.account.profile.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     */
    public function update(UpdateProfileRequest $request): Response
    {
        $user = $this->auth->user();

        $this->user->update($user, $request->all());

        return redirect()->back()
            ->withSuccess(trans('user::messages.profile updated'));
    }
}
