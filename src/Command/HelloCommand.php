<?php


namespace App\Command;


use App\Service\Greeting;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HelloCommand extends Command
{

    /**
     * @var Greeting
     */
    private $greeting;

    public function __construct(Greeting $greeting)
    {
        $this->greeting = $greeting;
        parent::__construct();
    }

    public function configure(): void
    {
        $this->setName('app.say-hello')
            ->setDescription('Says hello to user')
            ->addArgument('name', InputArgument::REQUIRED)
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $name = $input->getArgument('name');
        $output->writeln([
            'Hello from the app',
            '==================',
        ]);
        $output->writeln($this->greeting->greet($name));
    }
}