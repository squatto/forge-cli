<?php

namespace App\Commands;

use App\Support\Configuration;
use Laravel\Forge\Forge;

class DeployLogCommand extends ForgeCommand
{
    protected $signature = 'deploy:log';

    protected $description = 'View the latest deployment log';

    public function handle(Forge $forge, Configuration $configuration)
    {
        if (! $this->ensureHasToken()) {
            return 1;
        }

        if (! $this->ensureHasForgeConfiguration()) {
            return 1;
        }

        $serverId = $configuration->get('server');
        $siteId = $configuration->get('id');

        $this->info('Retrieving the latest deployment log...');

        $log = $forge->siteDeploymentLog($serverId, $siteId);

        $this->info('');
        $this->info('---------- BEGIN DEPLOYMENT LOG ----------');
        $this->line($log);
        $this->info('----------- END DEPLOYMENT LOG -----------');
    }
}
