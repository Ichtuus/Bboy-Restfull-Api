<?php

namespace App\Command\Artists;

use App\Procedure\Artists\ArtistsUpdateProcedure;
use App\Repository\ArtistsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateArtistsListCommand extends Command
{
    private ArtistsRepository $artistsRepository;
    private ArtistsUpdateProcedure $artistsUpdateProcedure;
    private EntityManagerInterface $em;

    public function __construct(
        ArtistsRepository $artistsRepository,
        ArtistsUpdateProcedure $artistsUpdateProcedure,
        EntityManagerInterface $em
    ) {
        parent::__construct();
        $this->artistsRepository = $artistsRepository;
        $this->artistsUpdateProcedure = $artistsUpdateProcedure;
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setName('artists:process:update')
            ->setDescription('Update list of artists');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $currentArtists = $this->artistsRepository->findAll();
        $output->writeln('process start');

        $apiContent = $this->artistsUpdateProcedure->process($currentArtists);

        if (!is_numeric($apiContent)) {
            $output->writeln('');
            $output->writeln(sprintf('process end (%s artists)', $apiContent));
            return Command::SUCCESS;
        }

        $output->writeln('');
        $output->writeln(sprintf($apiContent));
        return Command::FAILURE;


    }
}
