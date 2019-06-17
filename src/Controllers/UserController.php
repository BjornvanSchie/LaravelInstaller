<?php

namespace BjornvanSchie\LaravelInstaller\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use BjornvanSchie\LaravelInstaller\Helpers\UserManager;
use BjornvanSchie\LaravelInstaller\Helpers\InstalledFileManager;

class UserController extends Controller
{
    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * @param UserManager $userManager
     */
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }


    public function userMenu() {
        return view('vendor.installer.user');
    }

    /**
     * Processes the new user.
     *
     * @param Request $request
     * @param Redirector $redirect
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveUser(Request $request, Redirector $redirect, InstalledFileManager $fileManager)
    {
        $this->userManager->saveUser($request);
        $finalStatusMessage = $fileManager->update();

        return redirect("/");
    }
}
