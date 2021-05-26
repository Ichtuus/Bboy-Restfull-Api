<?php

namespace App\Command\Groups;

use App\Procedure\Groups\GroupsUpdateProcedure;
use App\Repository\GroupsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateGroupsListCommand extends Command
{

    private GroupsRepository $groupsRepository;
    private GroupsUpdateProcedure $groupsUpdateProcedure;
    private EntityManagerInterface $em;

    public function __construct(
        GroupsRepository $groupsRepository,
        GroupsUpdateProcedure $groupsUpdateProcedure,
        EntityManagerInterface $em
    ) {
        parent::__construct();
        $this->groupsRepository = $groupsRepository;
        $this->groupsUpdateProcedure = $groupsUpdateProcedure;
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setName('groups:process:update')
            ->setDescription('Update list of groups');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $currentGroups = $this->groupsRepository->findAll();
        $output->writeln('process start');

        $apiContent = $this->groupsUpdateProcedure->process($currentGroups);

        $output->writeln('');
        $output->writeln(sprintf('process end (%s groups)', $apiContent));
        return Command::SUCCESS;
    }
}
