<?php

namespace BjornvanSchie\LaravelInstaller\Controllers;

use Illuminate\Routing\Controller;
use BjornvanSchie\LaravelInstaller\Helpers\EnvironmentManager;
use BjornvanSchie\LaravelInstaller\Helpers\FinalInstallManager;
use BjornvanSchie\LaravelInstaller\Helpers\InstalledFileManager;
use BjornvanSchie\LaravelInstaller\Events\LaravelInstallerFinished;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param \BjornvanSchie\LaravelInstaller\Helpers\InstalledFileManager $fileManager
     * @param \BjornvanSchie\LaravelInstaller\Helpers\FinalInstallManager $finalInstall
     * @param \BjornvanSchie\LaravelInstaller\Helpers\EnvironmentManager $environment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall, EnvironmentManager $environment)
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        $finalEnvFile = $environment->getEnvContent();

        event(new LaravelInstallerFinished);

        return view('vendor.installer.finished', compact('finalMessages', 'finalStatusMessage', 'finalEnvFile'));
    }
}
