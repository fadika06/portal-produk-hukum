<?php

namespace Bantenprov\ProdukHukum\Console\Commands;

use Illuminate\Console\Command;

/**
 * The ProdukHukumCommand class.
 *
 * @package Bantenprov\ProdukHukum
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class ProdukHukumCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bantenprov:produk-hukum';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Demo command for Bantenprov\ProdukHukum package';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Welcome to command for Bantenprov\ProdukHukum package');
    }
}
