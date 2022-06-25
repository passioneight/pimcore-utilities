<?php

namespace Passioneight\Bundle\PimcoreUtilitiesBundle\Command;

use Pimcore\Console\AbstractCommand as AbstractPimcoreCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractCommand extends AbstractPimcoreCommand
{
    const OPTION_DRY_RUN = "dry-run";

    private bool $isDryRun;
    private bool $isDryRunSupported;

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->addOption(
            self::OPTION_DRY_RUN,
            null,
            InputOption::VALUE_NONE,
            'Executes the command in dry-run mode. Will throw an exception if the command does not support this option.'
        );
    }

    /**
     * @inheritDoc
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);
        $this->isDryRun = $input->getOption(self::OPTION_DRY_RUN);
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if($this->isDryRun()) {
            if(!$this->isDryRunSupported()) {
                throw new \LogicException("The command '{$this->getName()}' doesn't support dry-run mode. Aborting to avoid unwanted execution.");
            }

            $this->io->note('Executing command in DRY-RUN mode.');
        }
    }

    /**
     * @return bool
     */
    protected function isDryRun(): bool
    {
        return $this->isDryRun;
    }

    /**
     * @return bool
     */
    protected function isDryRunSupported(): bool
    {
        return $this->isDryRunSupported ?? false;
    }

    /**
     * @return $this
     */
    protected function enableDryRun(): self
    {
        $this->isDryRunSupported = true;
        return $this;
    }
}
